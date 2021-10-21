<?php
include 'controller/session.php';
include 'controller/kasirController.php';
include 'controller/topupController.php';

$session = new session();
$kasir = new kasirController();
$topup = new topupController();

if ($session->check()==false) {
  $session->redirect('login.php');
}

if ($session->checkAdmin()==false) {
  $session->redirect('index.php');
}

if (isset($_GET['delete'])) {
  $result = $kasir->deleteKasirById($_GET['delete']);
  if ($result==true) {
    $session->redirect('listKasir.php?delete');
  }
}

$data = $kasir->getKasirById($_GET['id']);
$data1 = $topup->getTopupByKasir($_GET['id']);

?>

<?php include 'include/head.php' ?>

    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <!-- /# row -->
                <section id="main-content">
                        <!-- /# column -->
                            <div class="card col-lg-12">
                              <div class="row">
                                <div class="card-title mb-2">
                                    <h4>Detail Kasir </h4>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="card-title"><?php echo $data['nama_kasir'] ?></h4>
                                    <h6 class="card-subtitle"><?php echo $data['username'] ?></h6>
                                </div>
                                <div class="col-lg-6">
                                  <?php if ($_SESSION['username']!=$_GET['id'] && $_GET['id']!='admin'): ?>
                                    <div class="float-right">
                                      <a type="button" class="btn btn-danger mr-1" href="?delete=<?php echo $data['username'] ?>">Hapus</a>
                                    </div>
                                  <?php endif; ?>
                                    <div class="float-right">
                                      <a type="button" class="btn btn-primary mr-1" href="ubahKasir.php?id=<?php echo $data['username'] ?>">Ubah</a>
                                    </div>
                                </div>
                              </div>

                                <div class="card-body">
                                  <?php if (isset($_GET['update'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">×</span>
                                    </button>
                                      Data kasir berhasil diubah.
                                    </div>
                                  <?php endif; ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Pembeli</th>
                                                    <th>Jumlah Topup</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                              <?php foreach ($data1 as $key => $value): ?>
                                                <tr>
                                                    <td><?php echo $value['tanggal'] ?></td>
                                                    <td><?php echo $value['nama_pelanggan'] ?></td>
                                                    <td><?php echo $value['jumlah_topup'] ?></td>
                                                </tr>
                                              <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /# card -->
                        </div>
                        <!-- /# column -->
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
