<h3 class="display-4">Transactions</h3>

<div class="btn-toolbar">
	<?php if (@$match): ?>
	<!--	<div class="btn-group">
			<a class="btn btn-outline-primary btn-sm" href="/transactions/<?= @$filter ?>/match" role="button">Save matches</a>
		</div>-->
	<?php else: ?>
		<div class="btn-group">
			<a class="btn btn-outline-primary btn-sm" href="/transactions/<?= @$filter ?>/match" role="button">Match transactions</a>
		</div>
	<?php endif; ?>
</div>

<form method="POST" action="/transactions/upload" enctype="multipart/form-data">
	<div class="row">
		<div class="input-group mb-3 col-4">  
			<label for="transactionFile" class="form-label">Upload file</label>
			<div class="input-group mb-3">
				<input class="form-control form-control-sm" type="file" name="transactionFile" id="transactionFile">
				<button class="btn btn-outline-primary btn-sm" type="submit">Upload</button>
			</div>
		</div>
	</div>
</form>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link <?= @$filter=='uncategorized' ? 'active' : ''?>" aria-current="page" href="/transactions/uncategorized">Uncategorized <span class="badge bg-secondary "><?= @$uncategorized_count ?></span></a>
  </li>
  <li class="nav-item">
  <a class="nav-link <?= @$filter=='categorized' ? 'active' : ''?>" aria-current="page" href="/transactions/categorized">
    Categorized <span class="badge bg-secondary"><?= @$categorized_count ?></span></a>
  </li>
  <!--<li class="nav-item">
    <a class="nav-link" href="#">Upload</a>
  </li>-->
</ul>

<form method="POST" action="/transactions/<?= @$filter ?>/match">

<?php if (@$match): ?>
		<div class="btn-group">
			<button type="submit" class="btn btn-primary">Submit Matches</button>
			<!--<a class="btn btn-outline-primary btn-sm" href="/transactions/<?= @$filter ?>/match" role="button">Save matches</a>-->
		</div>
	<?php else: ?>
		<!--<div class="btn-group">
			<a class="btn btn-outline-primary btn-sm" href="/transactions/<?= @$filter ?>/match" role="button">Match transactions</a>
		</div>-->
	<?php endif; ?>

<table class="table table-hover">
	<thead>
		<tr>
			<!--<th><input class="form-check-input" type="checkbox" value="" id="select" name="select"></th>-->
			<th>Account</th>
			<th>Counter Account</th>
			<th style="width:10%">Description</th>
			<th style="width:10%">Additional Description</th>
			<th>Category</th>
			<th>Date</th>
			<th>Amount</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($transactions as $transaction): ?>
			<tr class="<?= $transaction->ownAccount ? 'table-secondary text-muted' : '' ?>">
				<!--<td><input class="form-check-input" type="checkbox" value="" id="select" name="select"></td>-->
				<td><?= $transaction->account->iban ?> <br /><?= $transaction->account->holder ?></td>
				
				<td><?= implode('<br />', array_filter([ @$transaction->counter_account_iban,  @$transaction->counter_account_name])) ?></td>
				<td><?= @$transaction->description ?></td>
				<td><?= @$transaction->additional_description ?></td>
				<td>
					<select name="category_id[<?= $transaction->id ?>]" class="form-select" aria-label="Default select example">
				  		<option <?= (!@$transaction->category) ? "selected" : "" ?>Select a category</option>
					  	<?php foreach ($categories as $category): ?>
							  <option <?= $category == @$transaction->category ? "selected" : "" ?> value="<?= $category->id ?>"><?= $category->description ?></option>
						  <?php endforeach; ?>
					  </select>
				</td>
				<td><?= date('d-m-yy', $transaction->date) ?></td>
				<td><a href="/transactions/<?= $transaction->id ?>"><?= @$transaction->currency ?> <?= @$transaction->sign ?> <?= @$transaction->amount ?></a>
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
