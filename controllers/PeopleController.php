<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

use app\models\Auth;
use app\models\People;
use app\models\Person;
use app\models\PersonSearch;

use app\models\forms\UploadForm;

class PeopleController extends BaseController
{
    public function init()
    {
        $this->_uploadForm = new UploadForm();
        $this->_model_attribute = 'avatar';
        $this->_model_classname = Person::class;
        $this->sidebar = '_sidebar';

        $this->modelClass = 'app\\models\\People';

        return parent::init();
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'view', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['Update Person', 'System Manager', 'Administrator'],
                        'roleParams' => function() {
                            return ['model' => Person::findOne(Yii::$app->request->get('id'))];
                        },
                        // 'matchCallback' => function ($rule, $action)
                        // {
                        //     $model = Person::findOne(Yii::$app->request->get('id'));
                        //     return  Yii::$app->user->can('Update Own Person', ['model' => $model]);
                        // }
                    ],
                    [
                        'actions' => ['create', 'delete'],
                        'allow' => true,
                        'roles' => ['System Manager', 'Administrator'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new PersonSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->sidebar = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $auth = Auth::findOne(['id' => $id]);
        $person = Person::findOne($auth->id);

        $authMan = Yii::$app->authManager;
        $roles = $authMan->getRolesByUser($auth->id);

        // $person->role will be overwritten unless multi-role assignments are supported
        foreach ($roles as $id => $role)
            $person->role = $role->name;

        $auth->getStatusLabel();

        $this->setFormSidebarData($person);
        $this->_model_id = $person->id;
        $this->_model_file_path = $person->avatar;

        return $this->render('view', [
            'auth' => $auth,
            'person' => $person,
        ]);
    }

    public function actionCreate()
    {
        $auth = new Auth();
        $person = new Person();
        
        if ($auth->load(Yii::$app->request->post(), 'Auth'))
        {
            $auth->id = Yii::$app->security->generateRandomString(6);

            if (!empty($auth->password))
                $auth->setPassword($auth->password);

            $auth->auth_key = Yii::$app->security->generateRandomString();
            
            // $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($auth->save())
                {
                    if ($person->load(Yii::$app->request->post(), 'Person'))
                    {
                        $person->auth_id = $auth->id;
                        if ($person->save())
                        {
                            $authMan = Yii::$app->authManager;
                            $role = $authMan->getRole($person->role);
                            $authMan->assign($role, $auth->id);
                            
                            if (Yii::$app->request->post('Auth')['send_welcome_email'])
                                $this->sendWelcomeMail($auth->email, $auth->username, $auth->password);

                            Yii::$app->session->setFlash('success', 
                                Yii::t('app', 'New User: # ' . $person->full_name . ' was created successfully'));
                            return $this->redirect(['index']);
                        }
                    }
                }
                // $transaction->commit();
            }
            catch (\yii\db\Exception $e)
            {
                // $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->errorInfo[2]);
            }
        }
        
        return $this->render('create', [
            'auth' => $auth,
            'person' => $person,
        ]);
    }

    public function actionUpdate($id)
    {
        $auth = Auth::findOne(['id' => $id]);
        $person = Person::findOne($auth->id);

        $authMan = Yii::$app->authManager;
        $roles = $authMan->getRolesByUser($auth->id);

        // $person->role will be overwritten unless multi-role assignments are supported
        foreach ($roles as $id => $role)
            $person->old_role = $role->name;

        if ($auth->load(Yii::$app->request->post(), 'Auth'))
            $auth->save();

        if ($person->load(Yii::$app->request->post(), 'Person'))
        {
            $person->save();

            // if ($person->old_role !== $person->role)
                $authMan->revokeAll($auth->id);

            $role = $authMan->getRole($person->role);
            $authMan->assign($role, $auth->id);

            Yii::$app->session->setFlash('success', 
                Yii::t('app', 'User: # ' . $person->full_name . ' was updated successfully'));

            return $this->redirect(['index']);
        }

        $this->setFormSidebarData($person);
        $this->_model_id = $person->id;
        $this->_model_file_path = $person->avatar;

        $person->role = $person->old_role;

        return $this->render('update', [
            'auth' => $auth,
            'person' => $person,
        ]);
    }

    public function actionDelete($id)
    {
        $auth = Auth::findOne(['id' => $id]);
        $person = Person::findOne($auth->id);

        // $auth_table = $auth::tableName();
        // $person_table = $person::tableName();
        // $person->deleted_at = date('Y-m-d H:i:s');
        // $deleted = User::STATUS_DELETED;

        if ($auth->load(Yii::$app->request->post(), 'Auth'))
            $auth->status = Auth::STATUS_DELETED;
            $auth->save(false);
            // Yii::$app->db->createCommand("UPDATE $auth_table SET status = '$deleted' WHERE id = '$id'")->execute();

        if ($person->load(Yii::$app->request->post(), 'Person'))
            $person->deleted_at = date('Y-m-d H:i:s');
            $person->save(false);
            // Yii::$app->db->createCommand("UPDATE $person_table SET deleted_at = '$person->deleted_at' WHERE auth_id = '$id'")->execute();


        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = People::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionChangePwd($id)
    {
        $auth = Auth::findOne(['id' => $id]);
 
        if (Yii::$app->request->isAjax && $auth->load(Yii::$app->request->post(), 'Auth'))
        {
            if (!empty($auth->new_password))
            {
                $auth->setPassword($auth->new_password);
                $auth->auth_key = Yii::$app->security->generateRandomString();
                // Active must be a string so ignore validate step
                if ($auth->save(false))
                {
                    $user = Person::findOne(['auth_id' => $id]);
                    $user->logged_on = false;
                    $user->save(false);

                    if (Yii::$app->user->id == $auth->id)
                        Yii::$app->user->logout();
                        // Yii::$app->cache->flush(); // Clear all cache here ?
                    else
                        return $this->asJson(['success' => true]);
                }
            }
        }

        return $this->renderAjax('_changePwd', ['model' => $auth]);
    }

    public function sendWelcomeMail($email, $username, $password)
    {
        $subject = Yii::t('app', 'New User Account - ' . Yii::$app->params['appShortName']);
        $salutation = Yii::t('app', 'Hello') . ' ' . Html::encode($username) . ',';
        $loginLink = Yii::$app->request->hostInfo;

        $message = [
            'salutation' => $salutation,
            'preamble' => "Your new account is created for you. Please see the login details below:",
            'username' => $username,
            'password' => $password,
            'loginLink' => $loginLink,
        ];

        try {
            $mailer = $this->getMailer();
            $mailer->compose(
                            ['html' =>'WelcomeNotification'],
                            ['content' => $content = $message]
                        )
                        ->setFrom(Yii::$app->params['supportEmail'])
                        ->setTo($email)
                        ->setSubject($subject);
            return $mailer->send();
        }
        catch (\Swift_TransportException $e)
        {
            Yii::$app->session->setFlash('error', Yii::t('app', Html::encode('Failed. Welcome mail was not sent.')));
        }
    }
}
