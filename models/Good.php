<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $title Название
 * @property int $amount Количество в автомате
 * @property int $price Стоимость
 * @property int $defaults Количество по умолчанию
 */
class Good extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'amount', 'price', 'defaults'], 'required'],
            [['amount', 'price', 'defaults'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'amount' => 'Amount',
            'price' => 'Price',
            'defaults' => 'Defaults',
        ];
    }


    /**
     * Установить количество товаров по умолчанию
     */
    public static function resetCount() {

        /**
         * @var $goods Good[]
         */
        $goods = Good::find()->all();


        foreach ( $goods as $good ) {
            $good->amount = $good->defaults;
            $good->save();
        }
    }
}
