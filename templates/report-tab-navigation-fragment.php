<ul class="nav nav-tabs">
  <li class="nav-item">
  <a class="nav-link <?= @$type=='periods' ? 'active' : ''?>" aria-current="page" href="/reporting/periods">
    Monthly</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= @$type=='expenses' ? 'active' : ''?>" aria-current="page" href="/reporting/expenses">Expenses</a>
  </li>
  <li class="nav-item">
  <a class="nav-link <?= @$type=='income' ? 'active' : ''?>" aria-current="page" href="/reporting/income">
    Income</a>
  </li>

  <?php if(@$type!='periods'): ?>

  <li class="nav-item">
    <div class="">
      <div class="">
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
  </li>

  <?php endif; ?>
  
  <?php if(@$type=='periods'): ?>
  
    <li class="nav-item">
      <div class="">
        <div class="">
          <div class="form-floating">
            <select id="category_id" name="category_id" class="form-select" onchange="filter(this)">
              <option value="">Choose a filter</option>
              <?php foreach ($categories_tree as $tree_item): ?>
                <option <?= $tree_item->id == @$category->parent_id ? "selected" : "" ?> value="<?= $tree_item->id ?>"><?= str_repeat('&nbsp', $tree_item->level * 5) . $tree_item->description ?></option>
              <?php endforeach; ?>
            </select>
            <label for="floatingSelect">Category</label>
          </div>
        </div>
      </div>
    </li>

    <?php endif; ?>
</ul>
