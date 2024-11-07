@extends('layout.app2')

@section('css-library')
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
        <div class="bg-green-500 text-white p-4 rounded mb-4 hidden" id="successMessage">
            {{ session('success') }}
        </div>
    @endif
    <div class="flex flex-row  gap-4 justify-between items-end mb-4">
        <div class="relative md:w-1/2">
            <input id="searchInput"
                class="text-sm w-full py-2 px-4 border border-gray-300 placeholder:text-xs placeholder:md:text-base placeholder:p-0 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500"
                type="search" placeholder="Masukkan Kata Kunci Pencarian">
            <button
                class="absolute inset-y-0 right-0 flex items-center px-2 md:px-4 text-gray-700 bg-gray-100 border border-gray-300 rounded-r-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <svg class="w-3 h-3 md:h-5 md:w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M14.795 13.408l5.204 5.204a1 1 0 01-1.414 1.414l-5.204-5.204a7.5 7.5 0 111.414-1.414zM8.5 14A5.5 5.5 0 103 8.5 5.506 5.506 0 008.5 14z" />
                </svg>
            </button>
        </div>
        <button id="createNew" class="bg-[#228d81] text-white md:px-4 md:py-2 px-2 py-1 text-sm md:text-md rounded hover:cursor-pointer">Tambah</button>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($galeri as $galery)
            <div class="h-full flex w-full justify-center items-center  p-2">
                <div class="relative bg-white border rounded-lg shadow-md transform transition duration-500 hover:scale-105">
                    <img class="rounded-t-lg w-full aspect-[4/3] object-contain"
                        src="{{ asset('foto_galeri/' . $galery->foto) }}" loading="lazy">
                    <div class="px-4 pb-3 py-2">
                        <div>
                            <p class="antialiased text-gray-600 dark:text-gray-400 text-sm break-all">
                                {{ $galery->judul }}
                            </p>
                        </div>
                    </div>
                    <div class="flex justify-end p-3 rounded-md">
                        <div class="flex border border-gray-200 justify-end rounded-md">
                            <i class="fa-regular fa-pen-to-square text-gray-600 text-md md:text-md py-2 px-2 md:px-4 edit-btn"
                                data-id={{ $galery->id }}></i>
                            <div class="border border-1 border-gray-200 "></div>
                            <i class="fa-solid fa-trash-can text-red-600 text-md md:text-md py-2 px-2 md:px-4 btn-delete"
                                data-id={{ $galery->id }}></i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @include('admin.galeri.modal')
@endsection

@section('js-library')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('vendor/quill/quill.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('js-custom')
    <script>
        // Define toggleModal outside the jQuery ready function
        function toggleModal() {
            console.log("Toggle modal called");
            var modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
            console.log("Modal hidden state:", modal.classList.contains('hidden')); // Debugging
        }

        $(document).ready(function() {

            // Saat tombol tambah berita ditekan
            $('#createNew').click(function() {
                $('#modal-title').text('Tambah Galeri');
                $('#id').val(''); // Kosongkan ID
                $('#form-galeri').attr('action', "{{ route('admin.galeri.store') }}"); // Set action ke store
                toggleModal();
            });

            if ($('#successMessage').length) {
                const message = $('#successMessage').text().trim();
                if (message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: message,
                        confirmButtonText: 'OK'
                    });
                }
            }

            // Event listener untuk tombol edit
            $(document).on('click', '.edit-btn', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                $('#modal-title').text('Edit Galeri');
                $('#modal').removeClass('hidden');
                $('#form-galeri').attr('action', "{{ route('admin.galeri.update') }}"); // Set action ke update

                // AJAX untuk mengambil data
                $.ajax({
                    url: "{{ route('admin.galeri.edit', '') }}/" + id,
                    type: "GET",
                    success: function(data) {
                        console.log(data); // Tambahkan ini untuk debug
                        $('#id').val(data.id);
                        $('input[name="judul"]').val(data.judul);
                        if (data.foto) {
                            // Jika ada foto, buat elemen link
                            let fotoUrl = `{{ asset('foto_galeri/${data.foto}') }}`;
                            $('#link').html(
                                `<a href="${fotoUrl}" class="bg-blue-100 w-full text-blue-600 py-1 p-2 rounded-sm" target="_blank">Link Gambar</a>`
                            );
                            console.log($('#link').html());
                        } else {
                            console.log("Tidak ada gambar."); // Tambahkan ini
                            // Jika tidak ada foto, tampilkan teks
                            $('#link').text('Tidak ada gambar');
                        }
                    },
                    error: function() {
                        alert("Gagal mengambil data berita.");
                    }
                });
            });

            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                console.log(id)
                if (confirm("Apakah Anda yakin ingin menghapus berita ini?")) {
                    $.ajax({
                        url: "{{ route('admin.galeri.destroy', '') }}/" + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            location.reload()
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.success,
                                confirmButtonText: 'OK'
                            });
                        },
                        error: function(xhr) {
                            alert('Gagal menghapus data');
                        }
                    });
                }
            });

            $('#searchInput').on('keyup', function() {
                let query = $(this).val();

                $.ajax({
                    url: "{{ route('admin.galeri.search') }}",
                    type: "GET",
                    data: {
                        search: query
                    },
                    success: function(response) {
                        let galleryContainer = $('.grid'); // Container untuk galeri
                        galleryContainer.empty(); // Kosongkan kontainer galeri

                        response.forEach(function(galery) {
                            let galeryHtml = `
                                <div class="h-full flex w-full justify-center items-center p-2">
                                    <div class="relative bg-white border rounded-lg shadow-md transform transition duration-500 hover:scale-105">
                                        <div class="flex justify-center">
                                            <a href="#">
                                                <img class="rounded-t-lg w-full aspect-[4/3]" src="{{ asset('foto_galeri/') }}/${galery.foto}" loading="lazy">
                                            </a>
                                        </div>
                                        <div class="px-4 pb-3 py-2">
                                            <p class="antialiased text-gray-600 dark:text-gray-400 text-sm break-all">
                                                ${galery.judul}
                                            </p>
                                        </div>
                                        <div class="flex justify-end p-3 rounded-md">
                                            <div class="flex border border-gray-200 justify-end rounded-md">
                                                <i class="fa-regular fa-pen-to-square text-gray-600 text-md md:text-md py-2 px-2 md:px-4 edit-btn" data-id="${galery.id}"></i>
                                                <div class="border border-1 border-gray-200"></div>
                                                <i class="fa-solid fa-trash-can text-red-600 text-md md:text-md py-2 px-2 md:px-4 btn-delete" data-id="${galery.id}"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                            galleryContainer.append(galeryHtml); // Tambahkan elemen galeri
                        });
                    }
                });
            });
        });
    </script>
@endsection
