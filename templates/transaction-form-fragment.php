<h1 class="display-5"><?= @$transaction ? "Edit" : "New" ?> Transaction</h1>
  <div class="card">
  <div class="card-header">
    Tags
  </div>
  <div class="card-body">
    
  <div class="mb-3">
    <div class="lead">
      <?php foreach ($transaction->tags as $tag): ?>
        <form style="display: inline;" method="POST" action="/transactions/<?= @$transaction->id ?>/tags/<?= @$tag->id ?>/delete">
          <span class="badge bg-secondary">
            <?= $tag->description ?> 
            <button type="submit" class="btn-close"></button>
          </span>
        </form>
      <?php endforeach; ?>
    </div>
  </div>

<form method="POST" action="/transactions/<?= @$transaction->id ?>/tags">
  
  <div class="input-group col-xs-2">
    <select name="tag_id" class="form-select col-xs-2" aria-label="Default select example">
      <option selected>Select a tag</option>
      <?php foreach ($tags as $tag): ?>
        <option value="<?= $tag->id ?>"><?= $tag->description ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-primary">Add</button>
  </div>
</form>

  </div>
</div>

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
    <label for="additional_description" class="form-label">Additional Description</label>
    <input type="text" class="form-control" name="additional_description" value="<?= @$transaction->additional_description ?>"/>
  </div>


  <div class="mb-3">
    <label for="account" class="form-label">Account</label>
    <input type="text" class="form-control" value="<?= @$transaction->account->iban_formatted()?> / <?= @$transaction->account->holder ?>" readonly/>
  </div>

  <div class="mb-3">
    <label for="counter_account" class="form-label">Counter Account</label>
    <input type="text" class="form-control" value="<?= implode(' / ', array_filter([ @$transaction->counter_account_iban_formatted(),  @$transaction->counter_account_name])) ?>" readonly/>
  </div>

  <div class="mb-3">
    <label for="counter_account" class="form-label">Description</label>
    <input type="text" class="form-control" value="<?= @$transaction->description ?>" readonly/>
  </div>

  <div class="mb-3">
    <label for="amount" class="form-label">Amount</label>
    <input type="text" class="form-control" value="<?= @$transaction->amount_formatted() ?>&nbsp;<?= @$transaction->sign ?>" readonly/>
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