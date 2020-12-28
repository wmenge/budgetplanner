<h3>Accounts</h3>

<div class="btn-toolbar">
	<div class="btn-group">
		<a class="btn btn-outline-primary btn-sm" href="/accounts/new" role="button">New Account</a>
	</div>
</div>

<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>IBAN</th>
			<th>Description</th>
			<th>Holder</th>
			<!--<th>Own Acccount</th>-->
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($accounts as $account): ?>
			<tr>
				<td><a href="/accounts/<?= $account->id ?>"><?= @$account->iban ?></a></td>
				<td><?= @$account->description ?></td>
				<td><?= @$account->holder ?></td>
				<!--<td><?= @$account->own_account ? "Yes" : "No" ?></td>-->
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