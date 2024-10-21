<aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
    <div class="p-3">
        <img src="{{ asset('logo.png') }}" class="md:w-44 w-56 " alt="" />
    </div>
    <nav class=" text-base font-semibold pt-3 p-3">
        <a href="{{ route('admin.user.index') }}"
            class="flex items-center  opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
            <i class='mr-3'><img src="{{ asset('sidebar-user.png') }}" alt=""></i>
            Manajemen User
        </a>
        <a href="{{ Route('admin.berita.index') }}" class="flex items-center active-nav-link  py-4 pl-6 nav-item">
            <i class=" mr-3"><img src="{{ asset('Vector.png') }}" alt=""></i>
            Kelola Berita
        </a>
        <a href="{{ route('admin.galeri.index') }}"
            class="flex items-center  opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
            <i class=" mr-3"><img src="{{ asset('galery-icon.png') }}" alt=""></i>
            Kelola Galeri
        </a>
        <a href="{{ route('admin.konsultasi.index') }}"
            class="flex items-center  opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
            <i class=" mr-3"><img src="{{ asset('konsultasi-icon.png') }}" alt=""></i>

            Forum Konsultasi
        </a>
    </nav>
    <a href="{{ route('logout') }}" id="logoutButton"
        class="absolute w-full  bottom-0 flex items-center justify-center py-4">
        <i class="mr-3"><img src="{{ asset('logout-icon.png') }}" alt=""></i>
        Logout
    </a>
</aside>

<div class="relative w-full flex flex-col h-screen overflow-y-hidden">

    <!-- Mobile Header & Nav -->
    <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
        <div class="flex items-center justify-between">
            <img src="{{ asset('logo.png') }}" class="md:w-44 w-56 items-center" alt="" />
            <button @click="isOpen = !isOpen" class=" text-3xl focus:outline-none">
                <i x-show="!isOpen" class="fas fa-bars"></i>
                <i x-show="isOpen" class="fas fa-times"></i>
            </button>
        </div>

        <!-- Dropdown Nav -->
        <nav :class="isOpen ? 'flex' : 'hidden'" class="flex flex-col pt-4">
            <button @click="isOpen = !isOpen"
                class="relative z-10 rounded-full overflow-hidden hover:cursor-default  focus:border-gray-300 focus:outline-none">
                <div class="flex justify-start py-1 px-3 items-center bg-[#f2f2f3] rounded-md text-white">
                    <i
                        class="fa-regular fa-circle-user  text-4xl text-[#718096] hover:text-blue-700 transition font-medium duration-500 "></i>
                    <div class="flex items-start flex-col text-black md:text-md py-1 px-2">
                        <small class="font-bold">{{ $user->name }}</small>
                        <small class="text-[#718096]">Admin</small>
                    </div>
                </div>
            </button>

            <a href="{{ route('admin.user.index') }}"
                class="flex items-center  opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                <i class='mr-3'><img src="{{ asset('sidebar-user.png') }}" alt=""></i>
                Manajemen User
            </a>
            <a href="{{ Route('admin.berita.index') }}" class="flex items-center active-nav-link  py-2 pl-4 nav-item">
                <i class=" mr-3"><img src="{{ asset('Vector.png') }}" alt=""></i>
                Kelola Berita
            </a>
            <a href="{{ route('admin.galeri.index') }}"
                class="flex items-center  opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                <i class=" mr-3"><img src="{{ asset('galery-icon.png') }}" alt=""></i>
                Kelola Galeri
            </a>
            <a href="{{ route('admin.konsultasi.index') }}"
                class="flex items-center  opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                <i class=" mr-3"><img src="{{ asset('konsultasi-icon.png') }}" alt=""></i>

                Forum Konsultasi
            </a>
            <a href="{{ route('logout') }}" id="logoutButton"
                class="flex items-center  opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                <i class="mr-3"><img src="{{ asset('logout-icon.png') }}" alt=""></i> Logout

            </a>

        </nav>

    </header>
    <!-- Desktop Header -->
    <header
        class="w-full hidden md:flex md:justify-between justify-center items-center md:bg-white py-4 px-2 md:px-10 ">
        <h1 class="text-xl md:text-2xl font-semibold ">{{ $pageTitle }}</h1>
        <a href="{{ route('home') }}"
            class="flex justify-center py-1 px-2 items-center bg-[#f2f2f3] rounded-md text-white">
            <i
                class="fa-regular fa-circle-user  text-xl md:text-2xl text-[#718096] hover:text-blue-700 transition font-medium duration-500 "></i>
            <div class="flex items-start flex-col text-black text-sm md:text-md  px-1 md:px-2">
                <small class="font-bold">{{ $user->name }}</small>
                <small class="text-[#718096]">Admin</small>
            </div>
        </a>

    </header>
