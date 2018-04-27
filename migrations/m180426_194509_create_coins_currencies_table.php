<?php

use yii\db\Migration;

/**
 * Handles the creation of table `nominal_currencies`.
 */
class m180426_194509_create_coins_currencies_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('coins', [
            'id' => $this->primaryKey(),
            'nominal' => $this->integer()->notNull()->comment('Название монеты'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('coins');
    }
}
