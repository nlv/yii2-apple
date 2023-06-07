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
        if ($apple->fell_at + Apple::ROTTING_PERIOD > time()) return "Время гниения яблока еще не прошло";
        
        return null;
    }

    protected function doOperation(&$apple, $params) 
    {
        $apple->status = Apple::STATUS_ROTTEN;
    }

    public function getTemplateName() { return 'simple'; }

    public function getParamsMeta(): array { return []; }

    public function isDbDuty():bool { return false; }

}
