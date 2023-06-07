<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this 
    @var string $label
    @var string $method
    @val string $id
*/

/*
После того, как в операции добавили перечень параметров (getParametersMeta),
можно автоматически генерировать не только simple вид, но и этот - с параметром
(только в getParamtersMeta добавить возвращение, кроме названия параметра еще и тип)
Но, при этом, можно и оставить возможность указывать шаблон, чтобы рюшечки можно было добавлять индивидуально
*/

?>

<?= Html::beginForm(Url::to(['site/apple-operation', 'method' => $method, 'id' => $id]), 'post', ['class' => 'form-inline']); ?>
    <?= Html::textInput('percent', '0', ['type' => 'number']) ?>
    <?= Html::submitButton($label, ['class' => 'btn btn-success']) ?>
<?= Html::endForm(); ?>
