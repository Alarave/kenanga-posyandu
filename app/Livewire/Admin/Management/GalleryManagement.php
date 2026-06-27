<?php

namespace App\Livewire\Admin\Management;

use App\Models\Gallery;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Layout('layouts.admin-layout')]
class GalleryManagement extends Component
{
    use WithPagination;
    use WithFileUploads; // dipakai kalau field 'image' berupa upload file

    public $search = '';

    // --- State untuk Edit ---
    public $editingId = null; // null = mode create/tidak edit, isi id = sedang edit
    public $title = '';
    public $description = '';
    public $image; // bisa berupa file upload baru, atau path lama

    // --- State untuk Delete ---
    public $deletingId = null; // id yang sedang dikonfirmasi untuk dihapus

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    // Validasi input form edit
    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // max 2MB, hanya wajib kalau ganti gambar
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Dipanggil saat tombol "Edit" diklik.
     * Mengisi form dengan data gallery yang dipilih.
     */
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);

        $this->editingId = $gallery->id;
        $this->title = $gallery->title;
        $this->description = $gallery->description;
        $this->image = null; // jangan diisi file lama, biar tidak ketimpa otomatis
    }

    /**
     * Dipanggil saat form edit di-submit.
     * Validasi lalu update data ke database.
     */
    public function update()
    {
        $this->validate();

        $gallery = Gallery::findOrFail($this->editingId);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
        ];

        // Kalau user upload gambar baru, simpan & ganti path-nya
        if ($this->image) {
            $data['image'] = $this->image->store('galleries', 'public');
        }

        $gallery->update($data);

        $this->resetForm();
        session()->flash('message', 'Gallery berhasil diperbarui.');
    }

    /**
     * Membatalkan mode edit, reset form ke kondisi awal.
     */
    public function cancelEdit()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['editingId', 'title', 'description', 'image']);
    }

    /**
     * Dipanggil saat tombol "Hapus" diklik pertama kali.
     * Hanya menyimpan id yang akan dihapus, untuk ditampilkan modal konfirmasi.
     */
    public function confirmDelete($id)
    {
        $this->deletingId = $id;
    }

    /**
     * Dipanggil setelah user benar-benar konfirmasi hapus di modal.
     */
    public function delete()
    {
        Gallery::findOrFail($this->deletingId)->delete();

        $this->deletingId = null;
        session()->flash('message', 'Gallery berhasil dihapus.');
    }

    public function render()
    {
        $query = Gallery::query()
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%');
            })
            ->latest();

        return view('livewire.admin.gallery-management.index', [
            'galleries' => $query->paginate(12),
        ]);
    }
}