<!--<h1 class="display-5">Accounts</h1>-->

<div class="btn-toolbar">
	<div class="btn-group">
		<a class="btn btn-outline-primary btn-sm" href="/accounts/new" role="button">New Account</a>
	</div>
</div>

<div class="d-flex flex-row flex-wrap">
<?php foreach ($accounts as $account): ?>
	<div class="card" style="margin: 1rem 2rem 0 0; width: 20rem; height: 12rem;">
	  <div class="card-body">
	    <h5 class="card-title accountDescription"><a href="/accounts/<?= $account->id ?>"><?= @$account->description ?></a></h5>
	    <h6 class="card-subtitle my-3 text-muted iban"><?= @$account->iban_formatted() ?></h6>
	    <p class="card-text name"><?= @$account->holder ?></p>
	  </div>
	  <div class="card-footer iban" style="text-align: right;">
	    Balance: <span class="numeric"><?= @$account->balance() ?></span>
	  </div>
	</div>
<?php endforeach; ?>
</div>



<!--
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th><a href='?sort=iban'>IBAN</a></th>
			<th><a href='?sort=description'>Description</a></th>
			<th><a href='?sort=holder'>Holder</a></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($accounts as $account): ?>
			<tr>
				<td><a href="/accounts/<?= $account->id ?>"><?= @$account->iban_formatted() ?></a></td>
				<td><?= @$account->description ?></td>
				<td><?= @$account->holder ?></td>
				<td>
					<div class="btn-toolbar">
						<div class="btn-group">
							<a class="btn btn-outline-secondary btn-sm" href="/accounts/<?= $account->id ?>/delete" role="button">Delete</a>
						</div>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>-->