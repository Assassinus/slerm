<?php

use yii\db\Migration;

/**
 * Handles the creation of table `coins_counts`.
 */
class m180426_194551_create_coins_count_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('coins_count', [
            'id' => $this->primaryKey(),
            'coin_id' => $this->integer()->notNull()->comment('Монета'),
            'count' => $this->integer()->defaultValue(0)->notNull()->comment('Количество в автомате'),
            'default_count' => $this->integer()->defaultValue(100)->notNull()->comment('Количество по умолчению'),
        ]);

        $this->addForeignKey(
            'fk-coins_count-coin_id',
            'coins_count',
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
            'fk-coins_count-coin_id',
            'coins_count'
        );

        $this->dropTable('coins_count');
    }
}
