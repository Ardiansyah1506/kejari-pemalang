@extends('layout.app2')

@section('css-library')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .bg-custom-green {
            background: #228d81;
        }
    </style>
@endsection

@section('content')
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif


    <!-- component -->
    <div class="text-gray-900 bg-white rounded shadow-md w-full">
        <div class="p-6 rounded-md max-w-6xl mx-auto mt-8">
            <!-- Header -->
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.konsultasi.index') }}">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                    </a>
                    @if ($data->id_forum == null)
                        <span class="bg-blue-200 p-2 rounded-md text-xs">
                            Baru
                        </span>
                    @else
                        <span class="bg-green-200 p-2 rounded-md text-xs">
                            Terjawab
                        </span>
                    @endif
                    <h2 class="text-lg font-semibold text-emerald-800">{{ $data->nama }}</h2>
                </div>

                <button><i class="fa-solid fa-trash-can text-red-500 text-md py-1 px-2 rounded-md"></i></button>
            </div>
            <!-- Forum Item 1 -->
            <div class=" mb-6">
                <div class="p-4 flex flex-col gap-2">
                    <p class="font-bold text-emerald-800">Anonim</p>
                    <p class="text-gray-700 mt-2">{{ $data->keterangan }}</p>
                    <div class="flex justify-between items-center">
                        <div class="text-green-400 flex flex-col">
                            <small>{{ $data->nama }} {{ $data->no_hp }} - {{ $data->email }}</small>
                            <small>{{ $data->alamat }}</small>
                        </div>

                        @if ($data->dokumen_pendukung && file_exists(public_path('berkas_konsultasi/' . $data->dokumen_pendukung)))
                            <a href="{{ asset('berkas_konsultasi/' . $data->dokumen_pendukung) }}" target="_blank"
                                class="text-md border border-1 rounded-md p-2 flex items-center gap-2">
                                <i class="fa-solid fa-file-arrow-down text-gray-400 text-xl"></i>
                                <span class="text-sm text-green-400">Unduh Dokumen</span>
                            </a>
                        @else
                            <span class="text-sm text-red-500">Dokumen tidak tersedia</span>
                        @endif
                    </div>
                </div>

                <hr>

                @if ($data->id_forum !== null)
                    <!-- Response -->
                    <div class="bg-[#eeb230] ml-6 bg-opacity-30 p-4 mt-4 rounded-md">
                        <p class="font-semibold text-emerald-800">Kejaksaan Negeri Pemalang <span>😊</span></p>
                        <ol class="list-decimal list-inside text-emerald-800 mt-2 space-y-1">
                            {!! $data->jawaban !!}
                        </ol>
                        <p class="text-sm text-gray-500 mt-2">10 Oktober 2024</p>
                    </div>
                @else
                    <div class="mt-4 ml-6 p-3">
                        <div id="editor" class="border rounded-lg px-3 py-2 mt-1 mb-5 min-h-[100px] text-sm w-full">
                        </div>
                        <input type="hidden" name="deskripsi" id="deskripsi" />
                        <div class="flex justify-end  w-full">
                            <button type="submit" data-id={{ $data->id }} class="bg-blue-200 px-4 py-2 rounded-md"
                                id="btn">Kirim</button>

                        </div>
                @endif
            </div>

        </div>
    </div>
@endsection

@section('js-library')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('vendor/quill/quill.js') }}"></script>
@endsection

@section('js-custom')
    <script>
        $(document).ready(function() {
            console.log('pppp')
            var quill = new Quill('#editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        ['link', 'code-block'],
                        [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }],
                        [{
                            'align': []
                        }],
                        ['clean']
                    ]
                }
            });

            // Saat tombol submit ditekan
            $(document).on('click', '#btn', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Pastikan tombol terdeteksi
                console.log('Button clicked');

                // Ambil konten Quill
                var descriptionInput = document.querySelector('#deskripsi');
                descriptionInput.value = quill.root.innerHTML;

                console.log('Quill content:', descriptionInput.value);

                // Ambil ID dari data-id tombol
                var id = $(this).data('id');
                console.log('ID:', id);

                // CSRF token
                var token = $('meta[name="csrf-token"]').attr('content');
                console.log('CSRF token:', token);

                // Data yang akan dikirim
                // Change 'id' to 'id_forum'
                var data = {
                    _token: token,
                    deskripsi: $('#deskripsi').val(),
                    id_forum: id 
                };

                console.log('Data being sent:', data);

                // Kirim data menggunakan AJAX
                $.ajax({
                    url: "{{ route('admin.konsultasi.store') }}", // URL post
                    type: "POST",
                    data: data,
                    success: function(response) {
                        console.log('Response:', response);
                        alert("Jawaban berhasil dikirim.");
                    },
                    error: function(xhr, status, error) {
                        console.error('Error response:', xhr.responseText);
                        alert("Gagal mengirim jawaban.");
                    }
                });
            });
        });
    </script>
@endsection
