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

    public function getTemplateName() { return 'simple'; }

    public function getParamsMeta(): array { return []; }

    /* true - если операция производит действия с базой данных
       пока только для операции disapair (см. соотв. класс) 
       (хотя, наверное, можно было попробовать реализовывать не через delete, а, например, $apple->deleted = 1)

       В данный момент это означает, что клиенту не надо вызывать save,
       и надо позаботится о транзакционности (эту тему совсем не раскрыли в текущей реализации)

       Т.е. сейчас, true фактически означает, что в контроллере при обработке disapair не надо делать save()
       */
    public function isDbDuty(): bool { return true; }

}
