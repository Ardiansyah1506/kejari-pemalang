@extends('layout.app2')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Detail Jadwal Sidang</h2>
        <p><strong>Perkara:</strong> {{ $jadwalSidang->perkara }}</p>
        <p><strong>Agenda:</strong> {{ $jadwalSidang->agenda }}</p>
        <p><strong>Tanggal Sidang:</strong> {{ $jadwalSidang->tanggal_sidang }}</p>
        <p><strong>Penggugat:</strong> {{ $jadwalSidang->penggugat }}</p>
        <p><strong>Tergugat:</strong> {{ $jadwalSidang->tergugat }}</p>
        <p><strong>Keterangan:</strong> {{ $jadwalSidang->keterangan }}</p>

        <a href="{{ route('admin.sidang.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 inline-block">Kembali</a>
    </div>
@endsection
