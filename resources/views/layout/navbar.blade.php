<header class="flex justify-between md:px-20 p-2">
    <div class="">
        <a href="#">
          <img src="{{asset('logo.png')}}" class="md:w-44 w-56 items-center" alt="" />
        </a>
      </div>  
      
      <button class="" onclick="toggleModal()"><i class="fa-regular fa-circle-user px- text-3xl text-[#718096] hover:text-blue-700 transition font-medium duration-500 "></i></button>
</header>
<navbar
class="md:flex flex-wrap items-center justify-end md:justify-center bg-[#EEB230] w-full py-4 md:py-0 px-4 text-lg text-gray-700"
>
<svg
  xmlns="http://www.w3.org/2000/svg"
  id="menu-button"
  class="h-6 w-6 cursor-pointer md:hidden block"
  fill="none"
  viewBox="0 0 24 24"
  stroke="currentColor"
>
  <path
    stroke-linecap="round"
    stroke-linejoin="round"
    stroke-width="2"
    d="M4 6h16M4 12h16M4 18h16"
  />
</svg>

<div class="hidden w-full md:flex md:items-center md:w-auto" id="menu">
  <ul
    class="pt-4 text-base text-gray-700 md:flex md:justify-between md:pt-0"
  >
    <li class="md:p-6 py-2">
      <a
        class="block nav-active hover:text-black-400 text-sm hover:font-extrabold"
        href="{{route('home')}}"
        >Home</a
      >
    </li>
    <li class="md:p-6 py-2">
      <a
        class="block hover:text-black-400 text-sm hover:font-extrabold"
        {{-- href="{{route('informasiPublik.index')}}" --}}
        href="{{Route('404')}}"
        >Informasi Publik</a
      >
    </li>
    <li class="md:p-6 py-2">
      <a
        class="block hover:text-black-400 text-sm hover:font-extrabold"
        {{-- href="{{Route('konsultasi.index')}}" --}}
        href="{{Route('404')}}"
        >Informasi Pelayanan Publik</a
      >
    </li>
  </ul>
</div>
</navbar>