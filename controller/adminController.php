<?php
include 'controller/session.php';
include 'model/barang.php';
include 'model/kasir.php';
include 'model/topup.php';
include 'model/pesanan.php';
include 'model/statusPesanan.php';

$session = new session();
$barang = new barang();
$kasir = new kasir();
$topup = new topup();
$pesanan = new pesanan();
$spesanan = new statusPesanan();

//check user log in
if ($session->check()==false) {
  $session->redirect('login.php');
}

//check user status
if ($session->checkAdmin()==false) {
  $session->redirect('index.php');
}

//get file name
if (empty($_SERVER['QUERY_STRING'])) {
  $filename = basename($_SERVER['REQUEST_URI'],'.php');
}else{
  $filename = basename($_SERVER['REQUEST_URI'], '.php?' . $_SERVER['QUERY_STRING']);
}

switch ($filename) {
  case 'listBarang':
    $arr = $barang->getBarang();
    break;

  case 'tambahBarang':
    if (isset($_POST['submit'])) {
      if ($session->emptyCheck($_POST,array('submit'))) {
        $result = $barang->addBarang(trim($_POST['nama']),$_POST['harga']);
        if ($result) {
          $session->redirect('listBarang.php?add');
        }else{
          $session->redirect('?fail');
        }
      }else {
        $session->redirect('?empty');
      }
    }
    break;

  case 'detailBarang':
    if (isset($_GET['delete'])) {
      $result = $barang->deleteBarangById($_GET['delete']);
      if ($result==true) {
        $session->redirect('listBarang.php?delete');
      }
    }

    $data = $barang->getBarangById($_GET['id']);
    $detail = $barang->getDetailBarang($_GET['id']);
    break;

  case 'ubahBarang':
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
    break;

  case 'listKasir':
    $arr = $kasir->getKasir();
    break;

  case 'tambahKasir':
    if (isset($_POST['submit'])) {
      $exception = array("submit");
      if ($session->emptyCheck($_POST,$exception)) {
        $result = $kasir->addKasir($_POST);
        if ($result) {
          $session->redirect('listKasir.php?add');
        }else{
          $session->redirect('?fail');
        }
      }else{
        $session->redirect('?empty');
      }
    }
    break;

  case 'detailKasir':
    if (isset($_GET['delete'])) {
      $result = $kasir->deleteKasirById($_GET['delete']);
      if ($result==true) {
        $session->redirect('listKasir.php?delete');
      }
    }

    $data = $kasir->getKasirById($_GET['id']);
    $data1 = $topup->getTopupByKasir($_GET['id']);
    break;

  case 'ubahKasir':
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
    break;

  case 'listPesanan':
    $data = $pesanan->getPesanan();
    break;

  case 'listStatus':
    $arr = $spesanan->getStatusPesanan();
    break;

  case 'ubahStatus':
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
    break;

  default:
    echo "page {$filename} not found";
    break;
}
?>
