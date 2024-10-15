@extends('layout.app')

@section('css-library')

@endsection

@section('content')
<div class="container mx-auto px-6 py-10 rounded-lg">
    <h3 class="text-2xl font-semibold text-green-800 mb-1">
        Konsultasi Hukum
    </h3>
    <hr class="my-4 h-1 border " style="background: linear-gradient(to right, #eeb230 20%, #718096 20%)">
    <div class="flex flex-col-reverse md:flex-row md:justify-between md:gap-6 gap-10 p-5">
        <form class="md:w-1/3">
            <div class="grid gap-6 mb-6 md:grid-cols-1">
                <div>
                    <label for="nama lengkap" class="block mb-2 text-sm font-medium">Nama Lengkap</label>
                    <input type="text" id="nama"
                        class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Masukkan Nama Anda" required />
                </div>
                <div>
                    <label for="alamat" class="block mb-2 text-sm font-medium">Alamat</label>
                    <input type="text" id="alamat"
                        class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Masukkan Alamat Anda" required />
                </div>
                <div>
                    <label for="company" class="block mb-2 text-sm font-medium">Email</label>
                    <input type="text" id="email"
                        class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Flowbite" required />
                </div>
                <div>
                    <label for="Nomor Telepon" class="block mb-2 text-sm font-medium">Nomor Telepon</label>
                    <input type="tel" id="phone"
                        class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="085******" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required />
                </div>
                <div>
                    <label for="website" class="block mb-2 text-sm font-medium">Website URL</label>
                    <textarea id="message" rows="4"
                        class="block p-2.5 w-full text-sm rounded-lg border focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Write your thoughts here..."></textarea>
                </div>
                <div>
                    <label for="visitors" class="block mb-2 text-sm font-medium">Dokumen Pendukung</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file"
                            class="flex flex-col items-center justify-center w-full h-22 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-semibold">Click to upload</span> or drag
                                    and drop
                                </p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" />
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Submit
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
                    Jika tersedia, unggah dokumen pendukung seperti foto, laporan
                    polisi, atau dokumen lainnya yang relevan dengan permasalahan
                    hukum.
                </li>
                <li>
                    Setelah mengisi semua informasi yang diperlukan, klik kirim
                    formulir. Anda akan menerima email konfirmasi yang menyatakan
                    bahwa permintaan konsultasi hukum sudah ter-submit dan akan
                    ditinjau lebih lanjut.
                </li>
                <li>
                    Setelah formulir diterima dan ditinjau, Anda dapat menjadwalkan
                    pertemuan dengan pengacara. Pastikan Anda telah menyiapkan dokumen
                    dan informasi yang relevan sebelum sesi konsultasi dimulai.
                </li>
            </div>
        </div>
    </div>
</div>
<div class="bg-[#EEB230] w-full bg-opacity-10">
    <div class="p-6 rounded-md max-w-6xl mx-auto mt-8">
        <!-- Header -->
        <h2 class="text-lg font-semibold text-emerald-800">Forum Konsultasi Online (4)</h2>
        <hr class="my-4 border-emerald-300">

        <!-- Forum Item 1 -->
        <div class="ml-8 mb-6">
            <div class="p-4">

                <p class="font-bold text-emerald-800">Anonim</p>
                <p class="text-gray-700 mt-2">
                    Saya memiliki sengketa tanah dengan tetangga saya. Tanah tersebut sudah saya miliki secara
                    turun-temurun, dan saya juga memiliki sertifikat hak milik.
                    Namun, tetangga saya mengklaim bahwa tanah tersebut adalah bagian dari tanah warisan
                    keluarganya dan ia tidak mengakui sertifikat saya.
                    Tetangga saya telah mengajukan gugatan ke pengadilan terkait kepemilikan tanah tersebut. Apa
                    yang harus saya lakukan untuk mempertahankan hak saya?
                </p>
                <p class="text-sm text-gray-500 mt-2">10 Oktober 2024</p>

                <!-- Response -->
                <div class="bg-[#eeb230] ml-10 bg-opacity-30 p-4 mt-4 rounded-md">
                    <p class="font-semibold text-emerald-800">Kejaksaan Negeri Pemalang <span>😊</span></p>
                    <ol class="list-decimal list-inside text-emerald-800 mt-2 space-y-1">
                        <li>Cek Keabsahan Sertifikat: Pastikan sertifikat tanah Anda valid dan terdaftar di BPN.
                            Jika perlu, lakukan pengecekan ulang di kantor BPN.</li>
                        <li>Siapkan Dokumen Pendukung: Kumpulkan bukti pembayaran pajak, sejarah kepemilikan,
                            dan saksi yang memperkuat klaim Anda.</li>
                        <li>Tanggapi Gugatan Hukum: Segera siapkan tanggapan resmi atas gugatan dengan bantuan
                            pengacara atau penasihat hukum.</li>
                    </ol>
                    <a href="#" class="text-sm text-emerald-600 hover:underline">Read more</a>
                </div>
                <p class="text-sm text-gray-500 mt-2">10 Oktober 2024</p>
            </div>
            <hr>
        </div>
    </div>

    <!-- Load More Button -->
    <div class="flex justify-center mt-4">
        <button class="bg-emerald-200 text-emerald-800 py-2 px-4 rounded-md text-sm hover:bg-emerald-300">
            Tampilkan Lebih Banyak
        </button>
    </div>
</div>

@endsection

@section('js-library')

@endsection

@section('js-custom')

@endsection