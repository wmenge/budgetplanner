<?php 

namespace BudgetPlanner\Service;

use \BudgetPlanner\Model\Tag;

class TagService {

    // TODO: validate/clean data!
    // category can not be its own parent
    // allow no cycles
    public function map($data, $tag) {

        if (array_key_exists('id', $data) && !empty($data['id'])) {
            $tag->id = $data['id'];
        }

        if (array_key_exists('description', $data)) {
            $tag->description = $data['description'];
        }
    }
}