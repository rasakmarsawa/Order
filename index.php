<?php
include 'controller/session.php';
include 'controller/pesananController.php';
include 'controller/barangController.php';

$session = new session();
$pesanan = new pesananController();
$barang = new barangController();

if ($session->check()==false) {
  $session->redirect('login.php');
}

if(isset($_GET['logout'])){
  session_destroy();
  $session->redirect('login.php');
}

$data_barang = $barang->getBarangSaleToday();
$data_pesanan = count($pesanan->getPesananToday());
?>

<?php include 'include/head.php' ?>

    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <!-- /# row -->
                <section id="main-content">
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="card bg-primary">
                          <div class="stat-widget-six">
                            <div class="stat-icon">
                              <i class="ti-stats-up"></i>
                            </div>
                            <div class="stat-content">
                              <div class="text-left dib">
                                <div class="stat-heading">Penjualan Harian</div>
                                <div class="stat-text"><?php echo $data_pesanan; ?> Pesanan</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row"`style="position:fixed;bottom:0">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-title pr">
                                    <h4>Jumlah Barang Terjual Hari Ini</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20">
                                            <thead>
                                                <tr>
                                                    <th>Nama Barang</th>
                                                    <th>Jumlah Terjual Hari Ini</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php foreach ($data_barang as $key => $value): ?>
                                                <tr>
                                                  <td><?php echo $value['nama_barang'] ?></td>
                                                  <td><?php echo $value['jumlah_barang'] ?></td>
                                                </tr>
                                              <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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
