<?php
include 'controller/session.php';
include 'controller/notification.php';
include 'model/pesanan.php';
include 'model/statusAntrian.php';
include 'model/pelanggan.php';

$session = new session();
$pesanan = new pesanan();
$status = new statusAntrian();
$pelanggan = new pelanggan();


if ($session->check()==false) {
  $session->redirect('login.php');
}

if ($session->checkAdmin()==true) {
  $session->redirect('index.php');
}

if (isset($_POST['submit'])) {
  switch ($_POST['submit']) {
    case '1':
      // code...
      $status->updateStatus(1,$_SESSION['username']);

      pushNotification(
        0,
        $pelanggan->getAllToken(),
        "Restoran buka",
        "Udah bisa pesan makanan lagi nih",
        3,
        1,
        null
      );
      break;
    case '2':
      $status->updateStatus(2,$_SESSION['username']);
      pushNotification(
        0,
        $pelanggan->getAllToken(),
        "Restoran tutup",
        "Udah ga bisa mesan makanan lagi deh",
        3,
        2,
        null
      );
      break;
  }
}

$data = $pesanan->getAntrian();
$stat = $status->getLastStatus();
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
                                    <h4>Antrian Pesanan </h4>
                                    <hr>
                                </div>
                                <div class="card-subtitle">
                                  <p>Status Antrian : <?php echo $status->statusMeaning($stat['status']) ?></p>
                                  <form class="basic-form" method="post">
                                      <div class="form-group">
                                        <?php if ($stat['status']==1): ?>
                                            <button name="submit" type="submit" class="btn btn-primary" value="2">Tutup Antrian</button>
                                          <?php else: ?>
                                            <button name="submit" type="submit" class="btn btn-primary" value="1">Buka Antrian</button>
                                        <?php endif; ?>
                                      </div>
                                    </center>
                                  </form>
                                </div>
                                <div class="card-title">
                                  <hr>
                                </div>
                                <div class="card-body">
                                  <a href="tambahPesanan.php" class="btn btn-primary float-right">
                                    Tambah Pesanan
                                  </a>
                                  <div class="bootstrap-data-table-panel">
                                      <div class="table-responsive">
                                          <table id="row-select" class="display table table-borderd table-hover">
                                              <thead>
                                                  <tr>
                                                      <th>Nomor Antrian</th>
                                                      <th>Nama Pelanggan</th>
                                                      <th>Status Pesanan</th>
                                                      <th></th>
                                                  </tr>
                                              </thead>

                                              <tbody>
                                                <?php foreach ($data as $key => $value): ?>
                                                  <tr>
                                                      <td><?php echo $value['no'] ?></td>
                                                      <td><?php echo $value['nama_pelanggan'] ?></td>
                                                      <td><?php echo $value['nama_status'] ?></td>
                                                      <td><center><a type="button" class="btn btn-primary" href="detailPesanan.php?tanggal=<?php echo $value['tanggal'] ?>&&no=<?php echo $value['no'] ?>">Detail</a></center></td>
                                                  </tr>
                                                <?php endforeach; ?>
                                              </tbody>
                                              <tfoot>
                                                  <tr>
                                                      <th>Nomor Antrian</th>
                                                      <th>Nama Pelanggan</th>
                                                      <th>Status Pesanan</th>
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
                </section>
            </div>
        </div>
    </div>

<?php include 'include/foot.php' ?>
