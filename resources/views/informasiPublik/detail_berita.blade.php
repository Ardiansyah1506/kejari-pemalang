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
    <div class="w-full bg-white p-8 min-h-[500px] rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-green-800 mb-4">{{ $data->judul }}</h1>
        <p class="text-sm text-[#006E61] mb-5 capitalize">
            {{ $data->publisher }} | 
            @php
                $createdAt = \Carbon\Carbon::parse($data->created_at);
                $now = \Carbon\Carbon::now();

                // Hitung selisih waktu
                $diffInMinutes = $now->diffInMinutes($createdAt);
                $diffInHours = $now->diffInHours($createdAt);
                $diffInDays = $now->diffInDays($createdAt);
                
                // Format tanggal sesuai ketentuan
                if ($diffInMinutes < 1) {
                    // Jika kurang dari 1 menit
                    echo 'baru saja';
                } elseif ($diffInMinutes < 60) {
                    // Jika kurang dari 1 jam
                    echo $diffInMinutes . ' menit yang lalu';
                } elseif ($diffInHours < 24) {
                    // Jika kurang dari 1 hari
                    echo $diffInHours . ' jam yang lalu';
                } elseif ($diffInDays <= 7) {
                    // Jika kurang dari atau sama dengan 7 hari
                    echo $createdAt->diffForHumans(); // Misal "2 hari yang lalu"
                } else {
                    // Jika lebih dari 7 hari
                    echo $createdAt->translatedFormat('l, d F Y'); // Format: "Sabtu, 05 Oktober 2024"
                }
            @endphp
        </p>
        <img src="{{ asset('foto_berita/' . $data->foto) }}" alt="Kejaksaan Agung"
            class="aspect-[4/3] mr-5 mb-4 w-full md:w-1/3 float-left object-cover rounded-lg">
        <div class="w-full md:w-full text-justify">
            {!! $data->deskripsi !!}
        </div>
    </div>
@endsection
@section('js-library')
@endsection

@section('js-custom')
@endsection
