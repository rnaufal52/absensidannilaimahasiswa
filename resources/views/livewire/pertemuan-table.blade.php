<div class="p-6 lg:p-8 dark:bg-gradient-to-bl dark:from-gray-800 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mt-8">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Data Pertemuan</h1>

        <!-- Tombol Tambah Pertemuan -->
        <button wire:click="openModal" class="px-4 py-2 border border-green-500 text-green-500 hover:bg-green-500 hover:text-white rounded-md transition-colors duration-200">
            Tambah Pertemuan
        </button>
    </div>

    <!-- Tabel Pertemuan -->
    <div class="mt-6">
    <table class="w-full text-base bg-white overflow-hidden">
        <thead>
            <tr class="bg-gray-100 text-center dark:bg-gray-800 text-sm font-bold text-gray-900 dark:text-gray-200">
                <th class="py-4 px-6 border-b border-gray-300">#</th>
                <th class="py-4 px-6 border-b border-gray-300">Topic Pertemuan</th>
                <th class="py-4 px-6 border-b border-gray-300">Mata Pelajaran</th>
                <th class="py-4 px-6 border-b border-gray-300">Tanggal Pertemuan</th>
                <th class="py-4 px-6 border-b border-gray-300">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($session as $index => $ses)
                <tr class="border-b text-center border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="py-4 px-6 text-gray-900 dark:text-gray-100">{{ ($session->currentPage() - 1) * $session->perPage() + $index + 1 }}</td>
                    <td class="py-4 px-6 text-gray-900 dark:text-gray-100">{{ $ses->session_topic }}</td>
                    <td class="py-4 px-6 text-gray-900 dark:text-gray-100">{{ $ses->courses->course_name??null }}</td>
                    <td class="py-4 px-6 text-gray-900 dark:text-gray-100">{{ $ses->session_date }}</td>
                    <td class="py-4 px-6 text-gray-900 dark:text-gray-100">
                        <div class="inline-flex space-x-2">
                            <button wire:click="edit('{{ $ses->session_id }}')"
                                class="px-4 py-2 border border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-white rounded-md transition-colors duration-200">
                                Edit
                            </button>
                            <button wire:click="confirmDelete('{{ $ses->session_id }}')"
                                class="px-4 py-2 border border-red-500 text-red-500 hover:bg-red-500 rounded-md hover:text-white transition-colors duration-200">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="py-4 px-6 text-center text-gray-600 dark:text-gray-300" colspan="4">Tidak ada data pertemuan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $session->links() }}
    </div>
</div>


    <!-- Modal Form -->
<div class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50" style="display: {{ $showModal ? 'block' : 'none' }};">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-md w-96" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">
            {{ $isEdit ? 'Edit Pertemuan' : 'Tambah Pertemuan' }}
        </h2>

        <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
            <div class="mb-4">
                <label for="session_topic" class="block text-sm font-medium text-gray-900 dark:text-white">Topik Pertemuan</label>
                <textarea wire:model="session_topic" id="session_topic" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white" required></textarea>
                @error('session_topic')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="session_date" class="block text-sm font-medium text-gray-900 dark:text-white">Tanggal Pertemuan</label>
                <input type="datetime-local" wire:model="session_date" id="session_date"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white" required>
                @error('session_date')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="course_id" class="block text-sm font-medium text-gray-900 dark:text-white">Mata Kuliah</label>
                <select wire:model="course_id" id="course_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white" required>
                    <option value="">Pilih Mata Kuliah</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->course_id }}">{{ $course->course_name }}</option>
                    @endforeach
                </select>
                @error('course_id')
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


    @if ($sessionToDelete)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-full max-w-md z-50">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Konfirmasi Hapus</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-6">Apakah Anda yakin ingin menghapus data ini?</p>
            <div class="flex justify-end space-x-4">
                <button wire:click="$set('sessionToDelete', null)" class="px-4 py-2 bg-gray-500 text-white rounded-md">Batal</button>
                <button wire:click="deleteConfirmed" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Hapus</button>
            </div>
        </div>
    </div>
    @endif


</div>

</div>
