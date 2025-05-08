<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Session;
use Livewire\Component;

class PertemuanTable extends Component
{
    public $session_topic, $session_date, $session_id, $course_id;
    public $isEdit = false; // Menandakan apakah kita dalam mode edit atau tidak
    public $showModal = false; // Untuk menampilkan atau menyembunyikan modal
    public $sessionToDelete = null;
    public $courses = [];

    public function render()
    {
        $sessions = Session::paginate(10);
        return view('livewire.pertemuan-table', [
            'session' => $sessions,
        ]);
    }

    // Fungsi untuk menambahkan session
    public function store()
    {
        $this->validate([
            'session_topic' => 'required|string',
            'session_date' => 'required|date',
            'course_id'=>'required|string|exists:courses,course_id'
        ]);

        // Cek apakah sudah ada session untuk course dan tanggal yang sama
        $existingSession = Session::where('course_id', $this->course_id)
            ->whereDate('session_date', \Carbon\Carbon::parse($this->session_date)->toDateString())
            ->exists();

        if ($existingSession) {
            return $this->addError('session_date', 'Pertemuan untuk mata kuliah ini pada tanggal tersebut sudah ada.');
        }

        Session::create([
            'session_topic' => $this->session_topic,
            'session_date' => $this->session_date,
            'course_id' => $this->course_id,
        ]);

        flash()->success('Pertemuan berhasil ditambahkan!');

        $this->resetForm(); // Reset form setelah disubmit
        $this->closeModal(); // Tutup modal setelah submit
    }

    // Fungsi untuk menghapus Pertemuan
    public function confirmDelete($id)
    {
        $this->sessionToDelete = $id;
    }

    public function deleteConfirmed()
    {
        Session::find($this->sessionToDelete)?->delete();
        $this->sessionToDelete = null;

        flash()->success('Pertemuan berhasil dihapus!');
    }

    // Fungsi untuk mengedit data pertemuan
    public function edit($session_id)
    {
        $this->isEdit = true;
        $session = Session::find($session_id);
        $this->session_id = $session->session_id;
        $this->session_topic = $session->session_topic;
        $this->session_date = $session->session_date;
        $this->course_id=$session->course_id;
        $this->showModal = true; // Tampilkan modal untuk edit
    }

    // Fungsi untuk update pertemuan
    public function update()
    {
        $this->validate([
            'session_topic' => 'required|string',
            'session_date' => 'required|date',
            'course_id'=>'required|string|exists:courses,course_id'
        ]);

        // Cek apakah sudah ada session untuk course dan tanggal yang sama
        $existingSession = Session::where('course_id', $this->course_id)
            ->whereDate('session_date', \Carbon\Carbon::parse($this->session_date)->toDateString())
            ->where('session_id', '!=', $this->session_id)
            ->exists();

        if ($existingSession) {
            return $this->addError('session_date', 'Pertemuan untuk mata kuliah ini pada tanggal tersebut sudah ada.');
        }

        $session = Session::find($this->session_id);
        $session->update([
            'session_topic' => $this->session_topic,
            'session_date' => $this->session_date,
            'course_id' => $this->course_id,
        ]);

        flash()->success('Pertemuan berhasil diupdate!');

        $this->resetForm(); // Reset form setelah update
        $this->closeModal(); // Tutup modal setelah update
    }

    public function mount()
    {
        $this->courses = Course::all();
    }

    // Reset form input
    public function resetForm()
    {
        $this->session_topic = '';
        $this->session_date = '';
        $this->course_id='';
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
