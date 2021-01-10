<h1 class="display-5">Reports</h1>

<?= $this->fetch("report-tab-navigation-fragment.php", [ 'type' => $type ]); ?>

<div class="row py-3 align-items-center  ">
  <!--<div class="col-2">
  	<div class="form-floating">
	    <select id="year" name="year" class="form-select" onchange="filter(this)">
	    	<option value="">Choose a filter</option>
	  		<?php foreach ($years as $year): ?>
				  <option value="<?= $year->period ?>"><?= $year->period ?></option>
			  <?php endforeach; ?>
		  </select>
		  <label for="floatingSelect">Year</label>
	</div>
  </div>-->
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

<? switch($type): ?>
<? case 'expenses': ?>
  <?= $this->fetch("report-categories-fragment.php", [ 'type' => $type ]); ?>
  <? break; ?>
<? case 'income': ?>
  <?= $this->fetch("report-categories-fragment.php", [ 'type' => $type ]); ?>
  <? break; ?>
<? case 'periods': ?>
  <?= $this->fetch("report-periods-fragment.php"); ?>
  <? break; ?>
<? break; default: ?>
  Should not happen
<?php endswitch ?>