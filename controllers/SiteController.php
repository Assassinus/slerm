<?php

namespace app\controllers;

use app\helpers\ClientHelper;
use app\models\Coin;
use app\models\CoinCount;
use app\models\Good;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $default_client_coins = ClientHelper::getCoins();

        $goods = Good::find()->all();

        $coins = Coin::find()->all();


        $machine_coins = ArrayHelper::map(CoinCount::find()->all(), 'coin_id', 'count');

        return $this->render('index', [
            'goods' => $goods,
            'coins' => $coins,
            'machine_coins' => $machine_coins,
            'default_client_coins' => $default_client_coins,
        ]);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
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
     * Сбросить количество пользовательских монеток
     *
     * @return Response
     */
    public function actionResetClient()
    {
        $default_user_coins = ClientHelper::setDefaultCoins();

        return $this->goHome();
    }

    /**
     * Закидывание монет
     *
     * @return Response
     */
    public function actionPay($id)
    {

        $coin = $this->findCoinModel($id);

        if (ClientHelper::pay($coin)) {
            $coin_count = CoinCount::findOne(['coin_id' => $coin->id]);
            $coin_count->count++;
            $coin_count->save();
        } else {
            Yii::$app->session->setFlash('error', 'Недостаточно средств');
        }


        return $this->goHome();
    }

    /**
     * Сдача
     *
     * @return Response
     */
    public function actionSurrender()
    {

        $balance = ClientHelper::balance();

        if (!$balance){
            return $this->goHome();
        }

        $is_problem = CoinCount::calculateSurrender($balance);

        if ( $is_problem ) {

            Yii::$app->session->setFlash('error', 'Обратитесь в тп в аппарате недостаточно средств');
            return $this->goHome();

        }

        return $this->goHome();
    }

    /**
     * Сбросить количество монеток автомата
     *
     * @return Response
     */
    public function actionResetMachine()
    {
        CoinCount::resetCount();

        Good::resetCount();

        return $this->goHome();
    }

    /**
     * Покупка товара
     *
     * @return Response
     */
    public function actionBuy($id)
    {

        $good = $this->findGoodsModel($id);

        if($good->amount < 1) {

            Yii::$app->session->setFlash('info', 'Нет товаров');

            return $this->goHome();

        }


        if (ClientHelper::buy($good)) {

            $good->amount--;
            $good->save();
            Yii::$app->session->setFlash('info', 'Спасибо');

        } else {

            Yii::$app->session->setFlash('error', 'Необходино пополнить счет');
        }


        return $this->goHome();
    }


    /**
     * Получить модель монеты
     * @param $id
     * @return Response|Coin
     */
    public function findCoinModel( $id )
    {
        $coin = Coin::findOne($id);

        if ($coin){
            return $coin;
        }

        Yii::$app->session->setFlash('info', 'Ошибка');

        return $this->goHome();


    }

    /**
     * Получить модель товара
     * @param $id
     * @return Good|Response
     */
    public function findGoodsModel( $id )
    {
        $goods = Good::findOne($id);

        if ($goods){
            return $goods;
        }

        Yii::$app->session->setFlash('info', 'Ошибка');

        return $this->goHome();


    }

}
