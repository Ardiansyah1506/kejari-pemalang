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
                <h2 class="text-xl md:text-5xl text-white font-bold mb-2">Pelayanan Hukum Cepat Mudah dalam Genggaman</h2>
                <p class="text-white md:text-xl text-sm mb-10">Mempermudah Pelayanan Hukum melalui Teknologi, Melayani Tanpa Kendala Ruang dan Waktu.</p>
                <a href="{{ route('konsultasi.index') }}"
                    class="bg-[#EEB230] hover:bg-[#2d2f3140] text-white px-px-2 py-2 md:px-6 md:py-4 font-bold rounded">Pelayanan
                    Hukum</a>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-6 py-10 rounded-lg">
        <h3 class="text-2xl font-semibold text-green-800 mb-1 ">BERITA UTAMA</h3>
        <hr class="my-4 h-1 border " style="background: linear-gradient(to right, #eeb230 20%, #718096 20%)">

        @if ($data->isEmpty())
            <div class="flex justify-center items-center p-4">
                <p class="text-gray-600 text-md">Data belum tersedia</p>
            </div>
        @else
            <div class="grid md:grid-cols-4 grid-cols-1 gap-6">
                @foreach ($data as $berita)
                    @if ($loop->iteration <= 2)
                        <div
                            class="flex md:flex-row col-span-1 md:col-span-4 flex-col-reverse gap-5 justify-center items-center p-4">
                            <div>
                                <a href="{{ route('berita.detail', $berita->id) }}"
                                    class="text-md font-semibold text-green-800 mb-2">{{ $berita->judul }}</a>
                                <p class="text-gray-600 text-sm line-clamp-4">{!! $berita->deskripsi !!}</p>
                                <div class="flex justify-between text-sm items-center mt-5 text-gray-500">
                                    <span class="mr-2 ">{{ $berita->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            <img src="{{ asset('foto_berita/' . $berita->foto) }}" class="md:aspect-[4/3] md:w-1/4  "
                                alt="">
                        </div>
                    @else
                        <div class="gap-2 items-center p-4 aspect-[5/3]">
                            <img src="{{ asset('foto_berita/' . $berita->foto) }}"
                                class="aspect-[4/3] w-full object-contain" alt="">
                            <div class="flex flex-col h-full justify-evenly ">
                                <h4 class="text-md font-semibold  text-green-800 mb-2 overflow-hidden line-clamp-4">
                                    {{ $berita->judul }}</h4>
                                <div class="flex justify-between text-sm  items-center mt-5 text-gray-500">
                                    <span class="mr-2 ">{{ $berita->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
        @endif

    </div>
    </div>
@endsection

@section('js-library')
@endsection

@section('js-custom')
@endsection
