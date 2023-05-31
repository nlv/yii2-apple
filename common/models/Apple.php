<?php

namespace common\models;

use Yii;
// use yii\base\NotSupportedException;
use yii\db\ActiveRecord;

/**
 * Apple model
 *
 * @property integer $id
 * @property string $color
 * @property integer $appeared_at
 * @property integer $fell_at
 * @property string $status
 * @property float $eaten
 */
class Apple extends ActiveRecord
{
    const COLOR_RED = 'red';
    const COLOR_GREEN = 'green';
    const COLOR_YELLOW = 'yellow';

    const STATUS_HANGING = 'hanging';
    const STATUS_FELL = 'fell';
    const STATUS_ROTTEN = 'rotten';

    public static function colors()
    {
        return [self::COLOR_RED, self::COLOR_GREEN, self::COLOR_YELLOW];
    }


    public static function statuses()
    {
        return [self::STATUS_HANGING, self::STATUS_FELL, self::STATUS_ROTTEN];
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apple}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
	    [['status','color', 'appeared_at', 'eated'], 'required'],
            ['color', 'in', 'range' => [self::COLOR_RED, self::COLOR_GREEN, self::COLOR_YELLOW]],
            ['status', 'default', 'value' => self::STATUS_HANGING],
            ['status', 'in', 'range' => [self::STATUS_HANGING, self::STATUS_FELL, self::STATUS_ROTTEN]],
	    ['eated', 'decimal', 'min' => 0, 'max' => 100],
        ];
    }

    /**
     * Уронить яблоко
     */
    public function fallGround()
    {
        $this->status = self::STATUS_FELL;
    }

    /**
     * Откусить яблоко
     *
     * @param float $val откушенный процент от исходного размера яблока
     */
    public function eat(float $val)
    {
        $this->eaten -= $val;
    }

    /**
     * Отметить, что яблоко стало гнилым
     */
    public function rot()
    {
        $this->status = self::STATUS_ROTTEN;
    }

}
