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

    public abstract function preCondition(Apple &$apple, array $params = null): null|string;

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

    /*
      Список названий параметров, которые должны быть переданы в процедуру выполнения операции.
      Порядок важен. 
      */
    public abstract function getParamsMeta(): array;

    public abstract function getTemplateName();

    protected abstract function doOperation(&$apple, $params);

    /* true - если операция производит действия с базой данных
       пока только для операции disapair (см. соотв. класс) 
       (хотя, наверное, можно было попробовать реализовывать не через delete, а, например, $apple->deleted = 1)

       */
    public abstract function isDbDuty(): bool;

}
