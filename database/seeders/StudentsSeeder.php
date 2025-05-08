<?php

namespace Database\Seeders;

use App\Models\Students;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            ['student_name' => 'Etty Susanti', 'NPM' => 'C1C022087'],
            ['student_name' => 'Wafiq Triannisa', 'NPM' => 'C1C022032'],
            ['student_name' => 'Reza Putri Ningrum', 'NPM' => 'C1C022037'],
            ['student_name' => 'Lolita Warda Tunisa', 'NPM' => 'C1C022105'],
            ['student_name' => 'Amir Mahmud', 'NPM' => 'C1C022041'],
            ['student_name' => 'Dayu Ronaldo', 'NPM' => 'C1C022143'],
            ['student_name' => 'Alya Fitriani', 'NPM' => 'C1C022001'],
            ['student_name' => 'Rizky Dwi Saputra', 'NPM' => 'C1C022002'],
            ['student_name' => 'Nur Aisyah', 'NPM' => 'C1C022003'],
            ['student_name' => 'Fajar Nugroho', 'NPM' => 'C1C022004'],
            ['student_name' => 'Intan Permata', 'NPM' => 'C1C022005'],
            ['student_name' => 'Hendra Wijaya', 'NPM' => 'C1C022006'],
            ['student_name' => 'Siti Zahra', 'NPM' => 'C1C022007'],
            ['student_name' => 'Dimas Aditya', 'NPM' => 'C1C022008'],
            ['student_name' => 'Lestari Ayu', 'NPM' => 'C1C022009'],
            ['student_name' => 'Bagus Rahman', 'NPM' => 'C1C022010'],
            ['student_name' => 'Vina Amelia', 'NPM' => 'C1C022011'],
            ['student_name' => 'Galang Prasetyo', 'NPM' => 'C1C022012'],
            ['student_name' => 'Tari Puspita', 'NPM' => 'C1C022013'],
            ['student_name' => 'Yoga Santoso', 'NPM' => 'C1C022014'],
            ['student_name' => 'Maya Lestari', 'NPM' => 'C1C022015'],
        ];

        foreach ($students as $student) {
            Students::create($student);
        }
    }
}
