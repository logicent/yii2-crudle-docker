<?php

namespace app\controllers;

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Controller;

use League\Csv\Writer;
use mikehaertl\wkhtmlto\Pdf;

class ReportBuilderController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'save-as', 'save'],
                'rules' => [
                    [
                        'actions' => ['index', 'save-as', 'save'],
                        'allow' => true,
                        'roles' => ['@'],
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
        // Determine the report source and find via batch
        // $report = new $modelClassname;

        return $this->render('index');
    }

    public function actionExportCsv($modelName)
    {
        $modelClassname = 'app\\models\\' . (Inflector::id2camel(Inflector::singularize($modelName)));
        $model = new $modelClassname();
        $column_labels = $model->attributeLabels();

        //we fetch the info from a DB using a PDO object
        $rows = (new \yii\db\Query())->select(array_keys($column_labels))
                                   ->from($model->tableName())
                                   ->all();
        //we create the CSV into memory
        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        //we insert the CSV header
        $csv->insertOne($column_labels);

        // The PDOStatement Object implements the Traversable Interface
        // that's why Writer::insertAll can directly insert
        // the data into the CSV
        $csv->insertAll($rows);

        // Because you are providing the filename you don't have to
        // set the HTTP headers Writer::output can
        // directly set them for you
        // The file is downloadable
        $csv->output($modelName . '.csv');
        die;
    }

    public function actionExportPdf()
    {
        // You can pass a filename, a HTML string, an URL or an options array to the constructor
        $pdf = new Pdf('/path/to/page.html');

        // On some systems you may have to set the path to the wkhtmltopdf executable
        // $pdf->binary = 'C:\...';

        if (!$pdf->saveAs('/path/to/page.pdf')) {
            echo $pdf->getError();
        }
    }
}
