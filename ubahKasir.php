<?php
include 'controller/session.php';
include 'controller/kasirController.php';

$session = new session();
$kasir = new kasirController();

$data = $kasir->getKasirById($_GET['id']);

if (isset($_POST['submit'])) {
  $_POST['username']=$_GET['id'];
  $exception = array("submit","password");
  if ($session->emptyCheck($_POST,$exception)) {
    $result = $kasir->updateKasir($_POST);
    if ($result) {
      $session->redirect('detailKasir.php?id='.$_GET['id'].'&update');
    }else{
      $session->redirect('ubahKasir.php?id='.$_GET['id'].'&fail');
    }
  }else{
    $session->redirect('ubahKasir.php?id='.$_GET['id'].'&empty');
  }
}

if ($session->check()==false) {
  $session->redirect('login.php');
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
                                    <h4>Ubah Data Kasir</h4>
                                </div>
                                <?php if (isset($_GET['fail'])): ?>
                                  <div class="alert alert-danger alert-dismissible fade show">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                    Merubah data kasir tidak berhasil.
                                  </div>
                                <?php endif; ?>
                                <?php if (isset($_GET['empty'])): ?>
                                  <div class="alert alert-danger alert-dismissible fade show">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                    Merubah data kasir tidak berhasil. Data tidak boleh dikosongkan.
                                  </div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <form method="post">
                                            <div class="form-group">
                                                <label>Nama Kasir</label>
                                                <input name="nama_kasir" class="form-control" placeholder="Nama Kasir" maxlength="50" value="<?php echo $data['nama_kasir'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input name="password" class="form-control" placeholder="Password" maxlength="20">
                                            </div>
                                            <div class="form-group">
                                                <select
                                                <?php if ($_GET['id']=='admin'): ?>
                                                  hidden
                                                <?php endif; ?>
                                                class="form-control" name="admin">
                                                  <option value="0">Kasir</option>
                                                  <option
                                                  <?php if ($data['admin']==1): ?>
                                                    selected
                                                  <?php endif; ?>
                                                   value="1">Admin</option>
                                                </select>
                                            </div>
                                            <button name="submit" type="submit" class="btn btn-default">Submit</button>
                                        </form>
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
