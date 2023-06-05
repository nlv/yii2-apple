<?php

namespace common\models\appleOperations;

use Yii;
use common\models\Apple;

/**
 * Fall ground Operation
 *
 */
class Disapair extends Operation
{

    public function getName()
    {
        return "Удалить";
    }

    protected function preCondition(Apple &$apple, array $params): null|string
    {
        if ($apple->status == Apple::STATUS_HANGING) return "Яблоко висит на дереве";
        if ($apple->status == Apple::STATUS_FELL && $apple->eaten != 100) return "Яблоко не съедено полностью";
        
        return null;
    }

    protected function doOperation(&$apple, $params) 
    {
        $apple->delete();
    }
}
