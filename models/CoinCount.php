<?php

namespace app\models;

use app\helpers\ClientHelper;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "coins_count".
 *
 * @property int $id
 * @property int $coin_id Монета
 * @property int $count Количество в автомате
 * @property int $default_count Количество по умолчению
 *
 * @property Coin $coin
 */
class CoinCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coins_count';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coin_id'], 'required'],
            [['coin_id', 'count', 'default_count'], 'integer'],
            [['coin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Coin::className(), 'targetAttribute' => ['coin_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'coin_id' => 'Coin ID',
            'count' => 'Count',
            'default_count' => 'Default Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoin()
    {
        return $this->hasOne(Coin::className(), ['id' => 'coin_id']);
    }


    /**
     * Рассчитать сдачу аппарата
     * @param $balance
     * @return int
     */
    public static function calculateSurrender($balance)
    {
        /**
         * @var $coins Coin[]
         */
        $coins = Coin::find()->orderBy(['nominal' => SORT_DESC])->all();

        $coins_count = ArrayHelper::map(CoinCount::find()->all(), 'coin_id', 'count');

        $surrender = $balance;

        $array_replace = [];


        foreach ($coins as $coin) {

            $need = (int)($surrender / $coin->nominal);

            $minus = ( $need -  ($coins_count[$coin->id] ?? 0) > 0 ) ? ($coins_count[$coin->id] ?? 0) : $need;

            $array_replace[$coin->id] = $minus;

            $surrender -= $minus * $coin->nominal;

        }


        if(!$surrender) {

            ClientHelper::surrender($array_replace);

            foreach ($array_replace as $coin_id => $coin_count) {
                $new_coin_count = CoinCount::findOne($coin_id);
                $new_coin_count->count -= $coin_count;
                $new_coin_count->save();

            }
        }

        return $surrender;

    }

    /**
     * Установить количество монет в аппарате по умолчанию
     */
    public static function resetCount() {

        /**
         * @var $coins CoinCount[]
         */
        $coins = CoinCount::find()->all();


        foreach ( $coins as $coin ) {
            $coin->count = $coin->default_count;
            $coin->save();
        }
    }
}
