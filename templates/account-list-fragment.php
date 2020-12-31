<h3>Accounts</h3>

<div class="btn-toolbar">
	<div class="btn-group">
		<a class="btn btn-outline-primary btn-sm" href="/accounts/new" role="button">New Account</a>
	</div>
</div>

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
</table>