<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Session;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data session yang ingin dimasukkan
        $sessions = [
            ['session_topic' => 'Pengenalan Basis Data', 'course_name' => 'Basis Data'],
            ['session_topic' => 'Teori Akuntansi Keuangan', 'course_name' => 'Akuntansi 1'],
            ['session_topic' => 'Pembukuan Dasar', 'course_name' => 'Akuntansi 1'],
            ['session_topic' => 'Akuntansi Keuangan Menengah I', 'course_name' => 'Akuntansi 2'],
            ['session_topic' => 'Audit Dasar', 'course_name' => 'Audit 1'],
            ['session_topic' => 'Sistem Akuntansi Perusahaan', 'course_name' => 'Sistem Informasi Akuntansi'],
            ['session_topic' => 'Etika Profesi Akuntansi', 'course_name' => 'Etika Profesi Akuntansi'],
            ['session_topic' => 'Akuntansi Biaya 101', 'course_name' => 'Akuntansi Biaya'],
            ['session_topic' => 'Perpajakan Indonesia', 'course_name' => 'Perpajakan'],
            ['session_topic' => 'Analisis Laporan Keuangan Lanjut', 'course_name' => 'Analisis Laporan Keuangan'],
        ];

        // Set tanggal awal
        $startDate = Carbon::now()->startOfDay(); // Mulai dari hari ini jam 00:00

        foreach ($sessions as $session) {
            // Cari course_id berdasarkan nama course
            $course = Course::where('course_name', $session['course_name'])->first();

            // Pastikan course ditemukan sebelum membuat session
            if ($course) {
                // Generate 8 session untuk setiap course
                for ($i = 0; $i < 8; $i++) {
                    // Membuat sesi baru dengan dateTime yang ditambahkan 2 hari untuk setiap sesi
                    Session::create([
                        'session_topic' => $session['session_topic'] . ' - Sesi ' . ($i + 1),
                        'course_id' => $course->course_id,
                        'session_date' => $startDate->addDays(2)->format('Y-m-d H:i:s'), // Tambah 2 hari untuk setiap sesi
                    ]);
                }
            } else {
                // Jika course tidak ditemukan, tampilkan pesan error (bisa juga di-log)
                echo "Course '{$session['course_name']}' tidak ditemukan.\n";
            }
        }
    }
}
