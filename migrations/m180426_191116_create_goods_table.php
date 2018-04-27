<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m180426_191116_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->comment('Название'),
            'amount' => $this->integer(11)->notNull()->comment('Количество в автомате'),
            'price' => $this->integer(11)->notNull()->comment('Стоимость'),
            'defaults' => $this->integer(11)->notNull()->comment('Количество по умолчанию'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
