<?php

namespace App\Livewire\Traits\CreateMovie;

use App\Models\Award;

trait ManagesAwards
{
    public array $awardsData = [];

    public function initializeAwards(): void
    {
        if (empty($this->awardsData)) {
            $this->awardsData[] = [
                'award_name' => '',
                'category' => '',
                'person_ids' => []
            ];
        }
    }

    public function addAward(): void
    {
        $this->awardsData[] = [
            'award_name' => '',
            'category' => '',
            'person_ids' => []
        ];
    }

    public function removeAward(int $index): void
    {
        unset($this->awardsData[$index]);
        $this->awardsData = array_values($this->awardsData);
    }

    public function clearAward(int $index): void
    {
        $this->awardsData[$index]['award_name'] = '';
        $this->awardsData[$index]['category'] = '';
        $this->awardsData[$index]['person_ids'] = [];
    }

    public function updateAwardName(int $index, string $awardName): void
    {
        $this->awardsData[$index]['award_name'] = $awardName;
        // При смене награды можно сбросить категорию, если нужно
        if ($awardName !== $this->awardsData[$index]['award_name']) {
            $this->awardsData[$index]['category'] = '';
        }
    }

    public function updateAwardCategory(int $index, string $category): void
    {
        $this->awardsData[$index]['category'] = $category;
    }

    public function updateAwardPersons(int $index, array $personIds): void
    {
        $this->awardsData[$index]['person_ids'] = $personIds;
    }

    public function toggleAwardPerson(int $index, int $personId): void
    {
        if (in_array($personId, $this->awardsData[$index]['person_ids'])) {
            $this->awardsData[$index]['person_ids'] = array_values(
                array_filter(
                    $this->awardsData[$index]['person_ids'],
                    fn($id) => $id != $personId
                )
            );
        } else {
            $this->awardsData[$index]['person_ids'][] = $personId;
        }
    }

    public function getAwardCategoriesFor(string $awardName): array
    {
        // Предопределенные категории для популярных наград
        $predefinedCategories = [
            'Oscar' => [
                'Best Picture',
                'Best Director',
                'Best Actor',
                'Best Actress',
                'Best Supporting Actor',
                'Best Supporting Actress',
                'Best Original Screenplay',
                'Best Adapted Screenplay',
                'Best Cinematography',
                'Best Editing',
                'Best Visual Effects',
                'Best Original Score',
                'Best Sound'
            ],
            'Golden Globe' => [
                'Best Motion Picture – Drama',
                'Best Motion Picture – Musical or Comedy',
                'Best Director',
                'Best Actor – Motion Picture Drama',
                'Best Actress – Motion Picture Drama',
                'Best Actor – Motion Picture Musical or Comedy',
                'Best Actress – Motion Picture Musical or Comedy',
                'Best Supporting Actor',
                'Best Supporting Actress',
                'Best Screenplay',
                'Best Original Score'
            ],
            'BAFTA' => [
                'Best Film',
                'Best British Film',
                'Best Director',
                'Best Leading Actor',
                'Best Leading Actress',
                'Best Supporting Actor',
                'Best Supporting Actress',
                'Best Original Screenplay',
                'Best Adapted Screenplay',
                'Best Cinematography',
                'Best Editing',
                'Best Special Visual Effects'
            ],
            'Cannes Film Festival' => [
                'Palme d\'Or',
                'Grand Prix',
                'Best Director',
                'Best Screenplay',
                'Best Actor',
                'Best Actress',
                'Jury Prize',
                'Camera d\'Or'
            ],
            'Berlin International Film Festival' => [
                'Golden Bear',
                'Silver Bear Grand Jury Prize',
                'Silver Bear for Best Director',
                'Silver Bear for Best Actor',
                'Silver Bear for Best Actress',
                'Silver Bear for Best Script',
                'Silver Bear for Outstanding Artistic Contribution'
            ],
            'Venice Film Festival' => [
                'Golden Lion',
                'Silver Lion',
                'Best Director',
                'Best Actor',
                'Best Actress',
                'Best Screenplay',
                'Special Jury Prize'
            ]
        ];

        if (isset($predefinedCategories[$awardName])) {
            return array_map(fn($cat) => ['value' => $cat, 'text' => $cat], $predefinedCategories[$awardName]);
        }

        return Award::where('name', $awardName)
            ->distinct('category')
            ->pluck('category')
            ->map(fn($cat) => ['value' => $cat, 'text' => $cat])
            ->toArray();
    }

    public function validateAwards(): bool
    {
        foreach ($this->awardsData as $index => $award) {
            if (!empty($award['award_name']) || !empty($award['category']) || !empty($award['person_ids'])) {
                if (empty($award['award_name'])) {
                    $this->addError("awardsData.{$index}.award_name", 'Verleihung ist erforderlich');
                    return false;
                }
                if (empty($award['category'])) {
                    $this->addError("awardsData.{$index}.category", 'Kategorie ist erforderlich');
                    return false;
                }
            }
        }
        return true;
    }

    public function hasAwards(): bool
    {
        return !empty(array_filter($this->awardsData, function ($award) {
            return !empty($award['award_name']) && !empty($award['category']);
        }));
    }
}
