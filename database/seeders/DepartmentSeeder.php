<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Directing',
            'Producing',
            'Writing',
            'Cinematography',
            'Sound',
            'Editing',
            'Art Direction',
            'Costume & Wardrobe',
            'Makeup',
            'Visual Effects',
            'Stunts',
            'Camera',
        ];

        // Loop through the array and create each department if it does not already exist.
        foreach ($departments as $departmentName) {
            Department::firstOrCreate(['name' => $departmentName]);
        }
    }
}
