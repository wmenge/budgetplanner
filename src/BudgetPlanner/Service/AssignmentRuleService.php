<?php namespace BudgetPlanner\Service;

use \BudgetPlanner\Model\AssignmentRule as AssignmentRule;

class AssignmentRuleService {

    /***
     * Tries to match transactions to given assigment rules
     */
    public function match($transactions, $rules) {

        $matches = [];

        // TODO: Handle multiple matches
        foreach ($rules as $rule) {
             foreach ($transactions as $transaction) {
                $pattern = '/' . $rule->pattern . '/i';
                $subject = $transaction[$rule->field];
                if (!is_null($subject) && preg_match($pattern, $subject) && $rule->category != $transaction->category) {
                    $transaction->category()->associate($rule->category);
                    array_push($matches, $transaction);
                }
            }
        }

        return $matches;
    }

    // TODO: validate/clean data!
    public function map($data, $rule) {

        if (array_key_exists('id', $data) && !empty($data['id'])) {
            $rule->id = $data['id'];
        }

        if (array_key_exists('category_id', $data)) {
            $rule->category_id = $data['category_id'];
        }
        
        if (array_key_exists('field', $data)) {
            $rule->field = $data['field'];
        }

        if (array_key_exists('pattern', $data)) {
            $rule->pattern = $data['pattern'];
        }
    }
}