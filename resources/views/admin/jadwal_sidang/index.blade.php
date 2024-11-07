@extends('layout.app2')



@section('css-library')
    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection


@section('content')
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

    <div class="text-gray-900 bg-white rounded shadow-md w-full">
        <div class="p-4 overflow-x-auto">
            <table class="w-full text-sm md:text-md mb-4" id="beritaTable">
                <thead>
                    <tr class="border-b">
                        <th class="text-left">Agenda</th>
                        <th class="text-left">Perkara</th>
                        <th class="text-left">Tanggal Sidang</th>
                        <th class="text-left">Keterangan</th>
                        <th class="text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="py-2"></tbody>
            </table>
        </div>
    </div>
    @include('admin.jadwal_sidang.modal')
@endsection

@section('js-library')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('vendor/quill/quill.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('js-custom')
    <script>
        function toggleModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        $(document).ready(function() {
            function clearInputan() {
                $('#form-berita').find('input[type="text"], input[type="date"], textarea').val(
                    ''); // Kosongkan semua inputan
            }

            $('#createNew').on('click', function() {
                clearInputan(); // Panggil fungsi untuk membersihkan inputan
                toggleModal('modal'); // Tampilkan modal
            });


            let table = $('#beritaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.sidang.getData') }}",
                columns: [{
                        data: 'agenda'
                    },
                    {
                        data: 'perkara'
                    },
                    {
                        data: 'tanggal_sidang'
                    },
                    {
                        data: 'keterangan'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                    }
                ],
                dom: 'lrtip',
                lengthChange:false,
                ordering:false,
                language: {
                    search: "",
                    searchPlaceholder: "Cari..."
                }
            });

            // Handler untuk tombol 'Show' (Detail Jadwal Sidang)
            $(document).on('click', '.btn-show', function() {
                const id = $(this).data('id');
                $('#modalTitle').text('Detail Jadwal Sidang'); // Ubah judul modal

                $.ajax({
                    url: "{{ route('admin.sidang.show', '') }}/" + id,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            // Set konten modal dengan data dari response
                            $('#modalContent').html(`
                        <div class="grid grid-cols-2 gap-y-2 text-md text-gray-800">
        <div class="font-semibold">Agenda:</div>
        <div>${response.data.agenda}</div>

        <div class="font-semibold">Perkara:</div>
        <div>${response.data.perkara}</div>

        <div class="font-semibold">Tanggal Sidang:</div>
        <div>${response.data.tanggal_sidang}</div>

        <div class="font-semibold">Penggugat:</div>
        <div>${response.data.penggugat}</div>

        <div class="font-semibold">Tergugat:</div>
        <div>${response.data.tergugat}</div>

        <div class="font-semibold">Keterangan:</div>
        <div>${response.data.keterangan}</div>
    </div>
                    `);
                            toggleModal('modalShow'); // Tampilkan modal
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Terjadi kesalahan: ' + xhr.responseText, 'error');
                    }
                });
            });


            // Handler untuk tombol 'Edit' (Edit Jadwal Sidang)
            $(document).on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                $('#modalTitle').text('Edit Jadwal Sidang');
                $('#btnSave').removeClass('hidden');

                $.ajax({
                    url: "{{ route('admin.sidang.edit', '') }}/" + id,
                    type: "GET",
                    success: function(response) {
                        if (response.success) {
                            $('input[name="id"]').val(response.data.id);
                            $('input[name="agenda"]').val(response.data.agenda);
                            $('input[name="perkara"]').val(response.data.perkara);
                            $('input[name="tanggal_sidang"]').val(response.data.tanggal_sidang);
                            $('input[name="penggugat"]').val(response.data.penggugat);
                            $('input[name="tergugat"]').val(response.data.tergugat);
                            $('textarea[name="keterangan"]').val(response.data.keterangan);
                            toggleModal('modal1');
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Terjadi kesalahan: ' + xhr.responseText, 'error');
                    }
                });
            });

            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                console.log('test')
                const id = $(this).data('id');
                console.log(id)
                if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                    $.ajax({
                        url: "{{ route('admin.sidang.destroy', '') }}/" + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.success,
                                confirmButtonText: 'OK'
                            });
                            $('#beritaTable').DataTable().ajax
                        .reload(); // Reload tabel setelah data dihapus
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Gagal Menghapus Data',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });

            // Handler untuk form edit
            $('#editForm').on('submit', function(event) {
                event.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('admin.sidang.update') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            toggleModal('modal1');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Terjadi kesalahan: ' + xhr.responseText, 'error');
                    }
                });
            });
        });
    </script>
@endsection
