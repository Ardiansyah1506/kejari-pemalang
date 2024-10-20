@extends('layout.app')

@section('css-custom')
@endsection

@section('css-library')
@endsection


@section('content')
<div class="container mx-auto rounded-lg p-4">
    <h3 class="text-2xl font-semibold text-green-800 mb-1 ">BERITA</h3>
    <hr class="my-4 h-1 border" style="background: linear-gradient(to right, #eeb230 20%, #718096 20%)">

    <div class="grid md:grid-cols-4 grid-cols-2 gap-6">
        @foreach ($berita as $data)
            <div class="gap-2 grid-cols-1 items-center aspect-[5/3] p-3 bg-white rounded-lg shadow-md">
                <img src="{{ asset('foto_berita/' . $data->foto) }}" class="aspect-[4/3] w-full object-cover rounded-lg" alt="">
                <div class="flex flex-col h-full justify-evenly">
                    <a href="{{route('berita.detail',$data->id)}}" class="text-xs md:text-md font-semibold text-green-800">{{ $data->judul }}</a>
                    <div class="md:flex hidden flex-col justify-between text-sm  items-center mt-5 text-gray-500">
                        <span class="mr-2 line-clamp-3">{!! $data->deskripsi !!}</span>
                    </div>
                  
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection

@section('js-library')
@endsection

@section('js-custom')
@endsection
