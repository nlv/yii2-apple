<?php

/** @var yii\web\View $this 
    @val array        $apples
*/

$this->title = 'My Yii Application';
?>
<div class="site-index">

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
