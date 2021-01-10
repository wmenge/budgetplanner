<h1 class="display-5"><?= @$rule ? "Edit" : "New" ?> Assignment Rule</h1>

<form method="POST" action="/categories/<?= @$category->id ?>/rules">
  
  <input type="hidden" name="id" value="<?= @$rule->id ?>" />
  <input type="hidden" name="category_id" value="<?= @$category->id ?>" />
  
  <div class="smmb-3">
    <label for="category_id" class="form-label">Category</label>
    <select name="category_id" class="form-select" aria-label="Default select example">
      <option <?= (!@$rule->category) ? "selected" : "" ?>Select a category</option>
      <?php foreach ($categories as $categoryItem): ?>
        <option <?= $categoryItem == @$category ? "selected" : "" ?> value="<?= $categoryItem->id ?>"><?= $categoryItem->description ?></option>
      <?php endforeach; ?>
    </select>
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
    <div class="input-group">
      <span class="input-group-text">/</span>
      <input type="text" name="pattern" class="form-control" id="pattern" value="<?= @$rule->pattern ?>" />
      <span class="input-group-text">/i</span>
    </div>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>

</form>