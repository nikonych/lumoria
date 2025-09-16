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
            'Schauspieler',
            'Kamera & Beleuchtung',
            'Regie',
            'Produktion',
            'Ton',
            'Schnitt',
            'Casting',
            'Visuelle Effekte',
            'Drehbuch',
            'Musik',
            'Ausstattung',
            'Stunts',
            'Kostüme & Make-Up',
        ];

        // Loop through the array and create each department if it does not already exist.
        foreach ($departments as $departmentName) {
            Department::firstOrCreate(['name' => $departmentName]);
        }
    }
}
