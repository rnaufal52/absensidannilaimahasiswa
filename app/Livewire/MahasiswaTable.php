<?php

namespace App\Livewire;

use App\Models\Students;
use Livewire\Component;
use Livewire\WithPagination;

class MahasiswaTable extends Component
{
    use WithPagination;

    public $student_name, $NPM, $student_id;
    public $isEdit = false; // Menandakan apakah kita dalam mode edit atau tidak
    public $showModal = false; // Untuk menampilkan atau menyembunyikan modal
    public $studentToDelete = null;

    public function render()
    {
        $students = Students::paginate(10);
        return view('livewire.mahasiswa-table', [
            'mahasiswa' => $students,
        ]);
    }

    // Fungsi untuk menambahkan mahasiswa
    public function store()
    {
        $this->validate([
            'student_name' => 'required|string',
            'NPM' => 'required|string|unique:students,NPM',
        ]);

        Students::create([
            'student_name' => $this->student_name,
            'NPM' => $this->NPM,
        ]);

        flash()->success('Mahasiswa berhasil ditambahkan!');

        $this->resetForm(); // Reset form setelah disubmit
        $this->closeModal(); // Tutup modal setelah submit
    }

    // Fungsi untuk menghapus mahasiswa
    public function confirmDelete($id)
    {
        $this->studentToDelete = $id;
    }

    public function deleteConfirmed()
    {
        Students::find($this->studentToDelete)?->delete();
        $this->studentToDelete = null;

        flash()->success('Mahasiswa berhasil dihapus!');
    }

    // Fungsi untuk mengedit data mahasiswa
    public function edit($student_id)
    {
        $this->isEdit = true;
        $student = Students::find($student_id);
        $this->student_id = $student->student_id;
        $this->student_name = $student->student_name;
        $this->NPM = $student->NPM;
        $this->showModal = true; // Tampilkan modal untuk edit
    }

    // Fungsi untuk update mahasiswa
    public function update()
    {
        $this->validate([
            'student_name' => 'required|string',
            'NPM' => 'required|string|unique:students,NPM,' . $this->student_id . ',student_id',
        ]);

        $student = Students::find($this->student_id);
        $student->update([
            'student_name' => $this->student_name,
            'NPM' => $this->NPM,
        ]);

        flash()->success('Mahasiswa berhasil diupdate!');

        $this->resetForm(); // Reset form setelah update
        $this->closeModal(); // Tutup modal setelah update
    }

    // Reset form input
    public function resetForm()
    {
        $this->resetPage();
        $this->student_name = '';
        $this->NPM = '';
        $this->student_id = null;
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
