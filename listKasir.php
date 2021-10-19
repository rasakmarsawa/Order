<?php
include 'controller/session.php';
include 'controller/kasirController.php';

$session = new session();
$kasir = new kasirController();

if ($session->check()==false) {
  $session->redirect('login.php');
}

$arr = $kasir->getKasir();
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
                                <div class="card-title mb-2">
                                    <h4>List Kasir </h4>
                                    <div class="float-right">
                                        <a type="button" class="btn btn-primary" href="tambahKasir.php">Tambah</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                  <?php if (isset($_GET['add'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">×</span>
                                    </button>
                                      Kasir baru berhasil ditambahkan.
                                    </div>
                                  <?php endif; ?>
                                  <?php if (isset($_GET['delete'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">×</span>
                                    </button>
                                      Kasir berhasil dihapus.
                                    </div>
                                  <?php endif; ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Username</th>
                                                    <th>Nama Kasir</th>
                                                    <th>Role</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                              <?php
                                              $i=1;
                                              foreach ($arr as $key => $value): ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i ?></th>
                                                    <td><?php echo $value['username'] ?></td>
                                                    <td><?php echo $value['nama_kasir'] ?></td>
                                                    <td><?php if ($value['admin']==1): ?>
                                                        <span class="badge badge-primary">Admin</span>
                                                      <?php else: ?>
                                                        <span class="badge badge-success">Kasir</span>
                                                    <?php endif; ?></td>
                                                    <td><center><a type="button" class="btn btn-primary" href="detailKasir.php?id=<?php echo $value['username'] ?>">Detail</a></center></td>
                                                </tr>
                                              <?php $i++;
                                            endforeach; ?>
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
