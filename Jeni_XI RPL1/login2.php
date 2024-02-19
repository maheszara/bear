<?php
    include "koneksi.php";
    session_start();
    if(isset($_POST['tabel_pembeli'])){
        $id = $_POST['id'];
        $nama = $_POST['nama'];          
        $alamat = $_POST['alamat'];  
        $no_ponsel = $_POST['no_ponsel'];  
        $kata_sandi = $_POST['kata_sandi'];

        if($id!="" && $nama!="" && $alamat!="" && $no_ponsel!="" && $kata_sandi!=""){
            $mysqli_query($koneksi, "SELECT * FROM table_pembeli WHERE id='$id' and nama='$nama' and alamat='$alamat'and no_ponsel='$no_ponsel' and kata_sandi='$kata_sandi'");
            if($data = mysqli_fetch_array($mysql)){
                $_SESSION['id']=$data['id'];
                $_SESSION['nama']=$data['nama'];
                $_SESSION['alamat']=$data['alamat'];
                $_SESSION['no_ponsel']=$data['no_ponsel'];
                $_SESSION['kata_sandi']=$data['kata_sandi'];
                header('location:login.php');
            }else{
                ?>
               <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-idden="true"></span>
                <?php $error="";?> Username atau Password Salah
            </div><?php
            }
        }
    }
?>   

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jie Sweet Dessert</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="login">
            <form action="">
                <h1>Jie Sweet Dessert🍪</h1>
                <hr>
                <p> Cirebon City</p>
                <label for="Nama">Nama</label> 
                <input type="text" name="Nama">
                <br></br>
                <label for="Alamat">Alamat </label>
                <input type="text" name="Alamat">
                <br></br>
                <label for="No Ponsel">No_Ponsel</label>
                <input type="text" name="No_Ponsel">
                <br></br>
                <label for="Kata Sandi">Kata_Sandi</label>
                <input type="text" name="Kata_Sandi">
                <br></br>
                <button>Login</button>
                    <a href="#">Lupa Kata Sandi?</a>
                </p>
            </form>
            </div>
            <div class="right">
                <img src="jiue.jpg.jpeg" alt="">
        </div>
    </div>
</body>
</html> 