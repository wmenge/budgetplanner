<h1 class="display-6"><?= @$account ? "Edit" : "New" ?> Account</h1>

<form method="POST" action="/accounts">
  
  <input type="hidden" name="id" value="<?= @$account->id ?>" />

  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <input type="text" name="description" class="form-control" id="description" value="<?= @$account->description ?>" />
  </div>

  <div class="mb-3">
    <label for="iban" class="form-label">IBAN</label>
    <input type="text" name="iban" class="form-control" id="iban" value="<?= ($account) ? $account->iban_formatted() : "" ?>" />
  </div>

  <div class="mb-3">
    <label for="holder" class="form-label">Holder</label>
    <input type="text" name="holder" class="form-control" id="holder" value="<?= @$account->holder ?>" />
  </div>

  <!--<div class="mb-3">
    <input class="form-check-input" type="checkbox" value="" id="own_account" name="own_account"
      <?= @$account->own_account ? "checked" : "" ?>>
    <label class="form-check-label" for="own_account">
      Own account
    </label>
  </div>-->
  
  <button type="submit" class="btn btn-primary">Submit</button>

</form>