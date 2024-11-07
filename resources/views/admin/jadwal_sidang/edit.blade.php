@extends('layout.app2')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Edit Jadwal Sidang</h2>

        <form action="{{ route('admin.sidang.update', $jadwalSidang->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Perkara</label>
                <input type="text" name="perkara" value="{{ $jadwalSidang->perkara }}" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Agenda</label>
                <input type="text" name="agenda" value="{{ $jadwalSidang->agenda }}" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Tanggal Sidang</label>
                <input type="date" name="tanggal_sidang" value="{{ $jadwalSidang->tanggal_sidang }}" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Penggugat</label>
                <input type="text" name="penggugat" value="{{ $jadwalSidang->penggugat }}" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Tergugat</label>
                <input type="text" name="tergugat" value="{{ $jadwalSidang->tergugat }}" class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Keterangan</label>
                <textarea name="keterangan" class="w-full p-2 border border-gray-300 rounded">{{ $jadwalSidang->keterangan }}</textarea>
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
            <a href="{{ route('admin.sidang.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Kembali</a>
        </form>
    </div>
@endsection
