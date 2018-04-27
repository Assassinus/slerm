<?php
/**
 * Created by PhpStorm.
 * User: sergeymartiniuk
 * Date: 26.04.18
 * Time: 23:28
 */

namespace app\helpers;

use app\models\ClientDefaultCoinCount;
use app\models\Coin;
use app\models\Good;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\VarDumper;


/**
 * Class ClientHelper
 *
 * @category
 * @package app\helpers
 */

class ClientHelper
{

    /**
     * Выставить количество монет пользователю по умолчанию
     *
     * @return array
     */
    public static function setDefaultCoins ()
    {

        $default = ArrayHelper::map(ClientDefaultCoinCount::find()->asArray()->all(), 'coin_id', 'count');

        Yii::$app->session->set('wallet', Json::encode($default));

        Yii::$app->session->set('balance', 0);

        return $default;

    }


    /**
     * Получить текущие монеты пользователя
     *
     * @return array
     */
    public static function getCoins ()
    {

        if ( !Yii::$app->session->get('wallet') ) {
            $default = self::setDefaultCoins();
        } else {
            $default = Json::decode(Yii::$app->session->get('wallet'));
        }

        return $default;

    }

    /**
     * Пополнить счет
     *
     * @param Coin $coin монетв
     * @return bool
     */
    public static function pay(Coin $coin)
    {

        $coins = self::getCoins();

        if (isset($coins[$coin->id]) && $coins[$coin->id] > 0){
            $coins[$coin->id]--;

            Yii::$app->session->set('wallet', Json::encode($coins));
            Yii::$app->session->set('balance', Yii::$app->session->get('balance') + $coin->nominal);

            return true;

        } else {

            return false;
        }

    }

    /**
     * Получить текущий баланс пользователя
     *
     * @return int
     */
    public static function balance()
    {

        if (Yii::$app->session->get('balance') === null) {
            self::setDefaultCoins();
            return 0;
        }

        return Yii::$app->session->get('balance');

    }

    /**
     * Рассчет сдачи пользователю
     *
     * @param $array_replace
     */
    public static function surrender($array_replace)
    {

        Yii::$app->session->set('balance', 0);


        $coins = self::getCoins();

        foreach ($array_replace as $coin_id => $coin_count) {
            $coins[$coin_id] = ($coins[$coin_id] ?? 0) + $coin_count;
        }


        Yii::$app->session->set('wallet', Json::encode($coins));

    }

    /**
     * Покупка товара
     *
     * @param Good $good
     * @return bool
     */
    public static function buy(Good $good)
    {


        if (Yii::$app->session->get('balance') < $good->price) {
            return false;
        } else {
            Yii::$app->session->set('balance', Yii::$app->session->get('balance') - $good->price);
            return true;
        }


    }

}