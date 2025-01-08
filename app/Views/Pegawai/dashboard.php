<?= $this->extend('Pegawai/layouts/main') ?>
<?= $this->section('title') ?>
PANEL Pegawai
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
    </div>
  </div>
</section>

<section class="content">

  <div class="card bg-info">
    <div class="card-header">
      <h3 class="card-title">Title</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
    <div class="card-body">
      <h2><i class="icon fas fa-info-circle"></i> Selamat Datang di <b>Aplikasi Persediaan Barang Toko Mebel Sidarta</b></h2>
      Saat ini Anda login sebagai <b>Pegawai</b>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?= $totalSupplier; ?></h3>
          <p>Supplier</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="<?= site_url('Pegawai/supplier'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?= $totalBarang; ?></h3>
          <p>Barang</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="<?= site_url('Pegawai/barang'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3><?= $totalStokBarang; ?></h3>
          <p>Total Stok Barang</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <div class="small-box-footer"> </div>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3><?= $totalBarangTerjual; ?></h3>
          <p>Total Barang Terjual</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <div class="small-box-footer"> </div>
      </div>
    </div>
  </div>

</section>
<?= $this->endSection() ?>
