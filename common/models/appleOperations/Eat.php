<?php

namespace common\models\appleOperations;

use Yii;
use common\models\Apple;

/**
 * Eat Operation
 *
 */
class Eat extends Operation
{

    public function getName()
    {
        return "Откусить";
    }

    public function preCondition(Apple &$apple, array $params = null): null|string
    {
        if (!is_null($params)) {
            if (!isset($params[0])) return "Не указали сколько откусить";
            if (!is_numeric($params[0])) return "Не верный формат процента, сколько откусить";
            if ($params[0] < 0 || $params[0] > 100) return "Не верный формат процента, сколько откусить";
            if ($apple->eaten + $params[0] > 100) return "Попытались откусить больше чем осталось";
        }

        if ($apple->status == Apple::STATUS_HANGING) return "Яблоко висит на дереве";
        if ($apple->status == Apple::STATUS_ROTTEN) return "Яблоко прогнило";

        return null;
    }

    protected function doOperation(&$apple, $params) 
    {
        $apple->eaten += $params[0];
    }

    public function getTemplateName() { return 'eat'; }

    public function getParamsMeta(): array { return ['percent']; }

    public function isDbDuty():bool { return false; }

}
