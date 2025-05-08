<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Grades;
use App\Models\Students;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class NilaiTable extends Component
{
    use WithPagination;

    public $courses = [];
    public $selectedCourseId;

    public $course_id, $grade_score, $grade_symbol, $student_id, $grade_id;
    public $isEdit = false; // Menandakan apakah kita dalam mode edit atau tidak
    public $showModal = false;

    // dropdown menampilkan course
    public function mount()
    {
        $this->courses = Course::all();
    }

    public function updatedselectedCourseId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = new LengthAwarePaginator([], 0, 10);
        $grades = [];

        if ($this->selectedCourseId) {
            $students = Students::with('grades')->paginate(10);

            // Ambil grade hanya untuk siswa yang sedang ditampilkan
            $grades = Grades::where('course_id', $this->selectedCourseId)
                ->whereIn('student_id', $students->pluck('student_id'))
                ->get()
                ->keyBy('student_id')
                ->toArray(); // hasil: [student_id => grade_id]
        }

        return view('livewire.nilai-table', [
            'students' => $students,
            'grades' => $grades,
        ]);
    }
    public function add($studentId)
    {
        $this->resetForm();
        $this->student_id = $studentId;
        $this->course_id = $this->selectedCourseId;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate([
            'grade_score'=>'required|numeric|min:0|max:100',
            'grade_symbol'=>'required|string'
        ]);

        Grades::create([
            'student_id' => $this->student_id,
            'course_id' => $this->course_id,
            'grade_score' => $this->grade_score,
            'grade_symbol' => $this->grade_symbol,
        ]);

        flash()->success('Nilai mahasiswa berhasil ditambah!');

        $this->resetForm(); // Reset form setelah disubmit
        $this->closeModal(); // Tutup modal setelah submit
    }

    public function edit($grade_id)
    {
        $this->isEdit = true;
        $grades = Grades::find($grade_id);
        $this->grade_id = $grades->grade_id;
        $this->course_id = $grades->course_id;
        $this->student_id = $grades->student_id;
        $this->grade_score=$grades->grade_score;
        $this->grade_symbol=$grades->grade_symbol;
        $this->showModal = true; // Tampilkan modal untuk edit
    }

    // Fungsi untuk update pertemuan
    public function update()
    {
        $this->validate([
            'grade_score'=>'required|numeric|min:0|max:100',
            'grade_symbol'=>'required|string'
        ]);

        $grades = Grades::find($this->grade_id);
        $grades->update([
            'student_id' => $this->student_id,
            'course_id' => $this->course_id,
            'grade_score' => $this->grade_score,
            'grade_symbol' => $this->grade_symbol,
        ]);

        flash()->success('Nilai mahasiswa berhasil diupdate!');

        $this->resetForm(); // Reset form setelah update
        $this->closeModal(); // Tutup modal setelah update
    }

    public function updatedGradeScore($value)
    {
        $score = (float) $value;

        if ($score >= 85) {
            $this->grade_symbol = 'A';
        } elseif ($score >= 70) {
            $this->grade_symbol = 'B';
        } elseif ($score >= 60) {
            $this->grade_symbol = 'C';
        } elseif ($score >= 50) {
            $this->grade_symbol = 'D';
        } else {
            $this->grade_symbol = 'E';
        }
    }


    // Reset form input
    public function resetForm()
    {
        $this->student_id = '';
        $this->grade_symbol = '';
        $this->grade_score = '';
        $this->course_id = null;
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
