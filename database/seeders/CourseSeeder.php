<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mata_pelajaran = [
            ['course_name' => 'Pengantar Akuntansi'],
            ['course_name' => 'Akuntansi Keuangan Menengah'],
            ['course_name' => 'Akuntansi Biaya'],
            ['course_name' => 'Akuntansi Manajemen'],
            ['course_name' => 'Audit 1'],
            ['course_name' => 'Audit 2'],
            ['course_name' => 'Perpajakan'],
            ['course_name' => 'Sistem Informasi Akuntansi'],
            ['course_name' => 'Etika Profesi Akuntansi'],
            ['course_name' => 'Analisis Laporan Keuangan'],
        ];

        foreach ($mata_pelajaran as $mata_pelajaran) {
            Course::create($mata_pelajaran);
        }
    }
}
