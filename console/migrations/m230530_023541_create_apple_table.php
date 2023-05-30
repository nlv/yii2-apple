<?php

use yii\db\Migration;
use common\models\Apple;

/**
 * Handles the creation of table `{{%apple}}`.
 */
class m230530_023541_create_apple_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $colors = implode(',', array_map(fn($i) => "'$i'", [Apple::COLOR_RED, Apple::COLOR_GREEN, Apple::COLOR_YELLOW]));
        $statuses = implode(',', array_map(fn($i) => "'$i'", [Apple::STATUS_HANGING, Apple::STATUS_FELL, Apple::STATUS_ROTTEN]));

        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
	    'color' => $this->string()->notNull()->check("color IN ($colors)"),
	    'appeared_at' => $this->timestamp()->notNull(),
	    'fell_at' => $this->timestamp(),
	    'status' => $this->string()->notNull()->check("status IN ($statuses)"),
	    'eaten' => $this->decimal()->notNull()->defaultValue(0)->check('eaten >= 0 AND eaten <= 100'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apple}}');
    }
}
