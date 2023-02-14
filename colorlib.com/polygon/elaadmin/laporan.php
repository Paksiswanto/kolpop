<?php
require 'config.php';
if(!empty($_SESSION["id"])){
  $id = $_SESSION["id"];
  $result = mysqli_query($conn, "SELECT * FROM tbuser WHERE id = $id");
  $row = mysqli_fetch_assoc($result);
}
else{
  header("Location: login.php");
}
?>
<?php
$host   = "localhost";
$user   = "root";
$pass   = "";
$db     = "sekolah";

$koneksi     = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$Kode_guru     = "";
$Nama_guru     = "";
$Jenis_kelamin = "";
$Alamat        = "";
$sukses        = "";
$error         = "";

if (isset($_GET['op'])) {  //tahapan untuk url
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete'){ //mengoprasikan data  didelete
    $id             = $_GET['id'];
    $sql1           = "delete from tbguru where id = '$id'";
    $q1             = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}

if ($op == 'edit') { //mengoprasikan data untuk diedit
    $id           = $_GET['id'];
    $sql1            = "select * from tbguru where id = '$id'";
    $q1              = mysqli_query($koneksi, $sql1);
    $r1              = mysqli_fetch_array($q1);
    $Kode_guru       = $r1['Kode_guru']; 
    $Nama_guru       = $r1['Nama_guru'];
    $Jenis_kelamin   = $r1['Jenis_kelamin'];
    $Alamat          = $r1['Alamat'];

    if ($Kode_guru == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) { // untuk create
    $Kode_guru     = $_POST['Kode_guru'];
    $Nama_guru     = $_POST['Nama_guru'];
    $Jenis_kelamin = $_POST['Jenis_kelamin'];
    $Alamat        = $_POST['Alamat'];

    if ($Kode_guru && $Nama_guru && $Jenis_kelamin && $Alamat) {
        if ($op == 'edit') { //untuk update
            $sql1        = "Update tbguru set Kode_guru = '$Kode_guru',Nama_guru= '$Nama_guru',Jenis_kelamin = '$Jenis_kelamin',Alamat= '$Alamat' where id = '$id' ";
            $q1          = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else {  //untuk insert
            $sql1 = "insert into tbguru(Kode_guru,Nama_guru,Jenis_kelamin,Alamat) values ('$Kode_guru','$Nama_guru','$Jenis_kelamin','$Alamat')";
            $q1 =  mysqli_query($koneksi,$sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukan data baru";
            }else{
                $error      ="Gagal Memasukan data";
            }
        }
    } else {
        $error = "Silahkan masukan data";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="Width=device-width, initial-scale=1.0">
    <title>Data sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {          
            width: 800px
        }
                            
        .card {
            margin-top: 10px;
        }
        * {box-sizing: border-box;}

body { 
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.header {
  overflow: hidden;
  background-color: #f1f1f1;
  padding: 20px 10px;
}

.header a {
  float: left;
  color: black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px; 
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header a.active {
  background-color: dodgerblue;
  color: white;
}

.header-right {
  float: right;
}

@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  
  .header-right {
    float: none;
  }
}

    </style>
</head>

<body>
<div class="header">
  <a href="#default" class="logo">CRUD</a>
  <div class="header-right">
<a href="logout.php" style="color:red">Logout</a>
<a href="index.php" style="color: #48f542">Data Guru</a> 
<a href="siswa.php" style="color: #48f542">Data Siswa</a>
<a href="jurusan.php" style="color: #48f542">Data Jurusan</a>
<a href="mapel.php" style="color: #48f542">Data Mapel</a>
<a href="eskul.php" style="color: #48f542"> Data Ekstrakurikuler</a>
  </div>
</div>
    
    <div class="mx-auto">
        <!-- Untuk memasukan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                 
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                   header("refresh:2;url=index.php"); // 2 detik
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="Kode_guru " class="form-label">Kode Guru</label>
                        <input type="text" class="form-control" id="Kode_guru" name="Kode_guru" value="<?php echo $Kode_guru ?> ">
                    </div>

                    <div class="mb-3">
                        <label for="Nama_guru " class="form-label">Nama Guru</label>
                        <input type="text" class="form-control" id="Nama_guru" name="Nama_guru" value="<?php echo $Nama_guru ?> ">
                    </div>

                    <div class="mb-3">
                        <label for="Jenis_kelamin " class="form-label">Jenis kelamin</label>
                        <select class="form-control" name="Jenis_kelamin" id="Jenis_kelamin">
                            <option value="">- Jenis Kelamin -</option>
                            <option value="LAKI-LAKI" <?php if ($Jenis_kelamin == "LAKI-LAKI") echo "selected" ?>>LAKI-LAKI</option>
                            <option value="PEREMPUAN" <?php if ($Jenis_kelamin == "PEREMPUAN") echo "selected" ?>>PEREMPUAN</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="Kode_guru " class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="Alamat" name="Alamat" value="<?php echo $Alamat ?> ">
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>

                </form>
            </div>
        </div>
        <!-- tempat dimana mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Guru
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <Tr>
                            <th scope="col">#</th>
                            <th scope="col">Kode Guru</th>
                            <th scope="col">Nama Guru</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Aksi</th>
                        </Tr>
                    <tbody>
                        <?php //mengeluarkan isi dari data-data dari variabel tadi
                        $sql2   = "select * from tbguru order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id             = $r2['id'];
                            $Kode_guru      = $r2['Kode_guru'];
                            $Nama_guru      = $r2['Nama_guru'];
                            $Jenis_kelamin  = $r2['Jenis_kelamin'];
                            $Alamat         = $r2['Alamat'];

                        ?>
                            <tr>
                                <th scope="row"> <?php echo $urut++ ?></th>
                                <Td scope="row"><?php echo $Kode_guru ?></Td>
                                <Td scope="row"><?php echo $Nama_guru ?></Td>
                                <Td scope="row"><?php echo $Jenis_kelamin ?></Td>
                                <Td scope="row"><?php echo $Alamat ?></Td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger float-end">Delete</button></a>
                                    
                                </td>
                            </tr>
                        <?php

                        }

                        ?>
                    </tbody>
                    </thead>
                </table>
                <form action="" method="POST">

                </form>
            </div>
        </div>
    </div>
</body>

</html>