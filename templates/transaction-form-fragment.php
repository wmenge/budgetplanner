<h3><?= @$category ? "Edit" : "New" ?> Category</h3>

<form method="POST" action="/transactions">
  
  <input type="hidden" name="id" value="<?= @$transaction->id ?>" />
    
  <div class="smmb-3">
  	<label for="category_id" class="form-label">Category</label>
    <select name="category_id" class="form-select" aria-label="Default select example">
  		<option <?= (!@$transaction->category) ? "selected" : "" ?>Select a category</option>
	  	<?php foreach ($categories as $category): ?>
			  <option <?= $category == @$transaction->category ? "selected" : "" ?> value="<?= $category->id ?>"><?= $category->description ?></option>
		  <?php endforeach; ?>
	  </select>
  </div>

  <div class="mb-3">
    <label for="account" class="form-label">Account</label>
    <input type="text" class="form-control" value="<?= @$transaction->account->iban ?>" readonly/>
  </div>

  <div class="mb-3">
    <label for="counter_account" class="form-label">Counter Account</label>
    <input type="text" class="form-control" value="<?= @$transaction->counterAccount->iban ?>" readonly/>
  </div>

  <div class="mb-3">
    <label for="counter_account" class="form-label">Description</label>
    <input type="text" class="form-control" value="<?= @$transaction->description ?>" readonly/>
  </div>

  <div class="mb-3">
    <label for="amount" class="form-label">Amount</label>
    <input type="text" class="form-control" value="<?= @$transaction->currency ?> <?= @$transaction->sign ?> <?= @$transaction->amount ?>" readonly/>
  </div>

  <div class="mb-3">
    <label for="reference" class="form-label">Reference</label>
    <input type="text" class="form-control" value="<?= @$transaction->reference->iban ?>" readonly/>
  </div>

    <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <input type="text" class="form-control" value="<?= @$transaction->description->iban ?>" readonly/>
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>

</form>