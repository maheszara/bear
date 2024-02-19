 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> Tambah Data Pengguna </title>
</head>
<body>
    <a href="home.php"> Kembali ke Home</a><br></br>
    <form action="login.php" method="post" enctype="multipart/form-data" name="">
        <table width="25%" border="0">
            <tr>
                <td> Nama</td>
                <td><input type="text" name="nama"></td>
            </tr>
            <tr>
                <td> Alamat</td>
                <td><input type="text" name="alamat"></td>
            </tr>
            <tr>
                <td> No Ponsel</td>
                <td><input type="text" name="no ponsel"></td>
            </tr>
            <tr>
                <td> Kata Sandi</td>
                <td><input type="text" name="kata sandi"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="tambah"></td>
            </tr>
        </table>
    </form>
    <table border=1>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No_Ponsel</th>
                <th>Kata_Sandi</th>
            </tr>
            <td>
            <td> no; $no++;</td>
            <td>.$data['nama']</td>
            <td>.$data['alamat'].</td>
            <td>.$data['no_ponsel'].</td>
            <td>.$data['kata_sandi'].</td>
            <td><img src='img/".$data['foto']."'></td>;
            <td> <a href="tambah_pengguna.php?aksi=edit&id_pengguna"></a> </td>
            </td>
        </thead>
    </table>  
</body>
</html>