<?php
include 'controller/session.php';
include 'controller/pesananController.php';
include 'controller/detailPesananController.php';
include 'controller/notification.php';

$session = new session();
$pesanan = new pesananController();
$detail = new detailPesananController();

if ($session->check()==false) {
  $session->redirect('login.php');
}

$data0 = $pesanan->getPesananById($_GET);
$data = $detail->getDetailPesananByPesanan($_GET);

if (isset($_POST['submit'])) {
  if($pesanan->next($_GET)){
      $data0['status'] = $data0['status']+1;

      $res = pushNotification(
        1,
        $data0['fcm_token'],
        'Pesananmu',
        'Status pesananmu saat ini adalah '.$pesanan->statusMeaning($data0['status']),
        1,
        $data0,
        "DetailActivity"
      );

      $session->redirect('detailPesanan.php?tanggal='.$_GET['tanggal'].'&&no='.$_GET['no'].'&&Next');
  }
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
                                    <h4>Detail Pesanan </h4>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="card-title"><?php echo $data0['nama_pelanggan'] ?></h4>
                                    <h6 class="card-subtitle">No Urut <?php echo $data0['no'] ?>/ Rp. <?php echo $data0['total_harga']; ?></h6>
                                    <h6 class="card-subtitle"><?php echo $data0['tanggal'] ?></h6>
                                </div>
                                <div class="col-lg-6">
                                  <form class="basic-farm float-right" method="post">
                                    <center>
                                      <div class="form-group mb-0">
                                        <label>Status : <?php echo $pesanan->statusMeaning($data0['status']) ?></label>
                                      </div>
                                      <div>
                                        <?php if ($data0['status']!=4 && $_SESSION['admin']!=1): ?>
                                          <button name="submit" type="submit" class="btn btn-primary">
                                            <?php switch ($data0['status']) {
                                              case '1':
                                                echo "Mulai";
                                                break;
                                              case '2':
                                                echo "Siap Diambil";
                                                break;
                                              case '3':
                                                echo "Selesai";
                                                break;
                                            } ?>
                                          </button>
                                        <?php endif; ?>
                                      </div>
                                    </center>
                                  </form>
                                </div>
                              </div>
                                <?php if (isset($_GET['Next'])): ?>
                                  <div class="alert alert-success alert-dismissible fade show">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                    Pesanan dilanjutkan. Status pesanan saat ini <?php echo $pesanan->statusMeaning($data0['status']) ?>
                                  </div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Barang</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                              <?php
                                              $i=1;
                                              foreach ($data as $key => $value): ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i ?></th>
                                                    <td><?php echo $value['nama_barang'] ?></td>
                                                    <td><?php echo $value['jumlah_barang'] ?></td>
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
