<h1 class="display-5">Transactions</h1>

<!-- TODO: put in component -->
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
    <a class="nav-link <?= @$filter=='upload' ? 'active' : ''?>" href="/transactions/upload">Upload transactions</a>
  </li>
</ul>

<form method="POST" action="/transactions/upload" enctype="multipart/form-data">
	<div class="row">
		<div class="input-group mb-3 col-4">  
			<label for="transactionFile" class="form-label">&nbsp;</label>
			<div class="input-group mb-3">
				<input class="form-control form-control-sm" type="file" name="transactionFile" id="transactionFile">
				<button class="btn btn-outline-primary btn-sm" type="submit">Upload</button>
			</div>
		</div>
	</div>
</form>
