<?php namespace BudgetPlanner\Service;

use \BudgetPlanner\Model\Account as Account;

class AccountService {

    // TODO: Move to account service so it can be mocked
    public function getAccountFor($iban, $holder) {

        $account = Account::where('iban', '=', $iban)->firstOr(function() use ($iban, $holder) {
            $newAccount = new Account();
            $newAccount->iban = $iban;
            $newAccount->holder = $holder;
            $newAccount->save();
            return $newAccount;
        });

        return $account;

    }

    // TODO: validate/clean data!
    // iban check
    public function map($data, $category) {

        // html checked checkbox is represented as an empty array key
        // fix so that it always is true/false
        //$data['own_account'] = array_key_exists('own_account', $data) && $data['own_account'];
        
        if (array_key_exists('iban', $data)) {
            $category->iban = $data['iban'];
        }

        if (array_key_exists('description', $data)) {
            $category->description = $data['description'];
        }

        if (array_key_exists('holder', $data)) {
            $category->holder = $data['holder'];
        }

/*        if (array_key_exists('own_account', $data)) {
            $category->own_account = filter_var($data['own_account'], FILTER_VALIDATE_BOOLEAN);
        }*/
    }
}