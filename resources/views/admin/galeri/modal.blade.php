<!-- Modal untuk Tambah dan Edit Berita -->
<div class="fixed z-10 overflow-y-auto top-0 w-full left-0 hidden" id="modal">
    <div class="p-10 xs:p-0 mx-auto md:w-full md:max-w-xl">
        <div class="bg-white shadow w-full rounded-lg divide-y divide-gray-200">
            <div class="flex justify-between items-center p-4 pb-0">
                <h1 class="md:text-xl text-sm" id="modal-title">Tambah Galeri</h1>
                <button type="button" class="py-2 px-4 rounded hover:bg-gray-100 mr-2" onclick="toggleModal()">
                    &#10005;</button>
            </div>
            <hr>
            <div class="px-5 py-7">
                <form id="form-galeri" method="POST" enctype="multipart/form-data" class="flex gap-2 flex-col">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div>
                        <label class="font-semibold text-sm text-gray-600 pb-1 block">Keterangan Foto</label>
                        <input type="text" name="judul" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" required />
                    </div>
                    <div class="flex flex-col">
                        <label class="font-semibold text-sm text-gray-600 pb-1 block">Foto</label>
                        <input type="file" name="foto" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                        <div id="link" class="">
                            </div>                        
                    </div>

                    <button type="submit" class="transition duration-200 bg-blue-500 hover:bg-blue-600 focus:bg-blue-700 focus:shadow-sm focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 text-white w-full py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
                        <span class="inline-block mr-2">Simpan</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
