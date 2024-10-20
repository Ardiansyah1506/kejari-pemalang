<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Kejari Pemalang</title>
    <meta name="author" content="Fauzi Ardiansyah">
    <meta name="description" content="Manajemen Admin Kejari">
    <link rel="icon" href="{{ asset('logo-icon.png') }}">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: karla;
        }

        .bg-sidebar {
            background: white;
        }

        .cta-btn {
            color: #3d68ff;
        }

        .upgrade-btn {
            background: #1947ee;
        }

        .upgrade-btn:hover {
            background: #0038fd;
        }

        .active-nav-link {
            background: #EEB230;
            color: white;
            border-radius: 10px;
        }

        .nav-item:hover {
            background: #EEB230;
            color: white;
            border-radius: 10px;
        }
    </style>
    @yield('css-library')
</head>

<body class="bg-gray-100 font-family-karla flex ">

    @include('layout.sidebar_admin')
    <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
        <main class="w-full p-4">
            @yield('content')
        </main>

    </div>


    @yield('js-library')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
        integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    @yield('js-custom')
    <script>
        $(document).ready(function() {
            const currentUrl = window.location.href;
            const url = new URL(currentUrl);

            // Hapus parameter ?page dan parameter lainnya
            url.searchParams.delete('page'); // Hapus parameter 'page'

            // Ambil URL tanpa parameter
            const baseUrl = url.origin + url.pathname;

            // Loop melalui semua tautan navigasi
            document.querySelectorAll('.nav-item').forEach(link => {
                // Cek apakah href link sesuai dengan URL tanpa parameter
                const linkUrl = new URL(link.href);
                linkUrl.searchParams.delete('page'); // Hapus parameter 'page' dari tautan juga
                const linkBaseUrl = linkUrl.origin + linkUrl.pathname;

                if (linkBaseUrl === baseUrl) {
                    // Tambahkan kelas aktif pada link yang sesuai
                    link.classList.add('active-nav-link');
                } else {
                    // Hapus kelas aktif dari tautan yang tidak sesuai
                    link.classList.remove('active-nav-link');
                }
            });

            function logoutButton(){
                console.log(test)
            }
            
            $('#logoutButton').on('click', function(e) {
                console.log(pppp)
                e.preventDefault();

                $.ajax({
                    url: "{{ route('logout') }}", // URL endpoint logout
                    type: "GET",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Tampilkan pesan atau lakukan pengalihan halaman jika diperlukan
                        alert("Anda berhasil logout.");
                    },
                    error: function(xhr) {
                        alert("Gagal logout, silakan coba lagi.");
                    }
                });
            });
        });
    </script>

</body>

</html>
