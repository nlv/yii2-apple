<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this 
    @var array        $apples
    @var backend\models\forms\AppleGenerator $gen
*/

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <?php $form = ActiveForm::begin(['action' => Url::to(['site/generate-apples'])]); ?>
      
      <?= $form->field($gen, 'count')->textInput() ?>

      <div class="form-group">
        <?= Html::submitButton('Generate', ['class' => 'btn btn-success']) ?>
      </div>

    <?php ActiveForm::end(); ?>

    <?php if(count($apples) == 0): ?>
        <p>Яблок нет</p>
    <?php else: ?>
      <ul>
      <?php foreach ($apples as $a): ?>
        <li><?= "{$a['color']} {$a['status']} {$a['eaten']}" ?></li>
      <?php endforeach; ?>    
      </ul>
    <?php endif; ?>
</div>
