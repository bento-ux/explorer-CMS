<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/style.css">
    <style>
        /* Menjaga navbar tetap pada ukuran default */
        .navbar {
            padding: 0.5rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-bottom: 2px solid #ddd;
            position: relative;
            /* Untuk mengatur posisi absolute anak-anaknya */
        }

        /* Gambar logo */
        .navbar-brand img {
            height: 50px;
            transition: transform 0.3s ease;
        }

        /* Efek zoom saat hover pada logo */
        .navbar-brand:hover img {
            transform: scale(1.5);
        }

        /* Navbar links di tengah */
        .navbar-nav {
            position: absolute;
            left: 50%;
            /* Posisi di tengah horizontal */
            transform: translateX(-50%);
            /* Adjust agar benar-benar di tengah */
            display: flex;
            justify-content: center;
            gap: 1rem;
            /* Memberikan jarak antar item menu */
        }

        /* Menu link */
        .nav-link {
            text-align: center;
            color: #333;
            font-weight: bold;
        }

        .tx-mobile {
            display: none;
        }

        .tx-desktop {
            display: inline;
        }

        /* Responsive fix untuk mobile */
        @media (max-width: 768px) {
            .navbar-nav {
                position: static;
                transform: none;
                width: 100%;
            }

            .navbar-nav {
                flex-direction: column;
                align-items: center;
            }

            .tx-mobile {
                display: inline;
            }

            .tx-desktop {
                display: none;
            }
        }
    </style>

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Left section with two logos -->
            <a class="navbar-brand" href="#">
                <img src="/image/ibantu-explorer.png" alt="Logo 1">
            </a>
            <a class="navbar-brand" href="#">
                <img src="@yield('logo-navbar')"
                    alt="Logo 2">
            </a>

            <!-- Toggle button for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links in the center -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{url('/')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/token-umum')}}">Token Umum</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/token-program')}}">Token Program</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

   @yield('content')


    <!-- Bootstrap JS (including Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>

</body>

</html>