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
    <div class="px-5" onclick="toggleModal()">
        <i class="fa-brands fa-whatsapp text-3xl md:text-2xl text-green-500"></i>
    </div>
</div>

<div class="text-gray-900 bg-white rounded shadow-md w-full">
    <div class="p-4 overflow-x-auto data-container">
        <table class="w-[100vw] md:w-full text-sm md:text-md mb-4 overflow-x-auto" id="beritaTable">
            <tbody>
                @if ($data->isEmpty())
                    <div class="flex justify-center items-center p-4">
                        <p class="text-gray-600 text-md">Data Masih Kosong</p>
                    </div>
                @else
                    @foreach ($data as $forum)
                        <tr class="border-b-2 p-2">
                            <td class="w-[15vw] md:w-auto">
                                <span
                                    class="{{ $forum->id_forum == null ? 'bg-blue-200' : 'bg-green-200' }} p-2 rounded-sm text-xs md:text-sm">
                                    {{ $forum->id_forum == null ? 'Baru' : 'Terjawab' }}
                                </span>
                            </td>
                            <td class="text-xs w-[30vw] md:w-auto md:text-sm">{{ $forum->nama }}</td>
                            <td class="text-xs w-[50vw] md:w-auto md:text-sm">{{ $forum->keterangan }}</td>
                            <td class="flex space-x-2 w-[10vw] md:w-auto">
                                <a href="{{ route('admin.konsultasi.detail', $forum->id) }}">
                                    <i
                                        class="fa-regular fa-eye p-2 md:p-3 md:text-md text-sm text-center inline-block bg-yellow-300 text-white rounded-sm"></i>
                                </a>
                                <button class="delete-btn" data-id="{{ $forum->id }}">
                                    <i
                                        class="fa-regular fa-trash-can p-2 md:p-3 md:text-md text-sm rounded-sm bg-red-300 text-white"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Tombol Pagination -->
        <div class="mt-4">
            {{ $data->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>

@include('admin.konsultasi.modal')

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
        const modal = document.getElementById('modal');
        modal.classList.toggle('hidden');
        checkWhatsAppStatus();
    }

    // Fetch WhatsApp status and update modal content
    async function checkWhatsAppStatus() {
        const statusDiv = document.getElementById('statusDiv');
        const qrCodeImg = document.getElementById('qrCodeImg');
        const logoutBtn = document.getElementById('logoutBtn');

        try {
            const response = await fetch('https://express-wa-api-production.up.railway.app/status');
            const result = await response.json();

            if (result.isLoggedIn) {
                statusDiv.textContent = 'WhatsApp is connected';
                logoutBtn.style.display = 'block';
                qrCodeImg.style.display = 'none';
            } else {
                statusDiv.textContent = 'WhatsApp is not connected';
                logoutBtn.style.display = 'none';
                connectWhatsApp();
            }
        } catch (error) {
            console.error('Error checking WhatsApp status:', error);
            statusDiv.textContent = 'Error checking WhatsApp status';
        }
    }

    // Initiate connection to WhatsApp and get QR code
    async function connectWhatsApp() {
        const statusDiv = document.getElementById('statusDiv');
        const qrCodeImg = document.getElementById('qrCodeImg');

        statusDiv.textContent = 'Connecting to WhatsApp...';

        try {
            await fetch('https://express-wa-api-production.up.railway.app/connect');
            startWebSocket();
        } catch (error) {
            console.error('Error connecting to WhatsApp:', error);
            statusDiv.textContent = 'Connection error';
        }
    }

    // Start WebSocket to receive QR code updates
    function startWebSocket() {
    const statusDiv = document.getElementById('statusDiv');
    const qrCodeImg = document.getElementById('qrCodeImg');
    const logoutBtn = document.getElementById('logoutBtn');

    const ws = new WebSocket('wss://express-wa-api-production.up.railway.app');
    
    // Handle message received from WebSocket
    ws.onmessage = (event) => {
        try {
            const data = JSON.parse(event.data);
            console.log('Data received:', data); // Debug log

            // Display QR Code if available
            if (data.qrCode) {
                qrCodeImg.src = data.qrCode;
                qrCodeImg.style.display = 'block';
                statusDiv.textContent = 'Scan QR Code to connect your WhatsApp...';
            }

            // Update status
            if (data.status) {
                statusDiv.textContent = data.status;

                if (data.status === 'WhatsApp connected') {
                    // Show success alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Connected!',
                        text: 'WhatsApp has successfully connected.',
                        confirmButtonText: 'OK'
                    });

                    // Show logout button and hide QR code after connection
                    logoutBtn.style.display = 'block';
                    qrCodeImg.style.display = 'none'; // Hide QR after login
                }
            }
        } catch (e) {
            console.error('Error parsing WebSocket message', e);
        }
    };

    // Optional: Handle WebSocket close and error
    ws.onclose = () => console.log('WebSocket closed');
    ws.onerror = (error) => console.error('WebSocket error:', error);
}

logoutBtn.addEventListener('click', async () => {
         const response = await fetch('https://express-wa-api-production.up.railway.app/logout', {
            method: 'POST',
         });

         const result = await response.json();
         Swal.fire({
                        icon: 'success',
                        title: 'Connected!',
                        text: result.message,
                        confirmButtonText: 'OK'
                    });
         // Reset UI setelah logout
            window.reload()
      });


    $(document).ready(function () {



        $('#searchInput').on('keyup', function () {
            let query = $(this).val();

            $.ajax({
                url: "{{ route('admin.konsultasi.search') }}",
                type: "GET",
                data: {
                    search: query
                },
                success: function (response) {
                    let tbody = $('#beritaTable tbody'); // Target the table body
                    tbody.empty(); // Clear existing rows

                    response.data.forEach(function (forum) {
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
                error: function (xhr) {
                    console.error('Gagal melakukan pencarian');
                }
            });
        });
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            const id = $(this).data('id'); // Get the ID from the button
            var token = $('meta[name="csrf-token"]').attr('content');

            if (confirm("Apakah Anda yakin ingin menghapus berita ini?")) {
                $.ajax({
                    url: "{{ route('admin.konsultasi.destroy', '') }}/" +
                        id, // Ensure this URL is correct
                    type: 'DELETE',
                    data: {
                        "_token": token,
                    },
                    success: function (response) {
                        // Reload the page or remove the row from the table
                        $(e.target).closest('tr')
                            .remove(); // Remove the row of the deleted item
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.success,
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        alert('Gagal menghapus data');
                    }
                });
            }
        });


    });
</script>
@endsection