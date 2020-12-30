<?php 

namespace BudgetPlanner\Service;

use \BudgetPlanner\Model\Transaction as Transaction;
use \BudgetPlanner\Model\Account as Account;

class TransactionService {

    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function import($path) {

    	$transactionsData = new CSVReaderRabo($path);

        // TODO: Check if transaction exists
    	foreach ($transactionsData as $data) {
    		$transaction = new Transaction();
            $this->map($data, $transaction);

            //print_r($transaction->getAttributes());

            if (!Transaction::where('account_id', '=', $transaction->account_id)
                ->where('sequence_id', '=', $transaction->sequence_id)
                ->exists()) {
                $transaction->save();
            }
    	}
    }

    public function ownAccount($transaction) {
        return (Account::where('iban', '=', $transaction->counter_account_iban)->exists());
    }

    // TODO: validate/clean data!
    public function map($data, $transaction) {

        if (array_key_exists('id', $data) && !empty($data['id'])) {
            $transaction->id = $data['id'];
        }

        if (array_key_exists('account', $data) && array_key_exists('iban', $data['account'])) {
            $transaction->account()->associate($this->accountService->getAccountFor($data['account']['iban'], 'Current User'));
        }

        if (array_key_exists('account_id', $data) && !empty($data['account_id'])) {
            $transaction->account_id = $data['account_id'];
        }

        if (array_key_exists('counter_account_iban', $data)) {
            $transaction->counter_account_iban = $data['counter_account_iban'];
        }

        if (array_key_exists('counter_account_name', $data)) {
            $transaction->counter_account_name = $data['counter_account_name'];
        }

        if (array_key_exists('date', $data)) {
            $transaction->date = $data['date'];
        }

        if (array_key_exists('sequence_id', $data)) {
            $transaction->sequence_id = $data['sequence_id'];
        }
        
        if (array_key_exists('interest_date', $data)) {
            $transaction->interest_date = $data['interest_date'];
        }
        
        if (array_key_exists('balance_after_transaction', $data)) {
            $transaction->balance_after_transaction = $data['balance_after_transaction'];
        }
        
        if (array_key_exists('currency', $data)) {
            $transaction->currency = $data['currency'];
        }

        if (array_key_exists('sign', $data)) {
            $transaction->sign = $data['sign'];
        }
        
        if (array_key_exists('amount', $data)) {
            $transaction->amount = $data['amount'];
        }

        if (array_key_exists('category_id', $data)) {
            $transaction->category_id = $data['category_id'];
        }

        if (array_key_exists('description', $data)) {
            $transaction->description = $data['description'];
        }

        if (array_key_exists('additional_description', $data)) {
            $transaction->additional_description = $data['additional_description'];
        }
    }
}