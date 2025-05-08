<?php

namespace App\Livewire;

use App\Models\Attendece;
use App\Models\Course;
use App\Models\Session;
use App\Models\Students;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AttendeceTable extends Component
{
    use WithPagination;
    public $courses = [];
    public $sessions = [];
    public $selectedCourseId;
    public $selectedSessionId;

    public $course_id, $session_id, $attendence_status, $student_id, $attendence_id;
    public $isEdit = false; // Menandakan apakah kita dalam mode edit atau tidak
    public $showModal = false;

    // dropdown menampilkan course
    public function mount()
    {
        $this->courses = Course::all();
    }

    public function getFilteredSessionsProperty()
    {
        return Session::where('course_id', $this->selectedCourseId)->get();
    }

    public function updatedSelectedCourseId()
    {
        $this->selectedSessionId = null; // reset dropdown tanggal
        $this->resetPage(); // reset pagination tabel siswa
    }


    public function render()
    {
        $students = new LengthAwarePaginator([], 0, 10);
        $attendences = [];

        if ($this->selectedSessionId) {
            $students = Students::with('attendences')->paginate(10);

            // Ambil attendence hanya untuk siswa yang sedang ditampilkan
            $attendences = Attendece::where('session_id', $this->selectedSessionId)
                ->whereIn('student_id', $students->pluck('student_id'))
                ->get()
                ->keyBy('student_id')
                ->toArray();
        }

        return view('livewire.attendece-table', [
            'students' => $students,
            'attendences' => $attendences,
        ]);
    }

    public function store($student_id,$attendence_status)
    {
        try {
            Validator::make([
                'attendence_status' => $attendence_status,
            ], [
                'attendence_status' => 'required|string|in:hadir,izin,sakit,alfa',
            ])->validate();

            if (!$this->selectedSessionId) {
                flash()->error('Silakan pilih tanggal pertemuan terlebih dahulu.');
                return;
            }

            Attendece::create([
                'student_id' => $student_id,
                'session_id' => $this->selectedSessionId,
                'attendence_status' => $attendence_status
            ]);

            flash()->success('Mahasiswa berhasil absen!');
            $this->resetValidation();

        } catch (ValidationException $e) {
            flash()->error('Status absen tidak valid.');
        }
    }

    public function edit($attendence_id)
    {
        $this->isEdit = true;
        $attendences = Attendece::find($attendence_id);
        $this->attendence_id = $attendences->attendence_id;
        $this->course_id = $attendences->course_id;
        $this->student_id = $attendences->student_id;
        $this->attendence_status=$attendences->attendence_status;
        $this->showModal = true; // Tampilkan modal untuk edit
    }

    // Fungsi untuk update pertemuan
    public function update()
    {
        $this->validate([
            'attendence_status' => 'required|string|in:hadir,izin,sakit,alfa'
        ]);

        $attendence = Attendece::find($this->attendence_id);
        $attendence->update([
            'student_id' => $this->student_id,
            'session_id' => $this->selectedSessionId,
            'attendence_status' => $this->attendence_status
        ]);

        flash()->success('Absen mahasiswa berhasil diupdate!');

        $this->resetForm(); // Reset form setelah update
        $this->closeModal(); // Tutup modal setelah update
    }

    // Reset form input
    public function resetForm()
    {
        $this->student_id = '';
        $this->attendence_status = '';
        $this->course_id = null;
        $this->session_id = null;
        $this->isEdit = false;
        $this->resetValidation();
    }

    // Fungsi untuk menutup modal
    public function closeModal()
    {
        $this->showModal = false;
    }

    // Fungsi untuk membuka modal
    public function openModal()
    {
        $this->resetForm(); // Reset form saat membuka modal
        $this->showModal = true;
        $this->isEdit = false; // Set edit mode ke false untuk tambah
    }
}
