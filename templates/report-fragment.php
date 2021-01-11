<h1 class="display-5">Reports</h1>

<?= $this->fetch("report-tab-navigation-fragment.php", [ 'type' => $type ]); ?>

<div class="row py-3 align-items-center  ">
  <div class="col-2">
  	<div class="form-floating">
    <select id="month" name="month" class="form-select" onchange="filter(this)">
    	<option value="">Choose a filter</option>
  		<?php foreach ($months as $monthItem): ?>
			  <option <?= $monthItem->period == $month ? 'selected' : '' ?> value="<?= $monthItem->period ?>"><?= $monthItem->period ?></option>
		  <?php endforeach; ?>
	  </select>
	  <label for="floatingSelect">Month</label>
	</div>

  </div>
</div>

<?php switch($type): ?>
<?php case 'expenses': ?>
  <?= $this->fetch("report-categories-fragment.php", [ 'type' => $type ]); ?>
  <? break; ?>
<?php case 'income': ?>
  <?= $this->fetch("report-categories-fragment.php", [ 'type' => $type ]); ?>
  <?php break; ?>
<?php case 'periods': ?>
  <?= $this->fetch("report-periods-fragment.php"); ?>
  <? break; ?>
<?php break; default: ?>
  Should not happen
<?php break; endswitch ?>