<?php
namespace MyApp;

class Bingo {
    public function create() {
        $nums = [];
        for ($i = 0; $i < 5; $i++) {
            # code...
            $col = range($i * 15 + 1, $i * 15 + 15);
            shuffle($col);
            $nums[$i] = array_slice($col, 0, 5);
        }
        // var_dump($col);

        $nums[2][2] = "FREE";
        return $nums;
    }
}
