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
    <section class="relative hero overflow-hidden ">
        <img src="{{ asset('download.png') }}" alt="Gavel" class="absolute w-full h-full object-cover z-0 ">
        <div class="relative z-10 md:py-0 py-4 bg-black bg-opacity-50 h-full flex items-center">
            <div class="container mx-auto px-6">
                <h2 class="text-xl md:text-5xl text-white font-bold mb-2">Pelayanan Hukum Cepat Mudah dalam Genggaman</h2>
                <p class="text-white md:text-xl text-sm mb-5 md:mb-10">Mempermudah Pelayanan Hukum melalui Teknologi, Melayani Tanpa
                    Kendala Ruang dan Waktu.</p>
                <a href="{{ route('konsultasi.index') }}"
                    class="bg-[#EEB230] hover:bg-[#2d2f3140] text-white px-2 py-2 md:px-6 md:text-md text-sm md:py-4 font-semibold md:font-bold rounded">Pelayanan
                    Hukum</a>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 md:px-6 py-10 rounded-lg">
        <h3 class="md:text-4xl text-2xl w-full font-semibold text-green-800 mb-1 ">Selamat Datang di Website Datun Kejaksaan Negeri Pemalang
        </h3>
        <hr class="my-4 h-1 border " style="background: linear-gradient(to right, #eeb230 20%, #718096 20%)">

        <div class="flex md:flex-row col-span-1 md:col-span-4 flex-col-reverse gap-4 items-center md:items-start">
            <div class="flex flex-col justify-between h-full gap-5">
                <h4 class="text-3xl font-semibold text-green-800  md:block hidden">Kami menyambut Anda di portal digital
                    Seksi Perdata
                    dan Tata Usaha Negara (Datun) Kejaksaan Negeri Pemalang</h4>

                <div class="flex flex-col  justify-center items-center gap-4 text-md text-gray-500">
                    <p>Website ini hadir untuk memberikan layanan hukum secara tepat, transparan, dan mudah diakses bagi
                        masyarakat <br> Dengan dukungan teknologi, kami mempersembahkan pelayanan hukum online yang
                        memudahkan Anda untuk mendapatkan pelayanan hukum gratis dari mana saja</p>

                    <p>
                        Sebagai bagian dari Kejaksaan Negeri Pemalang, Seksi Datun berperan dalam memberikan layanan hukum
                        di bidang perdata dan tata usaha negara, mulai dari konsultasi hukum hingga bantuan dalam
                        penyelesaian sengketa. Kami bertekad untuk selalu memberikan pelayanan terbaik dan menjunjung tinggi
                        integritas serta profesionalisme dalam setiap pelayanan yang kami berikan.
                    </p>
                    <p>
                        Kami berkomitmen untuk memberikan layanan hukum yang terintegrasi dan transparan bagi masyarakat.
                        Kunjungi website ini secara berkala untuk mendapatkan informasi terbaru dan manfaatkan fitur-fitur
                        yang telah kami sediakan.
                    </p>

                </div>
            </div>
            <div class="flex flex-col gap-4 w-full md:w-2/3">
                <h4 class="text-xl md:hidden block font-semibold text-green-800 w-full">Kami menyambut Anda di portal
                    digital Seksi Perdata
                    dan Tata Usaha Negara (Datun) Kejaksaan Negeri Pemalang</h4>

                <img src="{{ asset('foto_berita/sample.png') }}" class="aspect-[4/3]" alt="">
                <img src="{{ asset('foto_berita/sample.png') }}" class="aspect-[4/3] hidden md:block" alt="">
            </div>
        </div>

        <div class="mt-10">

            @if ($data->isEmpty())
                <div class="flex justify-center items-center p-4">
                    <p class="text-gray-600 text-md">Data belum tersedia</p>
                </div>
            @else
                <div class="grid md:grid-cols-4 grid-cols-1 gap-4">
                    @foreach ($data as $berita)
                        <div class="grid grid-cols-1 rounded-lg ">
                            <img src="{{ asset('foto_berita/' . $berita->foto) }}"
                                class="aspect-[4/3] w-full object-cover rounded-lg" alt="">
                            <a href="{{ route('berita.detail', $berita->id) }}"
                                class="text-md md:text-xl font-semibold text-green-800">{{ $berita->judul }}</a>
                        </div>
                    @endforeach

                </div>
            @endif
        </div>

    </div>




@endsection

@section('js-library')
@endsection

@section('js-custom')
@endsection
