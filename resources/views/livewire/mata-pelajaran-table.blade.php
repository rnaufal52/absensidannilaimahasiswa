<div class="p-6 lg:p-8 dark:bg-gradient-to-bl dark:from-gray-800 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mt-8">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Data Mata Pelajaran</h1>

        <!-- Tombol Tambah Mata Pelajaran -->
        <button wire:click="openModal" class="px-4 py-2 border border-green-500 text-green-500 hover:bg-green-500 hover:text-white rounded-md transition-colors duration-200">
            Tambah Mata Pelajaran
        </button>
    </div>

    <!-- Tabel Mata Pelajaran -->
    <div class="mt-6">
        <table class="w-full text-base bg-white overflow-hidden">
            <thead>
                <tr class="bg-gray-100 text-center dark:bg-gray-800 text-sm font-bold text-gray-900 dark:text-gray-200">
                    <th class="py-4 px-6 border-b border-gray-600">#</th>
                    <th class="py-4 px-6 border-b border-gray-600">Nama Mata Pelajaran</th>
                    <th class="py-4 px-6 border-b border-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($course as $index => $crs)
                    <tr class="border-b text-center border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="py-4 px-6 text-gray-900 dark:text-gray-100">{{ $index + 1 }}</td>
                        <td class="py-4 px-6 text-gray-900 dark:text-gray-100">{{ $crs->course_name }}</td>
                        <td class="py-4 px-6 text-gray-900 dark:text-gray-100">
                            <div class="inline-flex space-x-2">
                                <button wire:click="edit('{{ $crs->course_id }}')"
                                    class="px-4 py-2 border border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-white rounded-md transition-colors duration-200">
                                    Edit
                                </button>
                                <button wire:click="confirmDelete('{{ $crs->course_id }}')"
                                    class="px-4 py-2 border border-red-500 text-red-500 hover:bg-red-500 rounded-md hover:text-white transition-colors duration-200">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="py-4 px-6 text-center text-gray-600 dark:text-gray-300" colspan="4">Tidak ada data mata pelajaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $course->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    <div class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50" style="display: {{ $showModal ? 'block' : 'none' }};">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-md w-96" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">{{ $isEdit ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran' }}</h2>
            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif
                <div class="mb-4">
                    <label for="course_name" class="block text-sm font-medium text-gray-900 dark:text-white">Nama Mata Pelajaran</label>
                    <input type="text" wire:model="course_name" id="course_name" class="w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white" required>
                    @error('course_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-500 text-white rounded-md">Batal</button>
                    <button type="submit" class="px-4 py-2 border transition-colors duration-200 rounded-md
                        {{ $isEdit ? 'border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-white' : 'border-green-500 text-green-500 hover:bg-green-500 hover:text-white' }}">
                        {{ $isEdit ? 'Update' : 'Tambah' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if ($courseToDelete)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-full max-w-md z-50">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Konfirmasi Hapus</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-6">Apakah Anda yakin ingin menghapus data ini?</p>
            <div class="flex justify-end space-x-4">
                <button wire:click="$set('studentToDelete', null)" class="px-4 py-2 bg-gray-500 text-white rounded-md">Batal</button>
                <button wire:click="deleteConfirmed" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Hapus</button>
            </div>
        </div>
    </div>
    @endif

</div>
