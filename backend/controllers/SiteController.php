<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\Apple;
use backend\models\forms\ApplesGenerator;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'generate-apples', 'delete-rotten', 'apple-operation'],
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $apples = Apple::find()->asArray()->all();
        return $this->render('index', ['apples' => $apples, 'gen' => new ApplesGenerator]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Сгенерировать яблоки.
     *
     * @return Response
     */
    public function actionGenerateApples()
    {
        $gen = new ApplesGenerator();
        if ($gen->load(Yii::$app->request->post())) {
            $gen->generate();
        }

        return $this->goHome();
    }

    /**
     * Удалить прогнившие яблоки.
     *
     * @return Response
     */
    public function actionDeleteRotten()
    {
        Apple::deleteAll("status = '" . Apple::STATUS_ROTTEN . "'");

        return $this->goHome();
    }

    public function actionAppleOperation($id, $method)
    {
        $apple = $this->findApple($id);

        $ops = Apple::getOperations();
        if (!isset($ops[$method])) {
            throw new \Exception("Операция '$method' не реализована");
        }

        $op = $ops[$method];

        $params = [];
        foreach ($op->getParamsMeta() as $p) {
            if (!($v = Yii::$app->request->post($p))) {
                throw new \Exception("Не передан параметр '$p'");
            }
            $params[] = $v;
        }

        $res = $apple->$method(...$params);
        if (is_string($res)) {
            throw new \Exception($res);
        } else if (!$op->isDbDuty()) {
            $apple->save();
        }

        return $this->goHome();

    }


    /**
     * Найти яблоко в базе данных по ид
     * @param integer $id
     * @return Apple
     * @throws NotFoundHttpException если яблоко не найдено
     */
    protected function findApple($id)
    {
        if (($apple = Apple::findOne($id)) !== null) {
            return $apple;
        } else {
            throw new NotFoundHttpException(self::errorCode()[404]);
        }
    }

}
