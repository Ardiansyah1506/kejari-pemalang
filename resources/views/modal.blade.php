<div class="fixed z-10 overflow-y-auto top-0 w-full left-0 hidden" id="modal">
    <div class="min-h-screen flex flex-col justify-center sm:py-12">
        <div class="p-10 xs:p-0 mx-auto md:w-full md:max-w-md">
            <div class="bg-white shadow-lg w-full rounded-lg divide-y divide-gray-200 transition duration-300 transform scale-95 opacity-0" id="modal-content">
                <div class="flex justify-between items-center p-4 pb-0">
                    <h1 class="md:text-xl text-sm">Login Form</h1>
                    <button type="button" class="py-2 px-4 rounded hover:bg-gray-100 mr-2" onclick="toggleModal()"> &#10005;</button>
                </div>
                <hr>
                <div class="px-5 py-7">
                    <form action="{{Route('actionLogin')}}" method="POST">
                        @csrf    
                        <label class="font-semibold text-sm text-gray-600 pb-1 block">Username</label>
                        <input type="text" name="username" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                        <label class="font-semibold text-sm text-gray-600 pb-1 block">Password</label>
                        <input type="password" name="password" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                        <button type="submit" class="transition duration-200 bg-[#006E61] bg-opacity-50 hover:bg-opacity-100  focus:bg-[#006E61] focus:bg-opacity-100 focus:shadow-sm focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 text-white w-full py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
                            <span class="inline-block mr-2">Login</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
