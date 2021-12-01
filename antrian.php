<?php
include 'controller/session.php';
include 'controller/pesananController.php';
include 'controller/statusAntrianController.php';
include 'controller/pelangganController.php';
include 'controller/notification.php';

$session = new session();
$pesanan = new pesananController();
$status = new statusAntrianController();
$pelanggan = new pelangganController();


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
    default:
      $session->redirect('tambahPesanan.php');
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
                                <div class="card-title mb-2">
                                    <h4>Antrian Pesanan </h4>
                                    <div class="col-lg-12">
                                      <div>
                                          <label>Status Antrian : <?php echo $status->statusMeaning($stat['status']) ?></label>
                                      </div>
                                      <form class="basic-farm" method="post">
                                          <div class="form-group">
                                            <?php if ($stat['status']==1): ?>
                                                <button name="submit" type="submit" class="btn btn-primary" value="2">Tutup</button>
                                              <?php else: ?>
                                                <button name="submit" type="submit" class="btn btn-primary" value="1">Buka</button>
                                            <?php endif; ?>
                                            <button name="submit" type="submit" class="btn btn-primary float-right" value="0">Tambah Pesanan</button>
                                          </div>
                                        </center>
                                      </form>
                                    </div>
                                </div>
                                <div class="card-body">
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
