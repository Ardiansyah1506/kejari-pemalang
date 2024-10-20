<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{ asset('logo-icon.png') }}">
    <title>Kejaksaan Negeri Pemalang</title>
    @yield('css-custom')
    @yield('css-library')

    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-white">
    <!-- Header -->
    @include('layout.navbar')
    <!-- Main Content -->
    <main>
        @yield('content')
        @include('modal')
    </main>

    @include('layout.footer')

    @yield('js-library')
    @yield('js-custom')
    <script>
        const button = document.querySelector("#menu-button");
        const menu = document.querySelector("#menu");

        function toggleModal() {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modal-content');

            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10); // Delay for the CSS transition to take effect
            } else {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300); // Durasi harus sama dengan durasi transisi CSS
            }
        }
        button.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
    </script>
</body>

</html>
