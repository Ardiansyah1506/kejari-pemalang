<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kejaksaan Negeri Pemalang</title>
    @yield('css-custom')
    @yield('css-library')
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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

        function toggleModal() { document.getElementById('modal').classList.toggle('hidden')
}
        button.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
    </script>
</body>

</html>
