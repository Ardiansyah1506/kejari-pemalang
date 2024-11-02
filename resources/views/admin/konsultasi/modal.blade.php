<!-- Modal untuk Tambah dan Edit Berita -->
<div class="fixed z-10 overflow-y-auto inset-0 hidden" id="modal">
    <div class="p-10 xs:p-0 h-1/2 mx-auto w-full max-w-xl">
        <div class="bg-white shadow w-full rounded-lg divide-y divide-gray-200">
            <div class="flex justify-between items-center p-2 pb-0">
                <h1 class="text-xl" id="modal-title">Koneksi WhatsApp</h1>
                <button type="button" class="py-2 px-4 rounded hover:bg-gray-100" onclick="toggleModal()">
                    &#10005;
                </button>
            </div>
            <hr>
            <div class="px-5 py-7">
                <div class="flex justify-center items-center" id="qrCodeContainer">
                    <img id="qrCodeImg" class="hidden md:w-54 md:h-54" alt="QR Code">
                </div>
                <div class="text-center my-4" id="statusDiv">Loading...</div>
                <div class="flex justify-center items-center mt-4">
                    <button id="logoutBtn" class="transition duration-200 bg-[#006E61] bg-opacity-50 hover:bg-opacity-100 text-white w-full py-2.5 rounded-lg shadow-sm hover:shadow-md font-semibold hidden">
                        <span class="inline-block">Logout</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
