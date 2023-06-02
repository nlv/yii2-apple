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
                        'actions' => ['logout', 'index', 'generate-apples', 'delete-rotten', 'fall-ground', 'rot', 'eat', 'delete'],
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
     * Удалить прогнившие яблоки.
     *
     * @return Response
     */
    public function actionDeleteRotten()
    {
        Apple::deleteAll("status = '" . Apple::STATUS_ROTTEN . "'");

        return $this->goHome();
    }

    /**
     * Уронить яблоко.
     *
     * @param $id
     * @return Response
     */
    public function actionFallGround($id)
    {

        $apple = $this->findApple($id);
        $apple->fallGround();
        $apple->save();

        return $this->goHome();
    }

    /**
     * Сделать яблоко прогнившим.
     *
     * @param $id
     * @return Response
     */
    public function actionRot($id)
    {

        $apple = $this->findApple($id);
        $apple->rot();
        $apple->save();

        return $this->goHome();
    }

    /**
     * Съесть яблоко.
     *
     * @param $id
     * @return Response
     */
    public function actionEat($id)
    {

        // FIXME: Валидация percent
        // FIXME: Проверка на наличие percent - исключение
        $apple = $this->findApple($id);
        if ($percent = Yii::$app->request->post('percent')) {
            $apple->eat($percent);
            $apple->save();
        }

        return $this->goHome();
    }

    /**
     * Удалить яблоко.
     *
     * @param $id
     * @return Response
     */
    public function actionDelete($id)
    {

        $apple = $this->findApple($id);
        $apple->delete();

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
