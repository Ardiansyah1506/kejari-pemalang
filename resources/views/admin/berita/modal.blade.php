<!-- Modal untuk Tambah Berita -->
<div id="modal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-75">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md px-5">
        <div class=" py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 id="modal-title" class="text-xl font-semibold text-gray-800">Tambah Jadwal Sidang</h2>
            <button type="button" class="py-2 px-4 rounded hover:bg-gray-100 mr-2" onclick="toggleModal()">
                &#10005;</button>
        </div>
                <form id="form-berita" method="POST" enctype="multipart/form-data" class="py-2">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div>
                        <label class="font-semibold text-sm text-gray-600 pb-1 block">Judul Berita</label>
                        <input type="text" name="judul" id="judul" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" required />
                    </div>

                    <div>
                        <label class="font-semibold text-sm text-gray-600 pb-1 block">Isi Berita</label>
                        <div id="editor" class="border rounded-lg px-3 py-2 mt-1  text-sm w-full" style="height: 100px;"></div>
                        <input type="hidden" name="deskripsi" id="deskripsi" />
                    </div>
                    <div class="px-2 py-2">
                        <label for="foto" class="block mb-2 text-sm font-medium">Foto</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="foto" class="flex flex-col items-center justify-center w-full h-20 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer">
                                <div class="flex flex-col items-center justify-center pt-5 pb-2">
                                    <svg class="w-4 h-4 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Click to upload</span> or drag
                                        and drop
                                    </p>
                                </div>
                                <input id="foto" name="foto" type="file" class="hidden" />
                            </label>
                        </div>
                    </div>
                <small id="link" class=" flex w-full justify-end">
                </small> 
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <button type="button" class="px-4 py-2 mr-2 text-gray-600 bg-gray-100 rounded hover:bg-gray-200" onclick="toggleModal()">Batal</button>
                    <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    


