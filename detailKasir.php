<?php
include 'controller/session.php';
include 'controller/kasirController.php';

$session = new session();
$kasir = new kasirController();

if ($session->check()==false) {
  $session->redirect('login.php');
}

if (isset($_GET['delete'])) {
  $result = $kasir->deleteKasirById($_GET['delete']);
  if ($result==true) {
    $session->redirect('listKasir.php?delete');
  }
}

$data = $kasir->getKasirById($_GET['id']);

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
                                                    <th>#</th>
                                                    <th>Nama Barang</th>
                                                    <th>Harga</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                              <!-- <?php
                                              $i=1;
                                              foreach ($arr as $key => $value): ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i ?></th>
                                                    <td><?php echo $value['nama_barang'] ?></td>
                                                    <td><?php echo $value['harga'] ?></td>
                                                    <td><center><a type="button" class="btn btn-primary" href="detailBarang.php?id=<?php echo $value['id_barang'] ?>">Detail</a></center></td>
                                                </tr>
                                              <?php $i++;
                                            endforeach; ?> -->
                                            </tbody>
                                        </table>
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
