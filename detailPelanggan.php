<?php
include 'controller/session.php';
include 'controller/pelangganController.php';
include 'controller/topupController.php';

$session = new session();
$pelanggan = new pelangganController();
$topup = new topupController();

if ($session->check()==false) {
  $session->redirect('login.php');
}

if (isset($_POST['submit'])) {
  if ($session->emptyCheck($_POST,array('submit'))) {
    if ($_POST['jumlah_topup']>0) {
      $_POST['id_pelanggan']=$_GET['id'];
      $_POST['id_kasir']=$_SESSION['username'];
      $result = $topup->addTopup($_POST);

      if ($result) {
        $session->redirect('detailPelanggan.php?id='.$_GET['id'].'&&topup');
      }else{
        $session->redirect('detailPelanggan.php?id='.$_GET['id'].'&&fail');
      }
    }else{
      $session->redirect('detailPelanggan.php?id='.$_GET['id'].'&&fail');
    }
  }else{
    $session->redirect('detailPelanggan.php?id='.$_GET['id'].'&&empty');
  }
}

$data = $pelanggan->getPelangganById($_GET['id']);
if (empty($data)) {
  $session->redirect('topup.php?notfound');
}
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
                                    <h4>Detail Pelanggan </h4>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="card-title"><?php echo $data['nama_pelanggan'] ?></h4>
                                    <h6 class="card-subtitle"><?php echo $data['username'] ?>/ Rp. <?php echo $data['saldo']; ?></h6>
                                </div>
                                <div class="col-lg-6">
                                  <form class="basic-farm float-right" method="post">
                                    <div class="form-group">
                                        <label>Topup</label>
                                        <input name="jumlah_topup" class="form-control" placeholder="Jumlah Topup">
                                    </div>
                                    <button name="submit" type="submit" class="btn btn-default">Submit</button>
                                  </form>
                                </div>
                              </div>

                                <div class="card-body">
                                  <?php if (isset($_GET['topup'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">×</span>
                                    </button>
                                      Saldo pelanggan berhasil ditambahkan.
                                    </div>
                                  <?php endif; ?>
                                  <?php if (isset($_GET['fail'])): ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">×</span>
                                    </button>
                                      Gagal melakukan topup. Harap isi jumlah dengan benar.
                                    </div>
                                  <?php endif; ?>
                                  <?php if (isset($_GET['empty'])): ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">×</span>
                                    </button>
                                      Gagal melakukan topup. Jumlah topup tidak boleh dikosongkan.
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
