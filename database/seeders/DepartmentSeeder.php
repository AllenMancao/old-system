<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            'KTTD',
            'MCIIS',
            'CIC',
            'SMU',
            'OSAS',
            'SDMD',
            'GIST-ERC',
            'GAD',
            'BAC',
            'MCERTI',
            'MiLawPRI',
            'RDCAS',
        ];

        foreach ($departments as $department) {
            Department::create([
                'name' => $department,
            ]);
        }
    }
}