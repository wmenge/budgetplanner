<h3 class="display-6">Transactions</h3>

<table class="table table-hover">
	<thead>
		<tr>
			<!--<th><input class="form-check-input" type="checkbox" value="" id="select" name="select"></th>-->
			<th><a href='?sort=account_id'>Account</a></th>
			<th><a href='?sort=counter_account_iban'>Counter Account</a></th>
			<th style="width: 10%"><a href='?sort=description'>Description</a></th>
			<th style="width: 10%"><a href='?sort=additional_description'>Additional Description</a></th>
			<th style="width: 60%"><a href='?sort=category_id'>Category</a></th>
			<th><a href='?sort=date'>Date</a></th>
			<th><a href='?sort=amount'>Amount</a></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($transactions as $transaction): ?>
			<tr class="<?= $transaction->ownAccount ? 'table-secondary text-muted' : '' ?>">
				<!--<td><input class="form-check-input" type="checkbox" value="" id="select" name="select"></td>-->
				<td>
					<?= $transaction->account->iban_formatted() ?> <br /><?= $transaction->account->holder ?>
					<?php foreach ($transaction->tags as $tag): ?>
					  <span class="badge bg-primary"><?= $tag->description ?></span>
				  	<?php endforeach; ?>
				</td>
				
				<td><?= implode('<br />', array_filter([ @$transaction->counter_account_iban_formatted(),  @$transaction->counter_account_name])) ?></td>
				<td><?= @$transaction->description ?></td>
				<td><?= @$transaction->additional_description ?></td>
				<td>
					<select name="category_id[<?= $transaction->id ?>]" class="form-select" aria-label="Default select example">
				  		<option <?= (!@$category->parent) ? "selected" : "" ?> value=""></option>
					  	<?php foreach ($categories as $category): ?>
							  <option <?= $category->id == @$transaction->category_id ? "selected" : "" ?> value="<?= $category->id ?>"><?= $category->description ?></option>
						  <?php endforeach; ?>
					  </select>

				</td>
				<td><?= date('d-m-yy', $transaction->date) ?></td>
				<td class="text-end"><a href="/transactions/<?= $transaction->id ?>"><?= @$transaction->amount_formatted() ?>&nbsp;<?= @$transaction->sign ?></a>
				</td>
				<td>
					
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</form>
