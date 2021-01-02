<h3><?= @$tag ? "Edit" : "New" ?> Tag</h3>

<form method="POST" action="/tags">
  
  <input type="hidden" name="id" value="<?= @$tag->id ?>" />
  
  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <input type="text" name="description" class="form-control" id="description" value="<?= @$tag->description ?>" />
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>

</form>

<?= $this->fetch("tag-transaction-list-fragment.php", [ 'transactions' => $tag->transactions, 'categories' => $categories ]); ?>