<?php
include 'controller/barangController.php';

$session = new session();
$barang = new barangController();

if ($session->check()==false) {
  $session->redirect('login.php');
}

if (isset($_GET['delete'])) {
  $result = $barang->deleteBarangById($_GET['delete']);
  if ($result==true) {
    $session->redirect('barang.php?delete');
  }
}

$data = $barang->getBarangById($_GET['id']);

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
                                      <a type="button" class="btn btn-primary mr-1" href="updBarang.php?id=<?php echo $data['id_barang'] ?>">Ubah</a>
                                    </div>
                                </div>
                              </div>

                                <div class="card-body">
                                  <?php if (isset($_GET['add'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">×</span>
                                    </button>
                                      Barang baru berhasil ditambahkan.
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
