<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coins".
 *
 * @property int $id
 * @property int $nominal Название монеты
 *
 * @property ClientDefaultCoinCount[] $clientDefaultCoinsCounts
 * @property CoinCount[] $coinsCounts
 */
class Coin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coins';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nominal'], 'required'],
            [['nominal'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nominal' => 'Nominal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientDefaultCoinsCounts()
    {
        return $this->hasMany(ClientDefaultCoinCount::className(), ['coin_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoinsCounts()
    {
        return $this->hasMany(CoinCount::className(), ['coin_id' => 'id']);
    }

}
