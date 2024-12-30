<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Persediaan Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #2c3e50;
            color: white;
        }

        .login-card {
            background-color: #34495e;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .login-card .form-control {
            background-color: #2c3e50;
            border: 1px solid #7f8c8d;
            color: white;
        }

        .btn-purple {
            background-color: #8e44ad;
            color: white;
        }

        .btn-purple:hover {
            background-color: #732d91;
        }

        .icon-circle {
            width: 100px;
            height: 100px;
            background-color: #8e44ad;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
        }

        .icon-circle i {
            font-size: 40px;
        }
    </style>
</head>

<body>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // SweetAlert for Success
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?= session()->getFlashdata('success') ?>',
            });
        <?php endif; ?>

        // SweetAlert for Error
        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?= session()->getFlashdata('error') ?>',
            });
        <?php endif; ?>
    </script>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="text-center">
            <!-- Icon -->
            <div class="icon-circle">
                <i class="bi bi-cash-register"></i>
                <img src="https://cdn-icons-png.flaticon.com/128/10469/10469224.png" alt="logo">
            </div>
            <!-- Title -->
            <h1 class="h4">APLIKASI PERSEDIAAN BARANG</h1>
            <h2 class="h6 mb-4">Toko Mebel Sidarta</h2>
            <!-- Login Form -->
            <div class="login-card">

                <form action="<?= site_url('/login') ?>" method="POST" autocomplete="off">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="username" class="form-label"><i class="bi bi-person"></i> Username</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"><i class="bi bi-lock"></i> Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-purple w-100">Sign In <i class="bi bi-box-arrow-in-right"></i></button>
                </form>
            </div>
            <!-- Footer -->
            <div class="mt-4">
                <p class="mb-0">&copy; 2024 Khoirunnisa' Mas'Ula 23.230.0061</p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>

</html>