<h3><?= @$rule ? "Edit" : "New" ?> Assignment Rule</h3>

<form method="POST" action="/categories/<?= @$category->id ?>/rules">
  
  <input type="hidden" name="id" value="<?= @$rule->id ?>" />
  <input type="hidden" name="category_id" value="<?= @$category->id ?>" />
  
  <div class="mb-3">
    <label for="" class="form-label">Category</label>
    <input type="text" name="" class="form-control" id="" value="<?= @$category->description ?>" readonly />
  </div>

  <!--<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <input type="text" name="description" class="form-control" id="description" value="<?= @$rule->description ?>" />
  </div>-->

  <div class="mb-3">
    <label for="field" class="form-label">Field</label>
    <input type="text" name="field" class="form-control" id="field" value="<?= @$rule->field ?>" />
  </div>

    <div class="mb-3">
    <label for="pattern" class="form-label">Pattern</label>
    <input type="text" name="pattern" class="form-control" id="pattern" value="<?= @$rule->pattern ?>" />
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>

</form>