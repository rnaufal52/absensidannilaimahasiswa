<div class="p-6 lg:p-8 dark:bg-gradient-to-bl dark:from-gray-800 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Data Nilai Mahasiswa</h1>

    <!-- Dropdown Pilih matkul -->
    <div class="mb-4 mt-5">
        <label for="course_id" class="block text-sm font-medium text-gray-900 dark:text-white">Pilih Mata Kuliah</label>
        <select wire:model.lazy="selectedCourseId" wire:change="$refresh" id="course_id"
            class="w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white" required>
            <option value="">Pilih Mata Kuliah</option>
            @foreach ($courses as $course)
                <option value="{{(string) $course->course_id }}">{{ $course->course_name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Tabel Pertemuan -->
    @if ($students->isNotEmpty())
    <table class="w-full text-base bg-white overflow-hidden">
        <thead>
            <tr class="bg-gray-100 text-center dark:bg-gray-800 text-sm font-bold text-gray-900 dark:text-gray-200">
                <th class="py-4 px-6 border-b border-gray-300">#</th>
                <th class="py-4 px-6 border-b border-gray-300">Nama</th>
                <th class="py-4 px-6 border-b border-gray-300">NPM</th>
                <th class="py-4 px-6 border-b border-gray-300">Nilai</th>
                <th class="py-4 px-6 border-b border-gray-300">Simbol</th>
                <th class="py-4 px-6 border-b border-gray-300">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $index => $mhs)
                <tr class="border-b text-center border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="py-4 px-6 text-gray-900 dark:text-gray-100">{{ ($students->currentPage() - 1) * $students->perPage() + $index + 1 }}</td>
                    <td class="py-4 px-6 text-gray-900 dark:text-gray-100">{{ $mhs->student_name }}</td>
                    <td class="py-4 px-6 text-gray-900 dark:text-gray-100">{{ $mhs->NPM }}</td>
                    <td class="py-4 px-6 text-gray-900 dark:text-gray-100">{{ $grades[$mhs->student_id]['grade_score'] ?? '-' }}</td>
                    <td class="py-4 px-6 text-gray-900 dark:text-gray-100">{{ $grades[$mhs->student_id]['grade_symbol'] ?? '-' }}</td>
                    <td class="py-4 px-6 text-gray-900 dark:text-gray-100">
                        <div class="inline-flex space-x-2">
                            @if (array_key_exists($mhs->student_id, $grades))
                                <button wire:click="edit('{{ $grades[$mhs->student_id]['grade_id'] }}')"
                                    class="px-4 py-2 border border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-white rounded-md transition-colors duration-200">
                                    Edit
                                </button>
                            @else
                                <button wire:click="add('{{ $mhs->student_id }}')"
                                    class="px-4 py-2 border border-green-500 text-green-500 hover:bg-green-500 hover:text-white rounded-md transition-colors duration-200">
                                    Tambah
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $students->links() }}
    </div>
    @else
        <p class="text-center text-red-600 text-xl font-semibold my-6">
            Silakan pilih mapel untuk menampilkan siswa.
        </p>
    @endif


    <!-- Modal Form -->
    <div class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50" style="display: {{ $showModal ? 'block' : 'none' }};">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-md w-96" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">{{ $isEdit ? 'Edit Nilai Mahasiswa' : 'Tambah Nilai Mahasiswa' }}</h2>
            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif
                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-900 dark:text-white">Mahasiswa</label>
                    <select wire:model="student_id" id="student_id" class="w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white bg-gray-200 cursor-not-allowed" required disabled>
                        <option value="">Pilih Mahasiswa</option>
                        @foreach($students as $student)
                            <option value="{{ $student->student_id }}">{{ $student->student_name }}</option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="course_id" class="block text-sm font-medium text-gray-900 dark:text-white">Mapel</label>
                    <select wire:model="course_id" id="course_id" class="w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white bg-gray-200 cursor-not-allowed" required disabled>
                        <option value="">Pilih Mahasiswa</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->course_id }}">{{ $course->course_name }}</option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="grade_score" class="block text-sm font-medium text-gray-900 dark:text-white">Nilai Mahasiswa</label>
                    <input type="number" wire:model="grade_score"  wire:change="$refresh" id="grade_score" class="w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white" required>
                    @error('grade_score')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="grade_symbol" class="block text-sm font-medium text-gray-900 dark:text-white">Nilai Symbol</label>
                    <input type="text" wire:model="grade_symbol" id="grade_symbol"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white bg-gray-200 cursor-not-allowed"
                    readonly>
                    @error('grade_symbol')
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
</div>

</div>

