<h3 class="display-5">Transactions</h3>

<!--<div class="btn-toolbar">
	<?php if (@$match): ?>
	<?php else: ?>
		<div class="btn-group">
			<a class="btn btn-outline-primary btn-sm" href="/transactions/<?= @$filter ?>/match" role="button">Match transactions</a>
		</div>
	<?php endif; ?>
</div>-->

<!--<form method="POST" action="/transactions/upload" enctype="multipart/form-data">
	<div class="row">
		<div class="input-group mb-3 col-4">  
			<label for="transactionFile" class="form-label">Upload file</label>
			<div class="input-group mb-3">
				<input class="form-control form-control-sm" type="file" name="transactionFile" id="transactionFile">
				<button class="btn btn-outline-primary btn-sm" type="submit">Upload</button>
			</div>
		</div>
	</div>
</form>-->

<form method="POST" action="/transactions/<?= @$filter ?>/match">

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
</ul>

<table class="table table-hover">
	<thead>
		<tr>
			<!--<th><input class="form-check-input" type="checkbox" value="" id="select" name="select"></th>-->
			<th><a href='?sort=account_id'>Account</a></th>
			<th><a href='?sort=counter_account_iban'>Counter Account</a></th>
			<th style="width: 10%"><a href='?sort=description'>Description</a></th>
			<th style="width: 10%"><a href='?sort=additional_description'>Additional Description</a></th>
			<th style="width: 60%"><a href='?sort=category_id'>Category</a></th>
			<th><a href='?sort=date'>Date</a></th>
			<th><a href='?sort=amount'>Amount</a></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($transactions as $transaction): ?>
			<tr class="<?= $transaction->ownAccount ? 'table-secondary text-muted' : '' ?>">
				<!--<td><input class="form-check-input" type="checkbox" value="" id="select" name="select"></td>-->
				<td>
					<?=  ($transaction->account) ? $transaction->account->iban_formatted() : "" ?> <br /><?= $transaction->account->holder ?>
					<?php foreach ($transaction->tags as $tag): ?>
					  <span class="badge bg-primary"><?= $tag->description ?></span>
				  	<?php endforeach; ?>
				</td>
				
				<td><?= implode('<br />', array_filter([ @$transaction->counter_account_iban_formatted(),  @$transaction->counter_account_name])) ?></td>
				<td><?= @$transaction->description ?></td>
				<td><?= @$transaction->additional_description ?></td>
				<td>
					<select name="category_id[<?= $transaction->id ?>]" class="form-select" aria-label="Default select example">
				  		<option <?= (!@$category->parent) ? "selected" : "" ?> value=""></option>
					  	<?php foreach ($categories as $category): ?>
							  <option <?= $category->id == @$transaction->category_id ? "selected" : "" ?> value="<?= $category->id ?>"><?= $category->description ?></option>
						  <?php endforeach; ?>
					  </select>

				</td>
				<td><?= date('d-m-yy', $transaction->date) ?></td>
				<td class="text-end"><a href="/transactions/<?= $transaction->id ?>"><?= @$transaction->amount_formatted() ?>&nbsp;<?= @$transaction->sign ?></a>
				</td>
				<td>
					<div class="btn-toolbar">
						<div class="btn-group">
							
							<a class="btn btn-outline-secondary btn-sm" href="/transactions/<?= $transaction->id ?>/delete" role="button">Delete</a>
						</div>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</form>
