<?php

namespace App\Utilities;

use App\Models\Graduate;
use App\Traits\StaticTrait;
use Exception;
use Illuminate\Database\Eloquent\Model;

class GraduateSimilarity extends Model
{
    use StaticTrait;

    private $graduates = [];
    private $educationWeight = 0.5;
    private $addressWeight = 0.35;

    public function __construct($graduates)
    {
        $this->graduates = $graduates;
    }

    public function calculateSimilarityMatrix()
    {
        $matrix = collect();

        foreach ($this->graduates as $graduate) {
            $education = collect(); $distance = collect();

            foreach ($this->graduates as $_graduate) {
                if ($graduate->graduate_id == $_graduate->graduate_id) { continue; }
                $education->put("{$_graduate->graduate_id}", $this->calculateEducationSimilarity($graduate, $_graduate));
                $distance->put("{$_graduate->graduate_id}", $this->calculateNearestDistance($graduate, $_graduate));
            }

            $similarityScores = $education->map(function ($item, $key) use ($education) {
                return $this->minMaxNorm($item, $education->min(), $education->max()) * $this->educationWeight;
            })->mergeRecursive($distance->map(function ($item, $key) use ($distance) {
                return $this->minMaxNorm($item, $distance->max(), $distance->min()) * $this->addressWeight;
            }));

            $scores = $similarityScores->map(function ($item, $key) use ($similarityScores) {
                return collect($similarityScores->get($key))->sum() * 100;
            });

            $matrix->put("{$graduate->graduate_id}", $scores->all());
        }

        return $matrix;
    }

    public function getGraduatesSortedBySimilarity($selectedId, $matrix, $user)
    {
        $graduateIds = $matrix->get($selectedId) ?? null;
        $sortedGraduates = collect();

        if (is_null($graduateIds)) {
            throw new Exception("Graduates not found.");
        }

        $graduateIds = collect($graduateIds)->sort()->reverse();

        $graduatess = Graduate::with(['contacts', 'academic', 'responses'])->whereDoesntHave('users', function ($query) use ($user) {
            return $query->where('users.user_id', $user->user_id);
        })->get();

        foreach ($graduateIds as $graduateId => $value) {
            $graduates = collect($graduatess)->filter(function ($value, $key) use ($graduateId) {
                return $value->graduate_id == $graduateId;
            });
            if (!count($graduates)) { continue; }
            $graduate = $graduates->get($graduates->keys()->first());
            $graduate->score = $value;
            $sortedGraduates->push($graduate);
        }

        return $sortedGraduates->all();
    }

    private function calculateEducationSimilarity($graduate1, $graduate2)
    {
        $total = collect();

        $graduate1->academic->school == $graduate2->academic->school ? $total->push(30) : $total->push(0);
        $graduate1->academic->department == $graduate2->academic->department ? $total->push(25) : $total->push(0);
        ($graduate1->academic->degree == $graduate2->academic->degree && $graduate1->academic->major == $graduate2->academic->major) ? $total->push(20) : $total->push(0);
        $graduate1->academic->year == $graduate2->academic->year ? $total->push(15) : $total->push(0);
        $graduate1->academic->batch == $graduate2->academic->batch ? $total->push(10) : $total->push(0);

        return $total->sum();
    }

    private function calculateNearestDistance($graduate1, $graduate2)
    {
        $contact1 = $graduate1->contacts->first();
        $contact2 = $graduate2->contacts->first();

        return $this->getDistance($contact1->latitude, $contact2->latitude, $contact1->longitude, $contact2->longitude);
    }

    private function minMaxNorm($value, $min, $max)
    {
        $numerator = $value - $min;
        $denominator = $max - $min;
        $norm = ($numerator / $denominator) * (1 - 0) + 0;

        return $norm;
    }
}
