<h6>Assignment Rules</h6>

<div class="btn-toolbar">
  <div class="btn-group">
    <a class="btn btn-outline-primary btn-sm" href="/categories/<?= @$category->id ?>/rules/new" role="button">New Rule</a>
  </div>
</div>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <!--<th>Description</th>-->
      <th>Field</th>
      <th>Pattern</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($category->rules as $rule): ?>
      <tr>
        <td><a href="/categories/<?= $category->id ?>/rules/<?= $rule->id ?>"><?= @$rule->id ?></a></td>
        <!--<td><?= @$rule->description ?></td>-->
        <td><?= @$rule->field ?></td>
        <td>/<?= @$rule->pattern ?>/i</td>
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
    <a class="btn btn-outline-primary btn-sm" href="/categories/<?= @$category->id ?>/rules/new" role="button">New Rule</a>
  </div>
</div>