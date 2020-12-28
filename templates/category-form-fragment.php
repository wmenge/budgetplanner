<h3><?= @$category ? "Edit" : "New" ?> Category</h3>

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
	  	<?php foreach ($categories as $parent_category): ?>
			  <option <?= $parent_category == @$category->parent ? "selected" : "" ?> value="<?= $parent_category->id ?>"><?= $parent_category->description ?></option>
		  <?php endforeach; ?>
	  </select>
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>

</form>

<?= $this->fetch("assignment-rules-list-fragment.php", [ 'category' => $category ]); ?>