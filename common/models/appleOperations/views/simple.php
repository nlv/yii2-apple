<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this 
    @var string $label
    @var string $method
    @val string $id
*/

?>

<?= Html::a($label, Url::to(['site/apple-operation', 'method' => $method, 'id' => $id], true)) ?>
</br>

