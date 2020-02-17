<?php declare(strict_types = 1);

namespace App\Models;

use App\Traits\SimilarityTrait;
use Exception;
use Illuminate\Database\Eloquent\Model;

class ItemSimilarity extends Model
{
    use SimilarityTrait;

    protected $graduates = [];
    protected $featureWeight = 1;
    protected $priceWeight = 1;
    protected $categoryWeight = 1;
    protected $priceHighRange = 1000;

    public function __construct($graduates)
    {
        $this->graduates = $graduates;
    }

    public function setFeatureWeight($weight)
    {
        $this->featureWeight = $weight;
    }

    public function setPriceWeight($weight)
    {
        $this->priceWeight = $weight;
    }

    public function setCategoryWeight($weight)
    {
        $this->categoryWeight = $weight;
    }

    public function calculateSimilarityMatrix()
    {
        $matrix = [];

        foreach($this->graduates as $graduate) {
            $similarityScores = [];
            foreach($this->graduates as $otherGraduate) {
                if ($graduate->graduate_id == $otherGraduate->graduate_id) {
                    continue;
                }
                $similarityScores["graduate_id_{$graduate->graduate_id}"] =
                $this->calculateSimilarityScore($graduate, $otherGraduate);
            }
            $matrix["product_id_{$graduate->graduate_id}"] = $similarityScores;
        }

        return $matrix;
    }

    public function getProductsSortedBySimilarity($id, $matrix)
    {
        $similarities = $matrix["product_id_{$id}"] ?? null;
        $sortedProducts = [];

        if (is_null($similarities)) {
            throw new Exception('Can\'t find product with that ID.');
        }

        arsort($similarities);

        foreach ($similarities as $key => $value) {
            $_id = intval(str_replace('product_id_', '', $id));
            $products = array_filter($this->products, function ($product) use ($_id) {
                return $product->id == $_id;
            });

            if (!count($products)) {
                continue;
            }

            $product = $products[array_keys($products)[0]];
            $product->similarity = $value;
            array_push($sortedProducts, $product);
        }

        return $sortedProducts;
    }

    public function calculateSimilarityScore($graduate, $otherGraduate)
    {
        $product1Features = implode('', [$graduate->batch]);
        $product2Features = implode('', [$otherGraduate->batch]);

        return array_sum([
            ($this->hamming($product1Features, $product2Features) * $this->featureWeight),
            /* ($this->euclidean($this->minMaxNorm([$graduate->price], 0, $this->priceHighRange),
            $this->minMaxNorm([$otherGraduate->price], 0, $this->priceHighRange)) * $this->priceWeight),
            ($this->jaccard($graduate->categories, $otherGraduate->categories) * $this->categoryWeight) */
        ]) / ($this->featureWeight + $this->priceWeight + $this->categoryWeight);
    }
}
