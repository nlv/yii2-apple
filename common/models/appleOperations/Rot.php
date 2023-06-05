<?php

namespace common\models\appleOperations;

use Yii;
use common\models\Apple;

/**
 * Fall ground Operation
 *
 */
class Rot extends Operation
{

    public function getName()
    {
        return "Прогнило";
    }

    protected function preCondition(Apple &$apple, array $params): null|string
    {
        if ($apple->status == Apple::STATUS_HANGING) return "Яблоко висит на дереве";
        if ($apple->status == Apple::STATUS_ROTTEN) return "Яблоко уже прогнило";
        if ($apple->eaten == 100) return "Яблоко съедено полностью";
        
        return null;
    }

    protected function doOperation(&$apple, $params) 
    {
        $apple->status = Apple::STATUS_ROTTEN;
    }
}
