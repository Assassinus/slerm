<?php

use yii\db\Migration;

/**
 * Class m180427_015833_add_coins_into_coins_table
 */
class m180427_015833_add_coins_into_coins_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->insert('goods', [
            'id' => 1,
            'title' => 'Чай',
            'amount' => 10,
            'price' => 13,
            'defaults' => 10,
        ]);
        $this->insert('goods', [
            'id' => 2,
            'title' => 'Кофе',
            'amount' => 20,
            'price' => 18,
            'defaults' => 20,
        ]);
        $this->insert('goods', [
            'id' => 3,
            'title' => 'Кофе с молоком',
            'amount' => 20,
            'price' => 21,
            'defaults' => 20,
        ]);
        $this->insert('goods', [
            'id' => 4,
            'title' => 'Сок',
            'amount' => 15,
            'price' => 35,
            'defaults' => 15,
        ]);
        $this->insert('coins', [
            'id' => 1,
            'nominal' => 1,
        ]);
        $this->insert('coins', [
            'id' => 2,
            'nominal' => 2,
        ]);
        $this->insert('coins', [
            'id' => 3,
            'nominal' => 5,
        ]);
        $this->insert('coins', [
            'id' => 4,
            'nominal' => 10,
        ]);
        $this->insert('coins_count', [
            'id' => 1,
            'coin_id' => 1,
            'count' => 100,
            'default_count' => 100,
        ]);
        $this->insert('coins_count', [
            'id' => 2,
            'coin_id' => 2,
            'count' => 100,
            'default_count' => 100,
        ]);
        $this->insert('coins_count', [
            'id' => 3,
            'coin_id' => 3,
            'count' => 100,
            'default_count' => 100,
        ]);
        $this->insert('coins_count', [
            'id' => 4,
            'coin_id' => 4,
            'count' => 100,
            'default_count' => 100,
        ]);
        $this->insert('client_default_coins_count', [
            'id' => 1,
            'coin_id' => 1,
            'count' => 10,
        ]);
        $this->insert('client_default_coins_count', [
            'id' => 2,
            'coin_id' => 2,
            'count' => 30,
        ]);
        $this->insert('client_default_coins_count', [
            'id' => 3,
            'coin_id' => 3,
            'count' => 20,
        ]);
        $this->insert('client_default_coins_count', [
            'id' => 4,
            'coin_id' => 4,
            'count' => 15,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180427_015833_add_coins_into_coins_table cannot be reverted.\n";

        return false;
    }
    */
}
