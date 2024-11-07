<div id="modal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-75">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md px-5">
        <div class=" py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 id="modal-title" class="text-xl font-semibold text-gray-800">Tambah User</h2>
            <button type="button" class="py-2 px-4 rounded hover:bg-gray-100 mr-2" onclick="toggleModal()">
                &#10005;</button>
        </div>
                <form action="{{Route('admin.user.store')}}" method="POST" class="py-2">
                    @csrf    
                    <label class="font-semibold text-sm text-gray-600 pb-1 block">Username</label>
                        <input type="text" name="username" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                        <label class="font-semibold text-sm text-gray-600 pb-1 block">Password</label>
                        <input type="text" name="password" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                        <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                            <button type="button" class="px-4 py-2 mr-2 text-gray-600 bg-gray-100 rounded hover:bg-gray-200" onclick="toggleModal()">Batal</button>
                            <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Simpan</button>
                        </div>
                    </form>
            </div>
        </div>
