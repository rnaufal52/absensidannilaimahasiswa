<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class MataPelajaranTable extends Component
{
    use WithPagination;

    public $course_name, $course_id;
    public $isEdit = false; // Menandakan apakah kita dalam mode edit atau tidak
    public $showModal = false; // Untuk menampilkan atau menyembunyikan modal
    public $courseToDelete = null;

    public function render()
    {
        $course = Course::paginate(10);
        return view('livewire.mata-pelajaran-table', [
            'course' => $course,
        ]);
    }

    // Fungsi untuk menambahkan mata pelajaran
    public function store()
    {
        $this->validate([
            'course_name' => 'required|unique:courses,course_name',
        ]);

        Course::create([
            'course_name' => $this->course_name,
        ]);

        flash()->success('Mata Pelajaran berhasil ditambah!');

        $this->resetForm(); // Reset form setelah disubmit
        $this->closeModal(); // Tutup modal setelah submit
    }

    // Fungsi untuk menghapus mata pelajaran
    public function confirmDelete($id)
    {
        $this->courseToDelete = $id;
    }

    public function deleteConfirmed()
    {
        Course::find($this->courseToDelete)?->delete();
        $this->courseToDelete = null;

        flash()->success('Mata Pelajaran berhasil dihapus!');
    }

    // Fungsi untuk mengedit data mata pelajaran
    public function edit($course_id)
    {
        $this->isEdit = true;
        $course = Course::find($course_id);
        $this->course_id = $course->course_id;
        $this->course_name = $course->course_name;
        $this->showModal = true; // Tampilkan modal untuk edit
    }

    // Fungsi untuk update mata pelajaran
    public function update()
    {
        $this->validate([
            'course_name' => 'required|string|unique:courses,course_name,' . $this->course_id . ',course_id',
        ]);

        $course = Course::find($this->course_id);
        $course->update([
            'course_name' => $this->course_name,
        ]);

        flash()->success('Mata Pelajaran berhasil diupdate!');

        $this->resetForm(); // Reset form setelah update
        $this->closeModal(); // Tutup modal setelah update
    }

    // Reset form input
    public function resetForm()
    {
        $this->resetPage();
        $this->course_name = '';
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
