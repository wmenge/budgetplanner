<!--<h1 class="display-5">Categories</h1>-->

<div class="btn-toolbar">
	<div class="btn-group">
		<a class="btn btn-outline-primary btn-sm" href="/categories/new" role="button">New Category</a>
	</div>
</div>

<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Description</th>
			<th>Parent</th>
			<th>Assignment Rules</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($categories as $category): ?>
			<tr>
				<td><a href="/categories/<?= $category->id ?>"><?= @$category->description ?></a></td>
				<td><?= @$category->parent->description ?></td>
				<td>
					<!--<?php foreach ($category->rules as $rule): ?>
						<a href="/categories/<?= $category->id ?>/rules/<?= $rule->id ?>"><?= $rule->field ?> => /<?= $rule->pattern ?>/i</a><br />
					<?php endforeach; ?>-->
					<a href="/categories/<?= $category->id ?>"><?= count($category->rules) ?> rule(s)</a></td>
				</td>
				<td>
					<div class="btn-toolbar">
						<div class="btn-group">
							<a class="btn btn-outline-secondary btn-sm" href="/categories/<?= $category->id ?>/delete" role="button">Delete</a>							
						</div>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>


<div class="btn-toolbar">
	<div class="btn-group">
		<a class="btn btn-outline-primary btn-sm" href="/categories/new" role="button">New Category</a>
	</div>
</div>