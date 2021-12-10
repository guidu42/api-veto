<?php

namespace App\Fixtures\Providers;

class MyFixtures extends \Faker\Provider\Base
{
    public static function randomElementProba($array = ['a', 'b', 'c'], $coefs = [1,1,1])
    {
        if (!$array || ($array instanceof \Traversable && !count($array))) {
            return null;
        }
        $elements = static::randomElementsProba($array, $coefs, 1);

        return $elements[0];
    }

    public static function randomElementsProba($array = ['a', 'b', 'c'], $coefs = [1,1,1], $count = 1, $allowDuplicates = false)
    {
        $traversables = [];

        if ($array instanceof \Traversable) {
            foreach ($array as $element) {
                $traversables[] = $element;
            }
        }

        $arr = count($traversables) ? $traversables : $array;

        $newArr = [];
        foreach ($arr as $key => $value){
            if($coefs[$key] >= 0) {
                for ($i = 0; $i < $coefs[$key]; $i++) {
                    $newArr[] = $value;
                }
            }
        }
        $arr = $newArr;

        $allKeys = array_keys($arr);
        $numKeys = count($allKeys);

        if (!$allowDuplicates && $numKeys < $count) {
            throw new \LengthException(sprintf('Cannot get %d elements, only %d in array', $count, $numKeys));
        }

        $highKey = $numKeys - 1;
        $keys = $elements = [];
        $numElements = 0;

        while ($numElements < $count) {
            $num = mt_rand(0, $highKey);

            if (!$allowDuplicates) {
                if (isset($keys[$num])) {
                    continue;
                }
                $keys[$num] = true;
            }

            $elements[] = $arr[$allKeys[$num]];
            ++$numElements;
        }

        return $elements;
    }
}