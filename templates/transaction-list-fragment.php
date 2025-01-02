<script>

	function toggleSelection(headerCheckBox) {
		console.log(headerCheckBox)
		var checkboxes = document.querySelectorAll('input[type=checkbox]')

		console.log(checkboxes.length);

		checkboxes.forEach((box) => { 
			console.log(box);
			box.checked = headerCheckBox.checked;
		});
	}

	function updateSelectedTransactions(categorySelect) {
		//alert(categorySelect.value)

		var array = []
		var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')

		for (var i = 0; i < checkboxes.length; i++) {
			console.log(checkboxes[i].value);

			if (checkboxes[i].value) {
			
				var transactionCategorySelect = document.getElementById(checkboxes[i].value);

				console.log(transactionCategorySelect);
				transactionCategorySelect.value = categorySelect.value;			
			}
		}
	}

	function enabled() {
		document.querySelectorAll('input[type=checkbox]').length > 0;
	}

</script>
<form method="POST" action="/transactions/match">

<?php if (isset($filter)): ?>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link <?= @$filter=='uncategorized' ? 'active' : ''?>" aria-current="page" href="/transactions/uncategorized">Uncategorized <span class="badge bg-secondary "><?= @$uncategorized_count ?></span></a>
  </li>
  <li class="nav-item">
  <a class="nav-link <?= @$filter=='categorized' ? 'active' : ''?>" aria-current="page" href="/transactions/categorized">
    Categorized <span class="badge bg-secondary"><?= @$categorized_count ?></span></a>
  </li>
  <a class="nav-link <?= @$filter=='own-accounts' ? 'active' : ''?>" aria-current="page" href="/transactions/own-accounts">
    Own accounts <span class="badge bg-secondary"><?= @$own_accounts_count ?></span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="/transactions/upload">Upload transactions</a>
  </li>
  <li class="nav-item">
    <?php if (@$match): ?>
	  <button type="submit" class="btn btn-primary btn-sm">Submit Matches</button>
    <?php else: ?>
      <a class="btn btn-primary btn-sm" href="/transactions/<?= @$filter ?>/match" role="button">Match transactions</a>
    <?php endif; ?>
  </li>


  <li class="nav-item">

  <li class="nav-item">
      <div class="">
        <div class="">
          <div class="form-floating">
            <select id="category_id" name="category_id" class="form-select" onchange="updateSelectedTransactions(this)">
              <option value="">Choose a Category</option>
              <?php foreach ($categories_tree as $tree_item): ?>
                <option <?= $tree_item->id == @$category->parent_id ? "selected" : "" ?> value="<?= $tree_item->id ?>"><?= str_repeat('&nbsp', $tree_item->level * 5) . $tree_item->description ?></option>
              <?php endforeach; ?>
            </select>
            <label for="floatingSelect">Category</label>
          </div>
        </div>
      </div>
    </li>

	<li class="nav-item">
	  <button type="submit" class="btn btn-primary btn-sm">Save</button>
  </li>
    

  </li>

</ul>

<?php else: ?>

	<ul class="nav nav-tabs">



  <li class="nav-item">

  <li class="nav-item">
      <div class="">
        <div class="">
          <div class="form-floating">
            <select id="category_id" name="category_id" class="form-select" onchange="updateSelectedTransactions(this)">
              <option value="">Choose a Category</option>
              <?php foreach ($categories_tree as $tree_item): ?>
                <option <?= $tree_item->id == @$category->parent_id ? "selected" : "" ?> value="<?= $tree_item->id ?>"><?= str_repeat('&nbsp', $tree_item->level * 5) . $tree_item->description ?></option>
              <?php endforeach; ?>
            </select>
            <label for="floatingSelect">Category</label>
          </div>
        </div>
      </div>
    </li>

	<li class="nav-item">
	  <button type="submit" class="btn btn-primary btn-sm">Save</button>
  </li>
    
	  
    
  </li>

</ul>

<?php endif; ?>

<table class="table table-hover">
	<thead>
		<tr>
			<th><input class="form-check-input" type="checkbox" value="" id="select" name="select" onchange="toggleSelection(this)"></th>
			<th><a href='?sort=account_id'>Account</a></th>
			<th><a href='?sort=counter_account_iban'>Counter Account</a></th>
			<th style="width: 10%"><a href='?sort=description'>Description</a></th>
			<th style="width: 10%"><a href='?sort=additional_description'>Additional Description</a></th>
			<?php if (isset($categories)): ?>
				<th style="width: 60%"><a href='?sort=category_id'>Category</a></th>
			<?php endif; ?>
			<th><a href='?sort=date'>Date</a></th>
			<th><a href='?sort=amount'>Amount</a></th>
			<!-- <th></th> -->
		</tr>
	</thead>
	<tbody>
		<?php foreach ($transactions as $transaction): ?>
			<tr class="<?= $transaction->ownAccount ? 'table-secondary text-muted' : '' ?>">
				<td><input class="form-check-input" type="checkbox" value="category_id[<?= $transaction->id ?>]" id="select[<?= $transaction->id ?>]" name="select[<?= $transaction->id ?>]"></td>
				<td>
					<?= ($transaction->account) ? $transaction->account->iban_formatted() : "" ?> <br /><?= $transaction->account->holder ?>
					<?php foreach ($transaction->tags as $tag): ?>
					  <span class="badge bg-primary"><?= $tag->description ?></span>
				  	<?php endforeach; ?>
				</td>
				
				<td><?= implode('<br />', array_filter([ @$transaction->counter_account_iban_formatted(),  @$transaction->counter_account_name])) ?></td>
				<td><?= @$transaction->description ?></td>
				<td><?= @$transaction->additional_description ?></td>
				<?php if (isset($categories)): ?>
					<td>
						<select name="category_id[<?= $transaction->id ?>]" id="category_id[<?= $transaction->id ?>]" class="form-select" aria-label="Default select example">
							<option <?= (!@$category->parent) ? "selected" : "" ?> value=""></option>
							<?php foreach ($categories as $category): ?>
								<option <?= $category->id == @$transaction->category_id ? "selected" : "" ?> value="<?= $category->id ?>"><?= $category->description ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				<?php endif; ?>
				<td><?= date('d-m-yy', $transaction->date) ?></td>
				<td class="text-end"><a href="/transactions/<?= $transaction->id ?>"><?= @$transaction->amount_formatted() ?>&nbsp;<?= @$transaction->sign ?></a>
				</td>
				<!-- <td>
					<div class="btn-toolbar">
						<div class="btn-group">
							
							<a class="btn btn-outline-secondary btn-sm" href="/transactions/<?= $transaction->id ?>/delete" role="button">Delete</a>
						</div>
					</div>
				</td> -->
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</form>
