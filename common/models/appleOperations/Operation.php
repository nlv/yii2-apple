<?php

namespace common\models\appleOperations;

use Yii;
use common\models\Apple;

/**
 * Apple Operation
 *
 */
abstract class Operation
{

    protected abstract function preCondition(Apple &$apple, array $params): null|string;

    public function call(Apple &$apple, array $params)
    {
        $check = $this->preCondition($apple, $params);
        if(is_string($check)) {
            return $check;
        } else {
            $this->doOperation($apple, $params);
            return null;
        }
    }

    public abstract function getName();

    protected abstract function doOperation(&$apple, $params);

}
