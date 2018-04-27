<?php

use yii\db\Migration;

/**
 * Handles the creation of table `client_default_coins_count`.
 */
class m180426_203356_create_client_default_coins_count_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('client_default_coins_count', [
            'id' => $this->primaryKey(),
            'coin_id' => $this->integer(11)->notNull()->comment('Монетка'),
            'count' => $this->integer(11)->notNull()->defaultValue(0)->comment('Количество'),
        ]);

        $this->addForeignKey(
            'fk-client_default_coins_count-coin_id',
            'client_default_coins_count',
            'coin_id',
            'coins',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-client_default_coins_count-coin_id',
            'client_default_coins_count'
        );
        $this->dropTable('client_default_coins_count');
    }
}
