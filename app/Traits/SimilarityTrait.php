<?php declare(strict_types = 1);

namespace App\Traits;

trait SimilarityTrait
{
    public function hamming($string1, $string2, $distance = false)
    {
        $a = str_pad($string1, strlen($string2) - strlen($string1), ' ');
        $b = str_pad($string2, strlen($string1) - strlen($string2), ' ');
        $d = collect(str_split($a))->diffAssoc(str_split($b))->count();

        if ($distance) {
            return $d;
        }

        return (strlen($a) - $d) / strlen($a);
    }

    public function euclidean($array1, $array2, $distance = false)
    {
        $a = $array1; $b = $array2; $set = collect(null);

        foreach($a as $index => $value) {
            $set->push($value - $b[$index] ?? 0);
        }

        $d = sqrt($set->map(function ($value) {
            return pow($value, 2);
        })->sum());

        if ($distance) {
            return $d;
        }

        // angular similarity
        return 1 - $d;
    }

    public function jaccard($string1, $string2, $separator = ',')
    {
        $a = explode($separator, $string1);
        $b = explode($separator, $string2);
        $intersection = collect($a)->intersect($b)->unique()->all();
        $union = collect($a)->merge($b)->unique()->all();

        return count($intersection) / count($union);
    }

    public function minMaxNorm($values, $min = null, $max = null)
    {
        $norm = []; $min = $min ?? min($values); $max = $max ?? max($values);

        foreach ($values as $value) {
            array_push($norm, ($value - $min) / ($max - $min));
        }

        return $norm;
    }
}
