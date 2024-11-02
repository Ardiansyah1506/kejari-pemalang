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

            <a href="https://api.whatsapp.com/send?phone={{ // Memeriksa apakah nomor diawali dengan '0' dan mengubahnya jika perlu
    substr($data->no_hp, 0, 1) === '0' ? '+62' . substr($data->no_hp, 1) : $data->no_hp }}&text={{ urlencode('Halo, saya Admin Kejaksaan Negeri Pemalang. Terima kasih telah mengajukan pertanyaan melalui website kami.  Kami siap membantu menjawab pertanyaan Anda. Jika ada informasi tambahan yang Anda butuhkan atau pertanyaan lain yang ingin disampaikan, silakan kirimkan melalui pesan ini. Kami akan berusaha memberikan jawaban secepatnya. Terima kasih! 🙏😊') }}"
                target="_blank" rel="noopener noreferrer" id="no_hp">
                <i class="fa-brands fa-whatsapp text-green-500 text-2xl py-1 px-2 rounded-md"></i>
            </a>


        </div>
        <!-- Forum Item 1 -->
        <div class=" mb-6">
            <div class="p-4 flex flex-col gap-2">
                <p class="font-bold text-emerald-800">{{ $data->nama }}</p>
                <span class="text-gray-700 mt-2 text-sm md:text-md max-w-fit">{{ $data->keterangan }}</span>
                <div class="flex justify-between flex-col-reverse md:flex-row items-center">
                    <div class="text-green-400 flex flex-col">
                        <small>{{ $data->nama }} {{ $data->no_hp }} - {{ $data->email }}</small>
                        <small>{{ $data->alamat }}</small>
                    </div>

                    @if ($data->dokumen_pendukung && file_exists(public_path('berkas_konsultasi/' . $data->dokumen_pendukung)))
                        <a href="{{ asset('berkas_konsultasi/' . $data->dokumen_pendukung) }}" target="_blank"
                            class="text-md border border-1 rounded-md p-2 flex items-center gap-2">
                            <i class="fa-solid fa-file-arrow-down text-gray-400 text-xl"></i>
                            <span class="text-sm text-green-400">Lihat Dokumen</span>
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
                            <p class="text-sm text-gray-500 mt-2 capitalize" id="time">
                                @php
                                    $createdAt = \Carbon\Carbon::parse($data->waktu_jawab);
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
    $(document).ready(function () {
        
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
        $(document).on('click', '#btn', function (e) {
            e.preventDefault(); // Prevent default form submission

            // Ambil konten Quill
            var descriptionInput = document.querySelector('#deskripsi');
            descriptionInput.value = quill.root.innerHTML;

            // Get the value of the input field
           
        const whatsappLink = document.getElementById("no_hp");
        // Get the href attribute
  const href = whatsappLink.getAttribute("href");

// Extract the phone number from the URL
const urlParams = new URLSearchParams(href.split('?')[1]);
const number = urlParams.get('phone');

            // Ambil ID dari data-id tombol
            var id = $(this).data('id');

            // CSRF token
            var token = $('meta[name="csrf-token"]').attr('content');

            // Data yang akan dikirim
            var data = {
                _token: token,
                deskripsi: $('#deskripsi').val(),
                id_forum: id
            };

            // Kirim data menggunakan AJAX
            $.ajax({
                url: "{{ route('admin.konsultasi.store') }}",
                type: "POST",
                data: data,
                success: async function (response) {
                    alert("Jawaban berhasil dikirim.");
                    try {
                        const response = await fetch('https://express-wa-api-production.up.railway.app/send-message', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ number, message }), // Ensure 'message' is defined
                        });

                        const resultText = await response.text();  // Fetch response as text for inspection
                        console.log("Raw response text:", resultText);

                        // Try parsing JSON if valid
                        const result = JSON.parse(resultText);
                        alert(result.status || result.message);
                    } catch (error) {
                        console.error('Error parsing or fetching message:', error);
                        alert('Error sending message');
                    }
                },
                error: function (xhr, status, error) {
                    alert("Gagal mengirim jawaban.");
                }
            });
        });


    });
</script>
@endsection