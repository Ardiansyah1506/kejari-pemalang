@extends('layout.app')

@section('css-custom')
@endsection

@section('css-library')
@endsection


@section('content')
<div class="container mx-auto rounded-lg p-4">
    <h3 class="text-2xl font-semibold text-green-800 mb-1 ">GALERI</h3>
    <hr class="my-4 h-1 border" style="background: linear-gradient(to right, #eeb230 20%, #718096 20%)">

    <div class="grid md:grid-cols-4 grid-cols-2 gap-6">
        @foreach ($galeri as $data)
                <img src="{{ asset('foto_berita/' . $data->foto) }}" class=" w-full object-cover rounded-lg" alt="">
        @endforeach
    </div>
</div>

@endsection

@section('js-library')
@endsection

@section('js-custom')
@endsection
