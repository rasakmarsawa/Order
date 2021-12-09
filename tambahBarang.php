<?php
include 'controller/session.php';
include 'controller/barangController.php';

$session = new session();
$barang = new barangController();

if (isset($_POST['submit'])) {
  $result = $barang->addBarang(trim($_POST['nama']),$_POST['harga']);
  if ($result) {
    $session->redirect('listBarang.php?add');
  }else{
    $session->redirect('?fail');
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
                                    <h4>Tambah Barang</h4>
                                    <hr>
                                </div>
                                <?php if (isset($_GET['fail'])): ?>
                                  <div class="alert alert-danger alert-dismissible fade show">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                    Tambah data tidak berhasil. Nama barang sudah digunakan.
                                  </div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <form method="post">
                                            <div class="form-group">
                                                <label>Nama Barang</label>
                                                <input name="nama" type="nama" class="form-control" placeholder="Nama Barang" maxlength="50">
                                            </div>
                                            <div class="form-group">
                                                <label>Harga</label>
                                                <input name="harga" type="harga" class="form-control" placeholder="Harga" maxlength="11">
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
