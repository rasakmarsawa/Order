<?php
include 'controller/session.php';
include 'controller/pesananController.php';
include 'controller/statusAntrianController.php';

$session = new session();
$pesanan = new pesananController();
$status = new statusAntrianController();


if ($session->check()==false) {
  $session->redirect('login.php');
}

if (isset($_POST['submit'])) {
  if ($_POST['submit']==1) {
    //antrian ditutup
    $status->updateStatus(2,$_SESSION['username']);
  }else {
    //antrian dibuka
    $status->updateStatus(1,$_SESSION['username']);
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
                                      <form class="basic-farm float-right" method="post">
                                        <center>
                                          <div class="form-group mb-0">
                                              <label>Status Antrian : <?php echo $status->statusMeaning($stat['status']) ?></label>
                                          </div>
                                          <?php if ($stat['status']==1): ?>
                                              <button name="submit" type="submit" class="btn btn-primary" value="tutup">Tutup</button>
                                            <?php else: ?>
                                              <button name="submit" type="submit" class="btn btn-primary" value="buka">Buka</button>
                                          <?php endif; ?>
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
                                                      <td><?php echo $pesanan->statusMeaning($value['status']) ?></td>
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
