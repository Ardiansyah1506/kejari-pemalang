@extends('layout.app')

@section('css-custom')
    <style>
        .hero {
            height: 600px;
        }

        .text-vsm {
            font-size: 0.5rem;
        }
        thead{
    background-color: #f8f7f5 !important;
}

        @media screen and (max-width: 600px) {
            .hero {
                height: 200px;
            }
        }
    </style>
@endsection



@section('css-library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
@endsection


@section('content')
    <div class="container mx-auto px-6 py-10 rounded-lg">
        <h3 class="text-2xl font-semibold text-green-800 mb-1 ">Galeri</h3>
        <hr class="my-4 h-1 border " style="background: linear-gradient(to right, #eeb230 20%, #718096 20%)">
        @if (is_null($galeriFirst))
            <div class="flex justify-center items-center p-4">
                <p class="text-gray-600 text-md">Data belum tersedia</p>
            </div>
        @else
            <div class="grid md:grid-cols-4 grid-cols-2  gap-4 grid-row-2">
                <div class=" row-span-2 aspect-[4/3] col-span-2">
                    <img class="w-full h-full object-cover rounded-md" src="{{ asset('foto_galeri/' . $galeriFirst->foto) }}"
                        alt="Random image">
                </div>

                @if ($galeri->isNotEmpty())
                    @foreach ($galeri as $data)
                        @if ($loop->iteration < 4)
                            <div class="relative  col-span-1 row-span-1 ">
                                <img class="w-full h-full object-cover rounded-md"
                                    src="{{ asset('foto_galeri/' . $data->foto) }}" alt="Random image">
                            </div>
                        @else
                            <div class="relative  col-span-1 row-span-1 ">
                                <img class="w-full h-full object-cover rounded-md"
                                    src="{{ asset('foto_galeri/' . $data->foto) }}" alt="Random image">
                                <div
                                    class="absolute inset-0 rounded-md cursor-pointer   bg-gray-600 bg-opacity-50 flex items-center justify-center">
                                    <h2 class="text-white flex flex-col text-center gap-2  font-bold hover:scale-110">
                                        <a href="{{ route('galeri') }}"
                                            class="flex items-center justify-center  rounded-md">
                                            {{-- <img src="{{asset('right-arrow.png')}}" class="object-contain  w-24" alt=""> --}}
                                            {{-- <i class="fa-solid fa-chevron-right text-white p-2 rounded-full border py-2 "></i> --}}
                                            <i class="fa-regular fa-circle-right text-white text-5xl"></i>
                                        </a>
                                        <span class="text-xl font-mediun">Selengkapnya</span>
                                    </h2>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        @endif


        <h3 class="text-2xl font-semibold text-green-800 mb-1 mt-10 md:mt-20 ">BERITA</h3>
        <hr class="my-4 h-1 border " style="background: linear-gradient(to right, #eeb230 20%, #718096 20%)">

        @if ($berita->isEmpty())
            <div class="flex justify-center items-center p-4">
                <p class="text-gray-600 text-md">Data belum tersedia</p>
            </div>
        @else
            <div class="grid md:grid-cols-4 grid-cols-1 gap-6">
                @foreach ($berita as $data)
                    <div
                        class="flex md:flex-row col-span-1 md:col-span-4 flex-col-reverse gap-5 justify-center items-center p-4">
                        <div>
                            <a href="{{ route('berita.detail', $data->id) }}"
                                class="text-2xl font-semibold text-green-800 mb-2">{{ $data->judul }}</a>
                            <p class="text-gray-600  bg-red-500">{!! $data->deskripsi !!}</p>
                            <div class="flex justify-between text-sm items-center mt-5 text-gray-500">
                                <span class="mr-2 ">{{ $data->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <img src="{{ asset('foto_berita/' . $data->foto) }}" class="md:aspect-[4/3] md:w-1/4  "
                            alt="">
                    </div>
                @endforeach

            </div>
            <a href="{{ route('berita') }}" class="block text-[#006E61] text-center w-full p-2 border shadow-sm">
                Lihat Semua Berita
            </a>
        @endif

        <div class="container mx-auto mt-10 md:mt-20 rounded-lg">
            <h3 class="text-2xl font-semibold text-green-800 mb-1">Jadwal Sidang</h3>
            <hr class="my-4 h-1 border" style="background: linear-gradient(to right, #eeb230 20%, #718096 20%)">
        
            <!-- Wrap table with overflow-auto for responsive scrolling -->
            <div class="overflow-auto rounded-lg">
                <table id="beritaTable" class="min-w-full text-sm md:text-md mb-4">
                    <thead class="bg-gray-500">
                       
                    </thead>
                    <tbody class="md:text-md text-sm "></tbody>
                </table>
            </div>
        </div>
@endsection



@section('js-library')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
@endsection

@section('js-custom')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("{{ route('getData') }}")
                .then(response => response.json())
                .then(data => {
                    const tableData = data.data.map((item, index) => [
                        index + 1, 
                        item.perkara,
                        item.tanggal_sidang,
                        item.penggugat,
                        item.tergugat,
                        item.agenda,
                        item.keterangan
                    ]);

                    const table = document.querySelector("#beritaTable");
                    const dataTable = new simpleDatatables.DataTable(table, {
                        data: {
                            headings: ["No", "Perkara", "Tanggal Sidang", "Penggugat", "Tergugat",
                                "Agenda", "Keterangan"
                            ],
                            data: tableData
                        },
                        searchable: false,
                        fixedHeight: false,
                        sortable: false,
                        paging: true,
                        perPageSelect: false,
                        perPage: 10
                    });

                    // Menambahkan kelas border pada setiap sel setelah tabel diinisialisasi
                    dataTable.on('datatable.init', function() {
                        table.querySelectorAll('tr').forEach(row => {
                            row.querySelectorAll('td').forEach(cell => {
                                cell.style.border = "1px solid #ddd";
                                cell.style.padding = "8px";
                            });
                        });
                        table.querySelectorAll('thead th').forEach(header => {
                            header.style.border = "1px solid #ddd";
                            header.style.padding = "8px";
                        });
                    });
                })
                .catch(error => console.error("Error fetching data:", error));
        });
    </script>
@endsection
