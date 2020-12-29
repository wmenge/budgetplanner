<?php 

namespace BudgetPlanner\Service;

use \BudgetPlanner\Model\Category as Transaction;

class CategoryService {

    // TODO: validate/clean data!
    // category can not be its own parent
    // allow no cycles
    public function map($data, $category) {

        if (array_key_exists('id', $data) && !empty($data['id'])) {
            $category->id = $data['id'];
        }

        if (array_key_exists('description', $data)) {
            $category->description = $data['description'];
        }

        if (array_key_exists('parent_id', $data) && !empty($data['parent_id'])) {
            $category->parent_id = $data['parent_id'];
        }
    }
}