<?php
include 'controller/session.php';
include 'controller/barangController.php';
include 'controller/pesananController.php';
include 'controller/detailPesananController.php';

$session = new session();
$barang = new barangController();
$pesanan = new pesananController();
$detailPesanan = new detailPesananController();

if ($session->check()==false) {
  $session->redirect('login.php');
}

$arr = $barang->getBarang();

if (isset($_POST['submit'])) {
  $data = $pesanan->addPesananGuess($_POST,$arr);
  if ($data['dataPesanan']['total_harga']!=0) {
    $pesanan->api_addPesanan($data['dataPesanan']);
    $detailPesanan->api_addDetailPesanan($data['dataDetail']);

    $session->redirect('antrian.php');
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
                                <div class="card-title mb-2">
                                    <h4>Buat Pesanan Baru</h4>
                                </div>
                                <div class="card-body">
                                  <form method="post">
                                    <div class="float-right">
                                      <button type="submit" name="submit" class="btn btn-primary">Buat Pesanan</button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Barang</th>
                                                    <th>Harga</th>
                                                    <th>Jumlah Barang</th>
                                                </tr>
                                            </thead>
                                              <tbody>

                                                <?php
                                                $i=1;
                                                foreach ($arr as $key => $value): ?>
                                                  <tr>
                                                      <th scope="row"><?php echo $i ?></th>
                                                      <td><?php echo $value['nama_barang'] ?></td>
                                                      <td><?php echo "Rp. ".$value['harga'] ?></td>
                                                      <td><input type='number' value="0" min="0" class="form-control" name="<?php echo $key ?>"/></td>
                                                  </tr>
                                                <?php $i++;
                                              endforeach; ?>
                                              </tbody>
                                        </table>
                                    </div>
                                  </form>
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
