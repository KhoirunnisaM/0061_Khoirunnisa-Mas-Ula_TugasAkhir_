<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $this->renderSection('title') ?></title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>dist/css/adminlte.min.css">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/128/10469/10469224.png" type="image/x-icon">
</head>

<body class="hold-transition sidebar-mini">
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

    <div class="wrapper">
        <?= $this->include('Admin/layouts/navbar') ?>
        <?= $this->include('Admin/layouts/sidebar') ?>

        <div class="content-wrapper">
            <?= $this->renderSection('content') ?>
        </div>
        <!-- Footer -->
        <?= $this->include('Admin/layouts/footer') ?>
    </div>

    <!-- Tambahkan JS atau CDN di sini -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="<?= base_url(); ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>dist/js/adminlte.min.js"></script>
</body>

</html>