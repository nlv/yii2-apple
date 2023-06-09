<?php

namespace common\models;

use Yii;
// use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use common\models\appleOperations\FallGround;
use common\models\appleOperations\Eat;
use common\models\appleOperations\Rot;
use common\models\appleOperations\Disapair;

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

    const ROTTING_PERIOD = 3600 * 5;

    const COLOR_RED = 'red';
    const COLOR_GREEN = 'green';
    const COLOR_YELLOW = 'yellow';

    const STATUS_HANGING = 'hanging';
    const STATUS_FELL = 'fell';
    const STATUS_ROTTEN = 'rotten';

    public static function getOperations()
    {
        return ['fallGround' => new FallGround, 'eat' => new Eat, 'disapair' => new Disapair, 'rot' => new Rot];
    }

    public static function colors()
    {
        return [self::COLOR_RED, self::COLOR_GREEN, self::COLOR_YELLOW];
    }

    public static function statuses()
    {
        return [self::STATUS_HANGING, self::STATUS_FELL, self::STATUS_ROTTEN];
    }

    function __construct($color = self::COLOR_GREEN, $config = []) {
        // if (!in_array($color, self::colors())) ...

        $this->color = $color;
        $this->status = self::STATUS_HANGING;
        $this->eaten = 0;
        $this->appeared_at = time(); // TODO TimeZone
        parent::__construct($config);
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
	        [['status','color', 'appeared_at', 'eaten'], 'required'],
            ['color', 'in', 'range' => [self::COLOR_RED, self::COLOR_GREEN, self::COLOR_YELLOW]],
            ['status', 'default', 'value' => self::STATUS_HANGING],
            ['status', 'in', 'range' => [self::STATUS_HANGING, self::STATUS_FELL, self::STATUS_ROTTEN]],
            ['eaten', 'number', 'min' => 0, 'max' => 100],
            ['eaten', 'default', 'value' => 0],
        ];
    }

    public function __call ($method, $params)
    {
        if(isset((self::getOperations())[$method])) {
            return ((self::getOperations())[$method])->call($this, $params);
        } else {
            trigger_error('Call to undefined method '.__CLASS__.'::'.$method.'()', E_USER_ERROR);
        }
    }

}
