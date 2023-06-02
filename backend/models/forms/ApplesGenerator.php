<?php

namespace backend\models\forms;

use common\models\Apple;

use Yii;
use yii\base\Model;

/**
 * Apples Generator form
 */
class ApplesGenerator extends Model
{
    public $count;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['count', 'required'],
            ['count', 'integer', 'min' => 0, 'max' => 100],
            ['count', 'default', 'value' => 0],
        ];
    }

    public function generate()
    {
        $colors_count = count(Apple::colors()) - 1;
        for ($i = 1; $i <= $this->count; $i++)
        {
            $apple = new Apple((Apple::colors())[rand(0,$colors_count)]);
            $apple->save();
        }
    }

}
