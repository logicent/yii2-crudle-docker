<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Controller;

use app\models\forms\LoginForm;
use app\models\forms\ContactForm;
use app\models\forms\PasswordResetRequestForm;
use app\models\forms\ResetPasswordForm;
use app\models\Auth;
use app\models\Email;
use app\models\Person;
use app\models\User;

class SiteController extends Controller
{
    public $layout = 'site';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'logout'],
                'rules' => [
                    [
                        'actions' => ['index', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $this->layout = 'login';
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            $user = Person::findOne(['auth_id' => Yii::$app->user->id]);
            $user->last_login_ip = Yii::$app->request->userIP;
            $user->last_login_at = time();
            $user->logged_on = true;
            $user->save(false);

            return $this->goBack();
        }

        $model->password = ''; // clear the password

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        $user = Person::findOne(['auth_id' => Yii::$app->user->id]);
        $user->logged_on = false;
        $user->save(false);

        // Yii::$app->cache->flush(); // Clear all cache here
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $this->layout = 'login';

        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $user = Auth::findOne([
                'status' => User::STATUS_ACTIVE,
                'email' => $model->email,
            ]);

            if ($user) {
                if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                    $user->generatePasswordResetToken();
                }

                if ($user->save(false))
                {
                    $msg = new \app\models\Email();
                    $msg->from = Yii::$app->params['supportEmail'];
                    $msg->to = $model->email;
                    $msg->subject = Yii::t('app', 'Reset Password Request');

                    $salutation = Yii::t('app', 'Hello') . ' ' . Html::encode($user->username) . ',';
                    $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['reset-password', 'token' => $user->password_reset_token]);

                    $msg->message = Html::tag('p', $salutation);
                    $msg->message .= Html::tag('p', $resetLink);

                    if ($this->sendMail($msg)) {
                        Yii::$app->session->setFlash('success', Yii::t('app', Html::encode('Check your email for further instructions.')));
                        return $this->goHome();
                    }
                }
            }
            else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        $this->layout = 'login';

        try {
            $model = new ResetPasswordForm($token);
        }
        catch (\Exception $e)
        {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword())
        {
            Yii::$app->session->setFlash('success', Yii::t('app', Html::encode("Your new password was saved successfully.")));
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function sendMail($msg)
    {
        $mailer = $this->getMailer();

        $message = $mailer->compose()
                        ->setFrom($msg->from)
                        ->setTo($msg->to)
                        ->setSubject($msg->subject)
                        ->setHtmlBody($msg->message);
        try {  
            $mailer->send($message);
        }
        catch (\Swift_SwiftException $e) {
            // display error encountered
            echo $e->errorInfo[2];
        }
    }

    public function getMailer()
    {
        $model = \app\models\Setup::getSettings(\app\models\setup\SmtpForm::modelClass());

        $config = [
                    'class' => 'yii\swiftmailer\Mailer',
                    'viewPath' => '@app/mail',
                    'useFileTransport' => false,
                    'transport' => [
                        'class' => 'Swift_SmtpTransport',
                        'host' => $model->smtp_host,
                        'username' => $model->smtp_username,
                        'password' => $model->smtp_password,
                        'port' => $model->smtp_port,
                        'encryption' => $model->smtp_encryption,
                    ],
                ];

        return Yii::createObject($config);
    }
}
