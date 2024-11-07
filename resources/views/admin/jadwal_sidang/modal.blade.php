<div id="modal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-75">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 id="modal-title" class="text-xl font-semibold text-gray-800">Tambah Jadwal Sidang</h2>
            <button type="button" class="py-2 px-4 rounded hover:bg-gray-100 mr-2" onclick="toggleModal('modal')">
                &#10005;
            </button>
        </div>

        <form id="form-berita" method="POST" action="{{ route('admin.sidang.store') }}">
            @csrf
            <div class="px-6 py-4 space-y-4">
                <input type="text" name="perkara" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Perkara">
                <input type="text" name="agenda" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Agenda">
                <input type="date" name="tanggal_sidang" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Tanggal Sidang">
                <input type="text" name="penggugat" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Penggugat">
                <input type="text" name="tergugat" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Tergugat">
                <textarea name="keterangan" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Keterangan"></textarea>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="button" class="px-4 py-2 mr-2 text-gray-600 bg-gray-100 rounded hover:bg-gray-200" onclick="toggleModal('modal')">Batal</button>
                <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal1" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900 bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white w-full max-w-lg p-5 rounded shadow-lg">
            <div class="flex justify-between items-center border-b pb-2">
                <h3 id="modalTitle" class="text-lg font-semibold">Edit Jadwal Sidang</h3>
                <button onclick="toggleModal('modal1')" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>

            <form id="editForm" action="" method="POST">
                @csrf
                <input type="hidden" name="id" id="id" class="w-full p-2 border border-gray-300 rounded">

                <div class="mb-4">
                    <label class="block text-gray-700">Perkara</label>
                    <input type="text" name="perkara" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Agenda</label>
                    <input type="text" name="agenda" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Tanggal Sidang</label>
                    <input type="date" name="tanggal_sidang" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Penggugat</label>
                    <input type="text" name="penggugat" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Tergugat</label>
                    <input type="text" name="tergugat" class="w-full p-2 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Keterangan</label>
                    <textarea name="keterangan" class="w-full p-2 border border-gray-300 rounded"></textarea>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <button type="button" onclick="toggleModal('modal1')"  class="px-4 py-2 mr-2 text-gray-600 bg-gray-100 rounded hover:bg-gray-200" onclick="toggleModal()">Batal</button>
                    <button type="submit" id="btnSave" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>



{{-- modal show --}}
<div id="modalShow" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900 bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white w-full max-w-lg p-5 rounded shadow-lg">
            <div class="flex justify-between items-center border-b pb-2">
                <h3 id="modalTitle" class="text-lg font-semibold">Jadwal Sidang</h3>
                <button onclick="toggleModal('modalShow')" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <div id="modalContent" class="mt-4 space-y-2">
                <!-- Konten detail akan dimasukkan di sini -->
            </div>
            <div class="flex justify-end mt-4">
                <button onclick="toggleModal('modalShow')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">Tutup</button>
            </div>
        </div>
    </div>
</div>
