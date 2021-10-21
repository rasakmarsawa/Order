<?php
include 'controller/session.php';
include 'controller/barangController.php';

$session = new session();
$barang = new barangController();

if ($session->check()==false) {
  $session->redirect('login.php');
}

if ($session->checkAdmin()==false) {
  $session->redirect('index.php');
}

if (isset($_GET['delete'])) {
  $result = $barang->deleteBarangById($_GET['delete']);
  if ($result==true) {
    $session->redirect('listBarang.php?delete');
  }
}

$data = $barang->getBarangById($_GET['id']);
$detail = $barang->getDetailBarang($_GET['id']);
?>

<?php include 'include/head.php' ?>

    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <!-- /# row -->
                <section id="main-content">
                    <div class="row">
                        <!-- /# column -->
                            <div class="card col-lg-12">
                              <div class="row">
                                <div class="card-title mb-2">
                                    <h4>Detail Barang </h4>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="card-title"><?php echo $data['nama_barang'] ?></h4>
                                    <h6 class="card-subtitle"><?php echo "Rp.".$data['harga'] ?></h6>
                                </div>
                                <div class="col-lg-6">
                                    <div class="float-right">
                                      <a type="button" class="btn btn-danger mr-1" href="?delete=<?php echo $data['id_barang'] ?>">Hapus</a>
                                    </div>
                                    <div class="float-right">
                                      <a type="button" class="btn btn-primary mr-1" href="ubahBarang.php?id=<?php echo $data['id_barang'] ?>">Ubah</a>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="card-title mb-2">
                                    <h4>Penjualan Barang</h4>
                                </div>
                              </div>
                                <div class="card-body">
                                  <?php if (isset($_GET['update'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">×</span>
                                    </button>
                                      Barang berhasil diubah.
                                    </div>
                                  <?php endif; ?>
                                    <div class="bootstrap-data-table-panel">
                                        <div class="table-responsive">
                                            <table id="row-select" class="display table table-borderd table-hover">
                                              <thead>
                                                  <tr>
                                                      <th>Tanggal</th>
                                                      <th>Pembeli</th>
                                                      <th>Jumlah</th>
                                                  </tr>
                                              </thead>
                                              <tbody>

                                                <?php foreach ($detail as $key => $value): ?>
                                                  <tr>
                                                      <td><?php echo $value['tanggal'] ?></td>
                                                      <td><?php echo $value['nama_pelanggan'] ?></td>
                                                      <td><?php echo $value['jumlah_barang'] ?></td>
                                                  </tr>
                                                <?php endforeach; ?>
                                              </tbody>
                                              <tfoot>
                                                <tr>
                                                  <th>Tanggal</th>
                                                  <th>Pembeli</th>
                                                </tr>
                                              </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /# card -->
                        </div>
                        <!-- /# column -->
                    </div>
                    <!-- /# row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="footer">
                                <p>2021 © X9090</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

<?php include 'include/foot.php' ?>
