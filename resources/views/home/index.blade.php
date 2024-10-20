@extends('layout.app')

@section('css-custom')
    <style>
        .hero {
            height: 600px;
        }

        @media screen and (max-width: 600px) {
            .hero {
                height: 200px;
            }
        }
    </style>
@endsection

@section('css-library')
@endsection


@section('content')
    <section class="relative hero overflow-hidden ">
        <img src="{{ asset('download.png') }}" alt="Gavel" class="absolute w-full h-full object-cover z-0 ">
        <div class="relative z-10 bg-black bg-opacity-50 h-full flex items-center">
            <div class="container mx-auto px-6">
                <h2 class="text-xl md:text-5xl text-white font-bold mb-2">Tegakkan Keadilan Bersama Kami!</h2>
                <p class="text-white md:text-x; text-sm mb-4">Lindungi hak Anda dan dapatkan layanan hukum terbaik.</p>
                <a href="#" class="bg-[#71809640] text-white px-px-2 py-2 md:px-4 md:py-2 rounded">Layanan Publik</a>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-6 py-10 rounded-lg">
        <h3 class="text-2xl font-semibold text-green-800 mb-1 ">BERITA UTAMA</h3>
        <hr class="my-4 h-1 border " style="background: linear-gradient(to right, #eeb230 20%, #718096 20%)">

        <div class="grid md:grid-cols-4 grid-cols-1 gap-6">
            @foreach ($data as $berita)
            @if($loop->iteration <= 2)

            <div class="flex md:flex-row col-span-1 md:col-span-4 flex-col-reverse gap-5 justify-center items-center p-4">
                    <div>
                        <h4 class="text-md font-semibold text-green-800 mb-2">{{ $berita->judul }}</h4>
                        <p class="text-gray-600 text-sm line-clamp-4">{!! $berita->deskripsi !!}</p>
                        <div class="flex justify-between text-sm items-center mt-5 text-gray-500">
                            <span class="mr-2 ">{{ $berita->created_at->format('d/m/Y') }}</span>
                            <a href="{{route('berita.detail',$berita->id)}}">Selengkapnya...</a>
                        </div>
                    </div>
                    <img src="{{ asset('foto_berita/' . $berita->foto) }}" class="md:aspect-[4/3] md:w-1/4  " alt="">
                </div>
                @else
                <div class="gap-2 items-center p-4 aspect-[5/3]">
                    <img src="{{ asset('foto_berita/' . $berita->foto) }}" class="aspect-[4/3] w-full object-contain" alt="">
                    <div class="flex flex-col h-full justify-evenly ">
                        <h4 class="text-md font-semibold  text-green-800 mb-2 overflow-hidden line-clamp-4">{{ $berita->judul }}</h4>
                        <div class="flex justify-between text-sm  items-center mt-5 text-gray-500">
                            <span class="mr-2 ">{{ $berita->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
                @endif

            @endforeach
      
            <!-- Additional articles... -->
      
        </div>
    </div>
    @endsection

    @section('js-library')
    @endsection

    @section('js-custom')
    @endsection
