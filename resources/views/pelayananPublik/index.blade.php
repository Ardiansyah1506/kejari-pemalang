@extends('layout.app')

@section('css-library')
@endsection

@section('content')
    <div class="container mx-auto px-6 py-10 rounded-lg">
        @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4" id="successMessage" style="display:block;">
            {{ session('success') }}
        </div>
    @elseif (session('warning'))
        <div class="bg-yellow-500 text-white p-4 rounded mb-4" id="warningMessage" style="display:block;">
            {{ session('warning') }} <!-- Use session('warning') instead of warningmessage -->
        </div>
    @elseif (session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4" id="errorMessage" style="display:block;">
            {{ session('error') }}
        </div>
    @endif
    
        <h3 class="text-2xl font-semibold text-green-800 mb-1">
            Konsultasi Hukum
        </h3>
        <hr class="my-4 h-1 border " style="background: linear-gradient(to right, #eeb230 20%, #718096 20%)">
        <div class="flex flex-col-reverse md:flex-row md:justify-between md:gap-6 gap-10 p-5">
            <form class="md:w-1/3" action="{{ route('konsultasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-1">
                    <div>
                        <label for="nama" class="block mb-2 text-sm font-medium">Nama Lengkap<span class="text-red-500 text-sm">*</span></label>
                        <input type="text" id="nama" name="nama"
                            class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Masukkan Nama Anda" required />
                    </div>
                    <div>
                        <label for="alamat" class="block mb-2 text-sm font-medium">Alamat <span class="text-red-500 text-sm">*</span></label>
                        <input type="text" id="alamat" name="alamat"
                            class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Masukkan Alamat Anda" required />
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium">Email</label>
                        <input type="email" id="email" name="email"
                            class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Masukkan Email Anda"/>
                    </div>
                    <div>
                        <label for="nohp" class="block mb-2 text-sm font-medium">Nomor Telepon<span class="text-red-500 text-sm">*</span></label>
                        <input type="tel" id="nohp" name="no_hp"
                            class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="085******" pattern="[0-9]{10,15}" required />
                    </div>
                    <div>
                        <label for="keterangan" class="block mb-2 text-sm font-medium">Keterangan<span class="text-red-500 text-sm">*</span></label>
                        <textarea id="keterangan" name="keterangan" rows="4"
                            class="block p-2.5 w-full text-sm rounded-lg border focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan keterangan tambahan" required></textarea>
                    </div>
                    <div>
                        <label for="dokumen" class="block mb-2 text-sm font-medium">Dokumen Pendukung</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="dokumen"
                                class="flex flex-col items-center justify-center w-full h-22 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Click to upload</span> or drag
                                        and drop
                                    </p>
                                </div>
                                <input id="dokumen" name="dokumen" type="file" class="hidden"  />
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        Kirim
                    </button>
                </div>
            </form>

            <div class="text-sm md:w-1/3 flex flex-col gap-2">
                <h2 class="text-2xl">Tahapan</h2>
                <div class="list-decimal flex flex-col gap-5 md-2 md:ml-4">
                    <li>
                        Silakan mengisi formulir yang tersedia. Masukan informasi dasar
                        seperti nama lengkap, alamat, email, dan nomor telepon. Tambahkan
                        deskripsi singkat mengenai permasalahan hukum yang dihadapi.
                    </li>
                    <li>
                        Jika tersedia, unggah dokumen pendukung seperti foto, 
                        atau dokumen lainnya yang relevan dengan permasalahan
                        hukum.
                    </li>
                    <li>
                        Setelah mengisi semua informasi yang diperlukan, klik kirim
                        formulir. Anda akan menerima WhatsApp konfirmasi yang menyatakan
                        bahwa pertanyaan konsultasi hukum sudah tersubmit.
                    </li>
                    <li>
                        Pertanyaan Anda diterima dan akan ditinjau segera oleh JPN, 
                        dan dalam waktu 3x24 jam Anda akan mendapatkan notifikasi
                        WhatsApp bahwa pertanyaan anda telah dijawab. 
                    </li>
                    <li>
                        Jawaban dapat dicek melaui laman website datunkejaripemalang.com
                    </li>
                    <li>
                        Apabila Anda kurang puas terhadap jawaban yang diberikan
                        Anda dapat datang secara langsung ke Kantor Jaksa Pengacara
                        Negara pada Kejaksaan Negeri Pemalang untuk mendapatkan
                        konsultasi lebih lanjut.
                    </li>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-[#EEB230] w-full bg-opacity-10">
        <div class="p-6 rounded-md max-w-6xl mx-auto mt-8">
            <!-- Header -->
            <h2 class="text-lg font-semibold text-emerald-800">Forum Konsultasi Online ({{ $ForumKonsultasi->total() }})
            </h2>
            <hr class="my-4 border-emerald-300">

            @if ($ForumKonsultasi->isEmpty())
            <div class="flex justify-center items-center p-4">
                <p class="text-gray-600 text-md">Data Forum Kosong</p>
            </div>
        @else
            <!-- Forum Item 1 -->
            @foreach ($ForumKonsultasi as $forum)
                <div class="md:ml-8 ml-0 mb-6">
                    <div class="p-4">
                        <p class="font-bold text-emerald-800">Anonim</p>
                        <p class="text-gray-700 mt-2">{{ $forum->keterangan }}</p>
                        <p class="text-sm text-gray-500 mt-2">{{ $forum->created_at }}</p>

                        @if ($forum->id_forum !== null)
                            <!-- Response -->
                            <div class="bg-[#eeb230] md:ml-10 ml-2 bg-opacity-30 p-4 mt-4 rounded-md">
                                <p class="font-semibold text-emerald-800">Kejaksaan Negeri Pemalang <span>😊</span></p>
                                <ol class="list-decimal text-sm md:text-md list-inside text-emerald-800 mt-2 space-y-1">
                                    {!! $forum->jawaban !!}
                                </ol>
                                <p class="text-sm text-gray-500 mt-2">
                                    @php
                                    $createdAt = \Carbon\Carbon::parse($forum->created_at);
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
                        @endif
                    </div>
                    <hr>
                </div>
            @endforeach
@endif
            <!-- Pagination Links -->
            <div class="mt-6">
                {{ $ForumKonsultasi->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js-library')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('js-custom')
@endsection
