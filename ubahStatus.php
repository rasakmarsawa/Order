<?php
include 'controller/session.php';
include 'model/statusPesanan.php';

$session = new session();
$spesanan = new statusPesanan();

if ($session->check()==false) {
  $session->redirect('login.php');
}

if ($session->checkAdmin()==false) {
  $session->redirect('index.php');
}

$data = $spesanan->getStatusPesananById($_GET['id']);

if (isset($_POST['submit'])) {
  $_POST['id_status']=$_GET['id'];
  if ($session->emptyCheck($_POST,array('submit','message'))) {
    $result = $spesanan->updateStatusPesanan($_POST);
    if ($result) {
      $session->redirect('listStatus.php?update');
    }else{
      $session->redirect('ubahStatus.php?id='.$_GET['id'].'&fail');
    }
  }else{
    $session->redirect('ubahStatus.php?id='.$_GET['id'].'&empty');
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
                      <div class="card col-lg-12">
                          <div class="card-title">
                              <h4>Ubah Data Status Pesanan</h4>
                              <hr>
                          </div>
                          <?php if (isset($_GET['fail'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                              Merubah data status pesanan tidak berhasil.
                            </div>
                          <?php endif; ?>
                          <?php if (isset($_GET['empty'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                              Nama status tidak boleh dikosongkan.
                            </div>
                          <?php endif; ?>
                          <div class="card-body">
                              <div class="basic-form">
                                  <form method="post">
                                      <div class="form-group">
                                          <label>Nama Status</label>
                                          <input name="nama_status" class="form-control" placeholder="Nama Status" maxlength="50" value="<?php echo $data['nama_status'] ?>">
                                      </div>
                                      <div class="form-group">
                                          <label>Message</label>
                                          <input name="message" class="form-control" placeholder="Message" maxlength="200" value="<?php echo $data['message'] ?>">
                                      </div>
                                      <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                                  </form>
                              </div>
                          </div>
                      </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

<?php include 'include/foot.php' ?>
