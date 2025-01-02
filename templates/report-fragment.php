<!--<h1 class="display-5">Reports</h1>-->
<?= $this->fetch("report-tab-navigation-fragment.php", [ 'type' => $type, 'months' => $months, 'month' => $month, 'categories_tree' => $categories_tree, 'category_id' => $category_id ]); ?>

<?php switch($type): ?>
<?php case 'expenses': ?>
  <?= $this->fetch("report-categories-fragment.php", [ 'type' => $type, 'category_id' => $category_id ]); ?>
  <? break; ?>
<?php case 'income': ?>
  <?= $this->fetch("report-categories-fragment.php", [ 'type' => $type, 'category_id' => $category_id ]); ?>
  <?php break; ?>
<?php case 'periods': ?>
  <?= $this->fetch("report-periods-fragment.php", [ 'type' => $type, 'category_id' => $category_id ]); ?>
  <? break; ?>
<?php break; default: ?>
  Should not happen
<?php break; endswitch ?>