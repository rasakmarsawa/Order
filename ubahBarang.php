<?php
include 'controller/session.php';
include 'controller/barangController.php';

$session = new session();
$barang = new barangController();

$data = $barang->getBarangById($_GET['id']);

if (isset($_POST['submit'])) {
  $_POST['id']=$_GET['id'];
  if ($session->emptyCheck($_POST,array('submit'))) {
    $result = $barang->updateBarang($_POST);
    if ($result) {
      $session->redirect('detailBarang.php?id='.$_GET['id'].'&update');
    }else{
      $session->redirect('ubahBarang.php?id='.$_GET['id'].'&fail');
    }
  }else{
    $session->redirect('ubahBarang.php?id='.$_GET['id'].'&empty');
  }
}

if ($session->check()==false) {
  $session->redirect('login.php');
}

if ($session->checkAdmin()==false) {
  $session->redirect('index.php');
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
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-title">
                                    <h4>Ubah Data Barang</h4>
                                    <hr>
                                </div>
                                <?php if (isset($_GET['fail'])): ?>
                                  <div class="alert alert-danger alert-dismissible fade show">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                    Merubah data barang tidak berhasil.
                                  </div>
                                <?php endif; ?>
                                <?php if (isset($_GET['empty'])): ?>
                                  <div class="alert alert-danger alert-dismissible fade show">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                    Input data tidak boleh kosong.
                                  </div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <form method="post">
                                            <div class="form-group">
                                                <label>Nama Barang</label>
                                                <input name="nama_barang" type="nama" class="form-control" placeholder="Nama Barang" maxlength="50" value="<?php echo $data['nama_barang'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Harga</label>
                                                <input name="harga" type="harga" class="form-control" placeholder="Harga" maxlength="11" value="<?php echo $data['harga'] ?>">
                                            </div>
                                            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                    </div>
                </section>
            </div>
        </div>
    </div>

<?php include 'include/foot.php' ?>
