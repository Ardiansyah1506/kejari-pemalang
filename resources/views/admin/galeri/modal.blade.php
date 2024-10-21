<!-- Modal untuk Tambah dan Edit Berita -->
<div class="fixed z-10 overflow-y-auto  top-0 w-full left-0 hidden" id="modal">
    <div class="p-10 xs:p-0 h-1/2 mx-auto md:w-full md:max-w-xl">
        <div class="bg-white shadow w-full rounded-lg divide-y divide-gray-200">
            <div class="flex justify-between items-center p-2 pb-0">
                <h1 class="md:text-xl text-sm" id="modal-title">Tambah Berita</h1>
                <button type="button" class="py-2 px-4 rounded hover:bg-gray-100 mr-2" onclick="toggleModal()">
                    &#10005;</button>
            </div>
            <hr>
            <div class="px-5 py-7">
                <form id="form-galeri" method="POST" enctype="multipart/form-data" class="flex gap-2 flex-col">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div>
                        <label class="font-semibold text-sm text-gray-600 pb-1 block">Judul </label>
                        <input type="text" name="judul" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" required />
                    </div>

                <div class="px-2"> 
                    <label for="foto" class="block mb-2 text-sm font-medium">Foto</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="foto"
                            class="flex flex-col items-center justify-center w-full h-20 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer">
                            <div class="flex flex-col items-center justify-center pt-5 pb-2">
                                <svg class="w-4 h-4 mb-4 text-gray-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500">
                                    <span class="font-semibold">Click to upload</span> or drag
                                    and drop
                                </p>
                            </div>
                            <input id="foto" name="foto" type="file" class="hidden"  />
                        </label>
                    </div>
                </div>
                    <small id="link" class=" py-1 flex w-full justify-end">
                </small>                        
                <div class="flex justify-center items-center p-3">
                    <button type="submit" class="transition duration-200 bg-[#006E61] bg-opacity-50 hover:bg-opacity-100  focus:bg-[#006E61] focus:bg-opacity-100 focus:shadow-sm focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 text-white w-full py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
                        <span class="inline-block mr-2">Simpan</span>
                    </button>

                </div>
                </form>
            </div>
        </div>
    </div>
</div>


