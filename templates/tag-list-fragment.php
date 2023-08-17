<div class="btn-toolbar">
	<div class="btn-group">
		<a class="btn btn-outline-primary btn-sm" href="/tags/new" role="button">New Tag</a>
	</div>
</div>

<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Description</th>
			<th>Transactions</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($tags as $tag): ?>
			<tr>
				<td><a href="/tags/<?= $tag->id ?>"><?= @$tag->description ?></a></td>
				<td><?= count(@$tag->transactions) ?> transaction(s)</td>
				<td>
					<div class="btn-toolbar">
						<div class="btn-group">
							<a class="btn btn-outline-secondary btn-sm" href="/tags/<?= $tag->id ?>/delete" role="button">Delete</a>							
						</div>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>