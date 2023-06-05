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
      
      <?= $form->field($gen, 'count')->textInput(['class' => 'col-2']) ?>
      <?= Html::submitButton('Создать яблоки', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>

    <?php if(count($apples) == 0): ?>
        <p>Яблок нет</p>
    <?php else: ?>
      <?= Html::a('Удалить прогнившие', Url::to(['site/delete-rotten'], true)) ?>
      <ul>
      <?php foreach ($apples as $a): ?>
        <?php $appeared_at = DateTime::createFromFormat('U',$a['appeared_at'])->format("Y-m-d H:i:s")?> 
        <?php 
          if ($a['fell_at']) {
              $fell_at = DateTime::createFromFormat('U',$a['fell_at']);
              $fell_passed = (new DateTime('now'))->diff($fell_at);
              $fell_status = "{$fell_at->format('Y-m-d H:i:s')} (прошло {$fell_passed->format('%h')} часов {$fell_passed->format('%i')} минут)";
          } else {
              $fell_at = '';
              $fell_passed = '';
              $fell_status = '';
          }
        ?> 
        <li>
            <?= "{$a['color']} {$a['status']} {$a['eaten']} {$fell_status}"?> 
            <?= Html::a('Уронить', Url::to(['site/fall-ground', 'id' => $a['id']], true)) ?>
            <?= Html::a('Прогнило', Url::to(['site/rot', 'id' => $a['id']], true)) ?>
            <?= Html::a('Удалить', Url::to(['site/disapair', 'id' => $a['id']], true)) ?>

            <?= Html::beginForm(Url::to(['site/eat', 'id' => $a['id']]), 'post', ['class' => 'form-inline']); ?>
              <?= Html::textInput('percent', '0', ['type' => 'number']) ?>
              <?= Html::submitButton('Откусить', ['class' => 'btn btn-success']) ?>
            <?= Html::endForm(); ?>
            <br/>
        </li>
      <?php endforeach; ?>    
      </ul>
    <?php endif; ?>
</div>
