@extends('layout.app2')

@section('css-library')
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <div class="flex md:flex-row flex-col-reverse gap-4 justify-between items-end mb-4 ">
        <div class="relative w-full md:w-1/2">
            <input id="searchInput"
                class="text-sm w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500"
                type="search" placeholder="Masukkan Kata Kunci Pencarian">
            <button
                class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-700 bg-gray-100 border border-gray-300 rounded-r-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M14.795 13.408l5.204 5.204a1 1 0 01-1.414 1.414l-5.204-5.204a7.5 7.5 0 111.414-1.414zM8.5 14A5.5 5.5 0 103 8.5 5.506 5.506 0 008.5 14z" />
                </svg>
            </button>
        </div>
        <button id="createNew" class="bg-[#228d81] text-white px-4 py-2 rounded hover:cursor-pointer"
            onclick="toggleModal()">Tambah</button>
    </div>


    <!-- component -->
    <div class="text-gray-900 bg-white rounded shadow-md w-full">
        <div class="p-4 overflow-x-auto">
            <table class="w-full text-sm md:text-md mb-4" id="beritaTable">
                <thead>
                    <tr class="border-b">
                        <th class="text-left ">Username</th>
                        <th class="text-left p-3 px-5">Terakhir Online</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>

            </table>

        </div>
        @include('admin.user.modal')
    </div>
@endsection

@section('js-library')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('js-custom')
    <script>
        // Define toggleModal outside the jQuery ready function
        function toggleModal() {
            var modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
        }

        function timeAgo(date) {
            const now = new Date();
            const past = new Date(date);
            const diffInSeconds = Math.floor((now - past) / 1000); // Selisih waktu dalam detik
            const diffInMinutes = Math.floor(diffInSeconds / 60);
            const diffInHours = Math.floor(diffInMinutes / 60);
            const diffInDays = Math.floor(diffInHours / 24);

            if (diffInMinutes < 60) {
                return `${diffInMinutes} menit yang lalu`;
            } else if (diffInHours < 24) {
                return `${diffInHours} jam yang lalu`;
            } else if (diffInDays === 1) {
                return `Kemarin`;
            } else if (diffInDays < 7) {
                return `${diffInDays} hari yang lalu`;
            } else {
                // Jika lebih dari seminggu, tampilkan tanggal dalam format yang diinginkan (misalnya: DD-MM-YYYY)
                return past.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            }
        }


        $(document).ready(function() {
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
            let table = $('#beritaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.user.getData') }}",
                lengthChange: false, // Menyembunyikan dropdown "Show entries"
                columns: [{
                        data: 'username'
                    },

                    {
                        data: 'status',
                        render: function(data, type, row) {
                            // Menggunakan eval untuk mengeksekusi HTML dari data status
                            return row.is_online == 1 ? 
    '<span class="bg-green-400 p-2">Online</span>' :
    (row.last_login ? 
        '<span class="text-gray-600 p-2">' + timeAgo(row.last_login) + '</span>' : 
        '<span class="text-gray-600 text-xl font-bold p-2">-</span>');

                        },
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: 'lrtip', // Hilangkan pencarian bawaan
                language: {
                    search: "", // Kosongkan label pencarian bawaan
                    searchPlaceholder: "Cari...",
                }
            });

            // Sinkronkan pencarian dengan input pencarian kustom
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });
            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var token = $('meta[name="csrf-token"]').attr('content');

                if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                    $.ajax({
                        url: "{{ route('admin.user.destroy', '') }}/" + id,
                        type: 'DELETE',
                        data: {
                            "_token": token,
                        },
                        success: function(response) {
                            Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                            table.ajax.reload(); // Refresh DataTable setelah penghapusan
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan: ' + xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
@endsection
