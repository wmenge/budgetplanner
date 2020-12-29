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
    public function map($data, $account) {

        // html checked checkbox is represented as an empty array key
        // fix so that it always is true/false
        //$data['own_account'] = array_key_exists('own_account', $data) && $data['own_account'];
        
        if (array_key_exists('id', $data) && !empty($data['id'])) {
            $account->id = $data['id'];
        }

        if (array_key_exists('iban', $data)) {
            $account->iban = $data['iban'];
        }

        if (array_key_exists('description', $data)) {
            $account->description = $data['description'];
        }

        if (array_key_exists('holder', $data)) {
            $account->holder = $data['holder'];
        }
    }
}