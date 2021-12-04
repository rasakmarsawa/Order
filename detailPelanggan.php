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

if ($session->checkAdmin()==true) {
  $session->redirect('index.php');
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

$activity = $pelanggan->getActivity($_GET['id']);
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
                              <div class="card-title">
                                  <h4>Detail Pelanggan </h4>
                                  <hr>
                              </div>
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
                              <div class="card-subtitle">
                                <div class="row">
                                  <div class="col-lg-6">
                                    <p>
                                      Nama Pelanggan : <?php echo $data['nama_pelanggan'] ?><br>
                                      Username : <?php echo $data['username'] ?><br>
                                      Saldo : <?php echo $data['saldo'] ?>
                                    </p>
                                  </div>
                                  <div class="col-lg-6">
                                    <form class="basic-farm float-right" method="post">
                                      <div class="form-group">
                                          <p>Topup Saldo Pelanggan</p>
                                          <input name="jumlah_topup" class="form-control" placeholder="Jumlah Topup">
                                      </div>
                                      <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                                <div class="card-body">
                                  <div class="card-title mb-2">
                                      <h4>Aktifitas Pelanggan</h4>
                                      <hr>
                                  </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Jenis</th>
                                                    <th>Jumlah Harga</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                              <?php foreach ($activity as $key => $value): ?>
                                                <tr>
                                                    <td><?php echo $value['tanggal'] ?></td>
                                                    <td><?php echo $value['type'] ?></td>
                                                    <td><?php echo $value['jumlah'] ?></td>
                                                    <td>
                                                      <?php if ($value['type']=='Pesanan'): ?>
                                                        <center><a type="button" class="btn btn-primary" href="detailPesanan.php?tanggal=<?php echo $value['tanggal'] ?>&&no=<?php echo $value['no'] ?>">Detail</a></center>
                                                      <?php endif; ?>
                                                    </td>
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
                    </div>
                </section>
            </div>
        </div>
    </div>

<?php include 'include/foot.php' ?>
