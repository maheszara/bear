<?php
include 'koneksi.php';
session_start();
if(!isset($_SESSION['username'])){
 header('location:admin1.php');
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "toko_kue";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
  die("tidak bisa terkoneksi ke database");
}
$kode_produk = "";
$nama_produk = "";
$harga = "";
$stok = "";
$foto = "";
$jenis_produk = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
}
if ($op == 'delete') {
  $kode_produk = $_GET['kode'];
  $sql1 = "delete from produk where kode_produk = '$kode_produk'";
  $q1 = mysqli_query($koneksi, $sql1);
  if ($q1) {
    $sukses = "Berhasil hapus data";
  } else {
    $error = "Gagal melakukan delete data";
  }
}

if ($op == 'edit') {
  $kode_produk = $_GET['kode'];
  $sql1 = "select * from produk where kode_produk= '$kode_produk'";
  $q1 = mysqli_query($koneksi, $sql1);
  $r1 = mysqli_fetch_array($q1);
  $kode_produk = $r1['kode_produk'];
  $nama_produk = $r1['nama_produk'];
  $harga = $r1['harga'];
  $stok = $r1['stok'];
  $foto = $r1['foto'];
  $jenis_produk = $r1['jenis_produk'];

  if ($kode_produk == '') {
    $error = "Data tidak ditemukan";
  }
}

if (isset($_POST['simpan'])) { //untuk create
  $kode_produk = $_POST['kode_produk'];
  $nama_produk = $_POST['nama_produk'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];
  $jenis_produk = $_POST['jenis_produk'];
  $foto = $_FILES['foto']['name'];
  $ekstensi1 = array('png','jpg','jpeg');
  $x = explode('.',$foto);
  $ekstensi = strtolower(end($x));
  $file_tmp = $_FILES['foto']['tmp_name'];
  if(in_array($ekstensi,$ekstensi1) === true){
    move_uploaded_file($file_tmp, 'img/'.$foto);
  }else{
    echo "<script>alert('Ekstensi tidak diperbolehkan')</script>";
  }

  if ($kode_produk && $nama_produk && $harga && $stok && $foto && $jenis_produk) {
    if ($op == 'edit') { //untuk update

      $sql1 = "update produk set kode_produk = '$kode_produk', nama_produk = '$nama_produk', harga = '$harga', stok = '$stok', foto = '$foto', jenis_produk = '$jenis_produk' where id_barang = '$id_barang'";
      $q1 = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses = "Data berhasil diupdate";
      } else {
        $error = "Data gagal diupdate";
      }
    } else { //untuk insert
      $sql1 = "insert into produk(kode_barang,nama_produk,harga,stok,foto,jenis_produk) values ('$kode_produk','$nama_produk','$harga','$stok','$foto','$jenis_produk')";
      $q1 = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses = "Berhasil memasukkan data baru";
      } else {
        $error = "Gagal memasukkan data";
      }
    }
  } else {
    $error = "Silahkan masukkan semua data";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Produk</title>
  <link rel ="stylesheet" href="admin.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <style>
    .mx-auto {
      width: 800px;
    }

    .card {
      margin-top: 10px;
    }
  </style>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Halaman admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="admin1.php">Data Produk</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="checkout/index.php">Data transaksi</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
  <div class="mx-auto">
    <!----untuk memasukan data---->
    <div class="card">
      <div class="card-header">
        Data Produk 
       <?=$_SESSION['username']?>
      </div>
      <div class="card-body">
        <?php
        if ($error) {
          ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
          <?php
          header("refresh:3;url=admin1.php"); //3 : detik
        }
        ?>
        <?php
        if ($sukses) {
          ?>
          <div class="alert alert-success" role="alert">
            <?php echo $sukses ?>
          </div>
          <?php
          header("refresh:3;url=admin1.php"); //3 : detik
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="mb-3 row">
            <label for="kode_produk" class="col-sm-2 col-form-label">kode_produk</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="kode_produk" name="kode_produk" value="<?php echo $kode_produk ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="nama_produk" class="col-sm-2 col-form-label">Nama Produk</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo $nama_produk ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="harga" class="col-sm-2 col-form-label">Harga</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $harga ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="stok" class="col-sm-2 col-form-label">Stok</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $stok ?>">
            </div>
            <div class="mb-3 row">
            <label for="foto" class="col-sm-2 col-form-label">Foto</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" id="foto" name="foto" value="<?php echo $foto ?>">
            </div>
          </div>
            <div class="mb-3 row">
            <label for="jenis_produk" class="col-sm-2 col-form-label">Jenis Produk</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="jenis_produk" name="jenis_produk" value="<?php echo $jenis_produk ?>">
            </div>
          </div>
          </div>
            <div class="col-12">
              <input type="submit" name="simpan" value="Simpan data" class="btn btn-primary">
            </div>
          </form>
          <!--untuk mengeluarkan data-->

        </div>
      </div>
      <div class="card">
        <div class="card-header text-white bg-secondary">
          Data Produk
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Kode Produk</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Harga</th>
                <th scope="col">Stok</th>
                <th scope="col">Foto</th>
                <th scope="col">Jenis Produk</th>
              </tr>
            <tbody>
              <?php
                $sql2 = "select * from produk ";
                $q2 = mysqli_query($koneksi, $sql2);
                $urut = 1;
                while ($r2 = mysqli_fetch_array($q2)) {
                  $kode_produk = $r2['kode_produk'];
                  $nama_produk = $r2['nama_produk'];
                  $harga = $r2['harga'];
                  $stok = $r2['stok'];
                  $foto = $r2['foto'];
                  $jenis_produk = $r2['jenis_produk'];
                  ?>
              <tr>
                <th scope="row">
                  <?php echo $urut++ ?>
                </th>
                <td scope="row">
                  <?php echo $kode_produk ?>
                </td>
                <td scope="row">
                  <?php echo $nama_produk ?>
                </td>
                <td scope="row">
                  <?php echo $harga ?>
                </td>
                <td scope="row">
                  <?php echo $stok ?>
                </td>
                <td scope="row">
                  <?php echo $jenis_produk ?>
                </td>
                <td scope="row">
                 <img src="img/<?php echo $foto ?>" width="100px"  height="100px">
                </td>
                <td scope="row">
                  <a href="admin1.php?op=edit&id=<?php echo $kode_produk ?>"><button type="button"
                      class="btn btn-warning">Edit</button></a>
                  <a href="admin1.php?op=delete&id=<?php echo $kode_produk ?>"> <button type="button" class="btn btn-danger"
                      onclick="return confirm('Yakin ingin delete data?')">Delete</button></a>
                </td>
              </tr>
              <?php
                }
                ?>
          </tbody>
          </thead>
        </table>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-HwwvtgBNo3bZJJLYdoxmnlMuBnhbgrkm"
      crossorigin="anonymous"></script>
</body>
</html>