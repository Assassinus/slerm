<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_default_coins_count".
 *
 * @property int $id
 * @property int $coin_id Монетка
 * @property int $count Количество
 *
 * @property Coin $coin
 */
class ClientDefaultCoinCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_default_coins_count';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coin_id'], 'required'],
            [['coin_id', 'count'], 'integer'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoin()
    {
        return $this->hasOne(Coin::className(), ['id' => 'coin_id']);
    }
}
