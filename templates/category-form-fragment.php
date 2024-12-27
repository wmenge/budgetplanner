<h1 class="display-5"><?= @$category ? "Edit" : "New" ?> Category</h1>

<form method="POST" action="/categories">
  
  <input type="hidden" name="id" value="<?= @$category->id ?>" />
  
  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <input type="text" name="description" class="form-control" id="description" value="<?= @$category->description ?>" />
  </div>
  
  <div class="mb-3">
  	<label for="description" class="form-label">Parent</label>
    <select name="parent_id" class="form-select" aria-label="Default select example">
  		<option <?= (!@$category->parent) ? "selected" : "" ?> value="">Select a parent category</option>
	  	<?php foreach ($categories_tree as $tree_item): ?>
			  <option <?= $tree_item->id == @$category->parent_id ? "selected" : "" ?> value="<?= $tree_item->id ?>"><?= str_repeat('&nbsp', $tree_item->level * 5) . $tree_item->description ?></option>
		  <?php endforeach; ?>
	  </select>
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>

</form>


<hr/>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link <?= @$detail=='rules' ? 'active' : ''?> aria-current="page" href="/categories/<?= @$category->id ?>/rules">
      Rules <span class="badge bg-secondary"><?= @$category->rules->count() ?></span></a>
  </li>
  <li class="nav-item">
  <a class="nav-link <?= @$detail=='transactions' ? 'active' : ''?> aria-current="page" href="/categories/<?= @$category->id ?>/transactions">
    Transactions <span class="badge bg-secondary"><?= @$category->transactions->count() ?></span></a>
  </li>
</ul>

<hr/>

<?php if(@$detail=='rules'): ?>
  <?= $this->fetch("assignment-rules-list-fragment.php", [ 'category' => $category ]); ?>
<?php endif; ?>

<?php if(@$detail=='transactions'): ?>
  <?= $this->fetch("transaction-list-fragment.php", [ 'transactions' => $category->transactions ]); ?>
<?php endif; ?>
