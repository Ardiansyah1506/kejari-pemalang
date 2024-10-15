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
        <div class="bg-green-500 text-white p-4 rounded mb-4">
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
        <button id="createNew"
            class="bg-[#228d81] hover:bg-[#66d6c9] text-white px-4 py-2 rounded hover:cursor-pointer">Tambah</button>
    </div>


    <!-- component -->
    <div class="text-gray-900 bg-white rounded shadow-md w-full">
        <div class="p-4 overflow-x-auto">
            <table class="w-full text-sm md:text-md mb-4" id="beritaTable">
                <thead>
                    <tr class="border-b">
                        <th class="text-left ">Judul</th>
                        <th class="text-left p-3 px-5">Isi Berita</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>

            </table>

        </div>
    </div>
    @include('admin.berita.modal')
@endsection

@section('js-library')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('vendor/quill/quill.js') }}"></script>
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

            // Fungsi untuk menangani submit
            document.querySelector('#form-berita').onsubmit = function() {
                var descriptionInput = document.querySelector('#deskripsi');
                descriptionInput.value = quill.root.innerHTML;
            };

            // Saat tombol tambah berita ditekan
            $('#createNew').click(function() {
                $('#modal-title').text('Tambah Berita');
                $('#berita_id').val(''); // Kosongkan ID
                quill.setText(''); // Kosongkan editor
                $('#form-berita').attr('action',
                    "{{ route('admin.berita.store') }}"); // Set action ke store
                toggleModal();
            });

            // Event listener untuk tombol edit
            $(document).on('click', '.edit-btn', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                $('#modal-title').text('Edit Berita');
                $('#modal').removeClass('hidden');
                $('#form-berita').attr('action',
                    "{{ route('admin.berita.update') }}"); // Set action ke update

                // AJAX untuk mengambil data
                $.ajax({
                    url: "{{ route('admin.berita.edit', '') }}/" + id,
                    type: "GET",
                    success: function(data) {
                        console.log(data); // Tambahkan ini untuk debug
                        $('#berita_id').val(data.id);
                        $('input[name="judul"]').val(data.judul);
                        quill.root.innerHTML = data.deskripsi;
                        if (data.foto) {
                            // Jika ada foto, buat elemen link
                            let fotoUrl = `{{ asset('') }}${data.foto}`;
                            $('#link').html(
                                `<a href="${fotoUrl}" class="bg-blue-500 w-20 p-3" target="_blank" class="text-blue-500">Lihat Gambar</a>`
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
                console.log('test')
                const id = $(this).data('id');
                console.log(id)
                if (confirm("Apakah Anda yakin ingin menghapus berita ini?")) {
                    $.ajax({
                        url: "{{ route('admin.berita.destroy', '') }}/" + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert(response.success);
                            $('#beritaTable').DataTable().ajax
                        .reload(); // Reload tabel setelah data dihapus
                        },
                        error: function(xhr) {
                            alert('Gagal menghapus data');
                        }
                    });
                }
            });
          

            let table = $('#beritaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.berita.getData') }}",
                lengthChange: false, // Menyembunyikan dropdown "Show entries"
                columns: [{
                        data: 'judul'
                    },
                    {
                        data: 'deskripsi',
                        render: function(data, type, row, meta) {
                            let node = $.parseHTML('<span>' + data + '</span>')[0];
                            return node.innerText;
                        }
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

          
        });
    </script>
@endsection
