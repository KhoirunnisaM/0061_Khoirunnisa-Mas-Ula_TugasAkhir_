<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item bg-warning">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i style="color: #fff;" class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Fullscreen Button -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <!-- User Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="https://cdn-icons-png.flaticon.com/128/64/64572.png" alt="User Avatar" class="img-circle" style="width: 30px; height: 30px;">
                <span class="ml-2 text-capitalize"><?= session('username') ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="#" class="dropdown-item" id="logout-btn">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </div>

            <script>
                document.getElementById('logout-btn').addEventListener('click', function(e) {
                    e.preventDefault(); // Mencegah redirect langsung
                    Swal.fire({
                        title: 'Konfirmasi Logout',
                        text: 'Apakah Anda yakin ingin keluar?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Keluar',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect ke route logout
                            window.location.href = '/logout';
                        }
                    });
                });
            </script>
        </li>
    </ul>
</nav>
<!-- /.navbar -->