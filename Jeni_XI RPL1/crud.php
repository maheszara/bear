<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "toko_kue";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
  die("tidak bisa terkoneksi ke database");
}
$kode_produk ="";
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
  $kode_produk = $_GET['kode_produk'];
  $sql1 = "delete from produk where kode_produk = '$kode_produk'";
  $q1 = mysqli_query($koneksi, $sql1);
  if ($q1) {
    $sukses = "Berhasil hapus data";
  } else {
    $error = "Gagal melakukan delete data";
  }
}

if ($op == 'edit') {
  $kode_produk = $_GET['kode_produk'];
  $sql1 = "select * from produk where kode_produk = '$kode_produk'";
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
  $foto = $_FILES['foto']['name'];
  $ekstensi1 = array('png','jpg','jpeg');
  $x = explode('.',$foto);
  $ekstensi = strtolower(end($x));
  $file_tmp = $_FILES['foto']['tmp_name'];
  if(in_array($ekstensi,$ekstensi1) === true){
    move_uploaded_file($file_tmp, 'img/'.$foto);
  }else{
    echo "<script>alert('Ekstensi tidak diperbolehkan')</script>";
  };
  $jenis_produk = $_POST['jenis_produk'];

  if ($kode_produk && $nama_produk && $harga && $stok && $foto && $jenis_produk) {
    if ($op == 'edit') { //untuk update
      $sql1 = "update produk set kode_produk = '$kode_produk', nama_produk = '$nama_produk', harga = '$harga', stok = '$stok', foto = '$foto', jenis_produk = '$jenis_produk' where kode_produk = '$kode_produk'";
      $q1 = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses = "Data berhasil diupdate";
      } else {
        $error = "Data gagal diupdate";
      }
    } else { //untuk insert
      $sql1 = "insert into produk(kode_produk,nama_produk,harga,stok,foto,jenis_produk) values ('$kode_produk','$nama_produk','$harga','$stok','$foto','$jenis_produk')";
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
  <div class="mx-auto">
    <!----untuk memasukan data---->
    <div class="card">
      <div class="card-header">
        Create / edit data
      </div>
      <div class="card-body">
        <?php
        if ($error) {
          ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
          <?php
          header("refresh:3;url=crud.php"); //5 : detik
        }
        ?>
        <?php
        if ($sukses) {
          ?>
          <div class="alert alert-success" role="alert">
            <?php echo $sukses ?>
          </div>
          <?php
          header("refresh:3;url=crud.php"); //5 : detik
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="mb-3 row">
            <label for="kode_produk" class="col-sm-2 col-form-label">Kode_Produk</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="kode_produk" name="kode_produk" value="<?php echo $kode_produk ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="nama_produk" class="col-sm-2 col-form-label">Nama_Produk</label>
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
          </div>
          <div class="mb-3 row">
            <label for="foto" class="col-sm-2 col-form-label">Foto</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" id="Foto" name="foto" value="<?php echo $foto ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="jenis_produk" class="col-sm-2 col-form-label">Jenis_Produk</label>
            <div class="col-sm-10">
              <select class="form-control" name="jenis_produk" id="jenis_produk">
                <option value="">- pilih jenis_produk -</option>
                <option value="bento cake" <?php if ($jenis_produk == "bento cake")
                  echo "selected" ?>>Hiasan</option>
                  <option value="cake mini" <?php if ($jenis_produk == "cake mini")
                  echo "selected" ?>>Kue</option>
                </select>
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
          data produk
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Kode_Produk</th>
                <th scope="col">Nama_Produk</th>
                <th scope="col">Harga</th>
                <th scope="col">Stok</th>
                <th scope="col">Foto</th>
                <th scope="col">Jenis_Produk</th>
              </tr>
            <body>
              <?php
                $sql2 = "select * from produk order by kode_produk";
                $q2 = mysqli_query($koneksi, $sql2);
                $urut = 1;
                while ($r2 = mysqli_fetch_array($q2)) {
                  $kode_produk = $r2['kode_produk'];
                  $nama_produk = $r2['nama_produk'];
                  $harga = $r2['harga'];
                  $stok = $r2['stok'];
                  $foto= $r2['foto'];
                  $jenis_produk= $r2['jenis_produk'];

                  ?>
                  <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Produk</title>
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
                  <img src="img/<?php echo $foto ?>" width="100px" height="100px">
                </td>
                <td scope="row">
                  <a href="crud.php?op=edit&id=<?php echo $kode_produk ?>"><button type="button"
                      class="btn btn-warning">Edit</button></a>
                  <a href="crud.php?op=delete&id=<?php echo $kode_produk ?>"> <button type="button" class="btn btn-danger"
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
      integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
      crossorigin="anonymous"></script>
</body>
</html>
       