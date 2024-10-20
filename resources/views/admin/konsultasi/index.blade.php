@extends('layout.app2')

@section('css-library')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .bg-custom-green {
            background: #228d81;
        }

        table,
        tr {
            border-top: none;
        }
    </style>
@endsection

@section('content')
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4 hidden" id="successMessage">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex md:flex-row flex-col-reverse gap-4 justify-between items-end mb-4">
        <div class="relative w-full md:w-1/2">
            <input id="searchInput" name="search"
                class="text-sm w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500"
                type="search" placeholder="Masukkan Kata Kunci Pencarian">
            <button type="submit"
                class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-700 bg-gray-100 border border-gray-300 rounded-r-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M14.795 13.408l5.204 5.204a1 1 0 01-1.414 1.414l-5.204-5.204a7.5 7.5 0 111.414-1.414zM8.5 14A5.5 5.5 0 103 8.5 5.506 5.506 0 008.5 14z" />
                </svg>
            </button>
        </div>
    </div>

    <div class="text-gray-900 bg-white rounded shadow-md w-full">
        <div class="p-4 overflow-x-auto data-container">
            <table class="w-full text-sm md:text-md mb-4" id="beritaTable">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $forum)
                        <tr>
                            <td>
                                <span
                                    class="{{ $forum->id_forum == null ? 'bg-blue-200' : 'bg-green-200' }} p-2 rounded-sm">
                                    {{ $forum->id_forum == null ? 'Baru' : 'Terjawab' }}
                                </span>
                            </td>
                            <td>{{ $forum->nama }}</td>
                            <td>{{ $forum->keterangan }}</td>
                            <td class="flex">
                                <a href="{{ route('admin.konsultasi.detail', $forum->id) }}"><i
                                        class="fa-regular fa-eye p-3 rounded-sm bg-yellow-300 text-white p-2 md:p-3 md:text-md text-sm text-center inline-block"></i></a>
                                <button class="delete-btn" data-id="{{ $forum->id }}"><i
                                        class="fa-regular fa-trash-can p-2 md:p-3 md:text-md text-sm rounded-sm bg-red-300"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Tombol Pagination -->
            <div class="mt-4">
                {{ $data->links('vendor.pagination.tailwind') }}

            </div>
        </div>
    </div>
@endsection

@section('js-library')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('vendor/quill/quill.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('js-custom')
    <script>
        $(document).ready(function() {

            $('#searchInput').on('keyup', function() {
                let query = $(this).val();

                $.ajax({
                    url: "{{ route('admin.konsultasi.search') }}",
                    type: "GET",
                    data: {
                        search: query
                    },
                    success: function(response) {
                        let tbody = $('#beritaTable tbody'); // Target the table body
                        tbody.empty(); // Clear existing rows

                        response.data.forEach(function(forum) {
                            let status = forum.id_forum == null ? 'Baru' : 'Terjawab';
                            let statusClass = forum.id_forum == null ? 'bg-blue-200' :
                                'bg-green-200';

                            let row = `
                                <tr>
                                    <td><span class="${statusClass} p-2 rounded-sm">${status}</span></td>
                                    <td>${forum.nama}</td>
                                    <td>${forum.keterangan}</td>
                                    <td class="flex">
                                <a href="{{ route('admin.konsultasi.detail', $forum->id) }}"><i
                                        class="fa-regular fa-eye p-3 rounded-sm bg-yellow-300 text-white p-2 md:p-3 md:text-md text-sm text-center inline-block"></i></a>
                                <button class="delete-btn "
                                    data-id="{{ $forum->id }}"><i class="fa-regular fa-trash-can p-2 md:p-3 md:text-md text-sm rounded-sm bg-red-300"></i></button>
                            </td>
                                </tr>`;
                            tbody.append(row); // Append new row
                        });
                        $('.pagination').html(response.data.links);
                        $('.pagination a').addClass(
                            'bg-gray-200 text-white px-3 py-1 rounded-md mx-1');

                    },
                    error: function(xhr) {
                        console.error('Gagal melakukan pencarian');
                    }
                });
            });
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                const id = $(this).data('id'); // Get the ID from the button
                var token = $('meta[name="csrf-token"]').attr('content');

                if (confirm("Apakah Anda yakin ingin menghapus berita ini?")) {
                    $.ajax({
                        url: "{{ route('admin.konsultasi.destroy', '') }}/" +  id, // Ensure this URL is correct
                        type: 'DELETE',
                        data: {
                            "_token": token,
                        },
                        success: function(response) {
                            // Reload the page or remove the row from the table
                            location.reload(); // Reloads the page after deletion
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.success,
                                confirmButtonText: 'OK'
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            alert('Gagal menghapus data');
                        }
                    });
                }
            });


        });
    </script>
@endsection
