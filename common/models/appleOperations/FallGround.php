<?php

namespace common\models\appleOperations;

use Yii;
use common\models\Apple;

/**
 * Fall ground Operation
 *
 */
class FallGround extends Operation
{

    public function getName()
    {
        return "Уронить";
    }

    protected function preCondition(Apple &$apple, array $params): null|string
    {
        if ($apple->status == Apple::STATUS_HANGING) {
            return null;
        } else {
            return "Яблоко не висит на дереве";
        }
    }

    protected function doOperation(&$apple, $params) 
    {
        $apple->status = Apple::STATUS_FELL;
        $apple->fell_at = time(); // TODO TimeZone
    }
}
