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
    <div class="container mx-auto px-6 py-10 rounded-lg">
        <h3 class="text-2xl font-semibold text-green-800 mb-1 ">Galeri</h3>
        <hr class="my-4 h-1 border " style="background: linear-gradient(to right, #eeb230 20%, #718096 20%)">
        <div class="grid md:grid-cols-4 grid-cols-2  gap-4 grid-row-2">
            <div class=" row-span-2 aspect-[4/3] col-span-2">
                <img class="w-full h-full object-cover rounded-md"
                    src="{{asset('foto_galeri/'.$galeriFirst->foto)}}" alt="Random image">
            </div>

                @foreach ($galeri as $data)
                @if ($loop->iteration < 4)
                    
                    <div class="relative  col-span-1 row-span-1 ">
                        <img class="w-full h-full object-cover rounded-md"
                            src="{{asset('foto_galeri/'.$data->foto)}}" alt="Random image">
                      
                    </div>
                    @else
                    <div class="relative  col-span-1 row-span-1 ">
                        <img class="w-full h-full object-cover rounded-md"
                        src="{{asset('foto_galeri/'.$data->foto)}}" alt="Random image">
                            <div class="absolute inset-0 rounded-md bg-gray-600 bg-opacity-50 flex items-center justify-center">
                                <h2 class="text-white flex flex-col text-center text-3xl font-bold"><div class="border border-1 rounded-full p-3"><i class="fa-regular fa-arrow-up  text-xl md:text-4xl text-[#718096] hover:text-blue-700 transition font-medium duration-500 "></i></div> <span>Selengkapnya</span></h2>
                            </div>
                    </div>
                    @endif
                  
                @endforeach
        </div>
     
     
        <h3 class="text-2xl font-semibold text-green-800 mb-1 mt-20 ">BERITA</h3>
        <hr class="my-4 h-1 border " style="background: linear-gradient(to right, #eeb230 20%, #718096 20%)">

        <div class="grid md:grid-cols-4 grid-cols-1 gap-6">
            @foreach ($berita as $data)
                <div
                    class="flex md:flex-row col-span-1 md:col-span-4 flex-col-reverse gap-5 justify-center items-center p-4">
                    <div>
                        <h4 class="text-md font-semibold text-green-800 mb-2">{{ $data->judul }}</h4>
                        <p class="text-gray-600 text-sm bg-red-500">{!! $data->deskripsi !!}</p>
                        <div class="flex justify-between text-sm items-center mt-5 text-gray-500">
                            <span class="mr-2 ">{{ $data->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <img src="{{ asset('foto_berita/' . $data->foto) }}" class="md:aspect-[4/3] md:w-1/4  " alt="">
                </div>
            @endforeach

            <!-- Additional articles... -->

        </div>
    </div>
@endsection

@section('js-library')
@endsection

@section('js-custom')
@endsection
