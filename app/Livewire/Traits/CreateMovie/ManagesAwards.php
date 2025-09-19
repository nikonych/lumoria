<?php

namespace App\Livewire\Traits\CreateMovie;

trait ManagesAwards
{

    public function initializeAwards(): void
    {
        if (empty($this->awardsData)) {
            $this->awardsData[] = [
                'id' => $this->awardCounter++,
                'award_name' => '',
                'categories' => [
                    [
                        'id' => $this->categoryCounter++,
                        'category' => '',
                        'person_id' => ''
                    ]
                ]
            ];
        }
    }

    public function addAward(): void
    {
        $this->awardsData[] = [
            'id' => $this->awardCounter++,
            'award_name' => '',
            'categories' => [
                [
                    'id' => $this->categoryCounter++,
                    'category' => '',
                    'person_id' => ''
                ]
            ]
        ];
    }

    public function addCategory(int $awardId): void
    {
        $awardIndex = collect($this->awardsData)->search(fn($award) => $award['id'] === $awardId);

        if ($awardIndex !== false) {
            if (!isset($this->awardsData[$awardIndex]['categories'][0])) {
                $existingCategory = $this->awardsData[$awardIndex]['categories'];
                $this->awardsData[$awardIndex]['categories'] = [$existingCategory];
            }

            $this->awardsData[$awardIndex]['categories'][] = [
                'id' => $this->categoryCounter++,
                'category' => '',
                'person_id' => ''
            ];
        }
    }

    public function removeCategory(int $awardId, int $categoryId): void
    {
        $awardIndex = collect($this->awardsData)->search(fn($award) => $award['id'] === $awardId);
        if ($awardIndex !== false) {
            $this->awardsData[$awardIndex]['categories'] = collect($this->awardsData[$awardIndex]['categories'])
                ->reject(fn($category) => $category['id'] === $categoryId)
                ->values()
                ->toArray();

        }
    }

    public function removeAward(int $awardId): void
    {
        $this->awardsData = collect($this->awardsData)
            ->reject(fn($award) => $award['id'] === $awardId)
            ->values()
            ->toArray();
    }

    public function clearCategory(int $awardId, int $categoryId): void
    {
        $awardIndex = collect($this->awardsData)->search(fn($award) => $award['id'] === $awardId);

        if ($awardIndex !== false) {
            $categoryIndex = collect($this->awardsData[$awardIndex]['categories'])
                ->search(fn($category) => $category['id'] === $categoryId);

            if ($categoryIndex !== false) {
                $this->awardsData[$awardIndex]['categories'][$categoryIndex]['category'] = '';
                $this->awardsData[$awardIndex]['categories'][$categoryIndex]['person_id'] = '';
            }
        }
    }

    public function clearAward(int $awardId): void
    {
        $awardIndex = collect($this->awardsData)->search(fn($award) => $award['id'] === $awardId);

        if ($awardIndex !== false) {
            $this->awardsData[$awardIndex]['award_name'] = '';

            foreach ($this->awardsData[$awardIndex]['categories'] as $categoryIndex => $category) {
                $this->awardsData[$awardIndex]['categories'][$categoryIndex]['category'] = '';
                $this->awardsData[$awardIndex]['categories'][$categoryIndex]['person_id'] = '';
            }
        }
    }
}
