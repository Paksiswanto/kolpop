<<<<<<< HEAD
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

=======
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->

<!-- Mirrored from colorlib.com/polygon/elaadmin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Feb 2023 04:49:20 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Kuliner Admin</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="images/favicon.png">
    <link rel="shortcut icon" href="images/favicon.png">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
    <link href="assets/calendar/fullcalendar.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="assets/css/charts/chartist.min.css" rel="stylesheet">
    <link href="assets/css/lib/vector-map/jqvmap.min.css" rel="stylesheet">
    <style>
        #weatherWidget .currentDesc {
            color: #ffffff !important;
        }

        .traffic-chart {
            min-height: 335px;
        }

        #flotPie1 {
            height: 150px;
        }

        #flotPie1 td {
            padding: 3px;
        }

        #flotPie1 table {
            top: 20px !important;
            right: -10px !important;
        }

        .chart-container {
            display: table;
            min-width: 270px;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        #flotLine5 {
            height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }

        #cellPaiChart {
            height: 160px;
        }
    </style>
    <meta name="robots" content="noindex, nofollow">
    <script nonce="2ec97ad6-5e03-42de-82ef-bf3670cfd798">
        (function(w, d) {
            ! function(f, g, h, i) {
                f[h] = f[h] || {};
                f[h].executed = [];
                f.zaraz = {
                    deferred: [],
                    listeners: []
                };
                f.zaraz.q = [];
                f.zaraz._f = function(j) {
                    return function() {
                        var k = Array.prototype.slice.call(arguments);
                        f.zaraz.q.push({
                            m: j,
                            a: k
                        })
                    }
                };
                for (const l of ["track", "set", "debug"]) f.zaraz[l] = f.zaraz._f(l);
                f.zaraz.init = () => {
                    var m = g.getElementsByTagName(i)[0],
                        n = g.createElement(i),
                        o = g.getElementsByTagName("title")[0];
                    o && (f[h].t = g.getElementsByTagName("title")[0].text);
                    f[h].x = Math.random();
                    f[h].w = f.screen.width;
                    f[h].h = f.screen.height;
                    f[h].j = f.innerHeight;
                    f[h].e = f.innerWidth;
                    f[h].l = f.location.href;
                    f[h].r = g.referrer;
                    f[h].k = f.screen.colorDepth;
                    f[h].n = g.characterSet;
                    f[h].o = (new Date).getTimezoneOffset();
                    if (f.dataLayer)
                        for (const s of Object.entries(Object.entries(dataLayer).reduce(((t, u) => ({
                                ...t[1],
                                ...u[1]
                            }))))) zaraz.set(s[0], s[1], {
                            scope: "page"
                        });
                    f[h].q = [];
                    for (; f.zaraz.q.length;) {
                        const v = f.zaraz.q.shift();
                        f[h].q.push(v)
                    }
                    n.defer = !0;
                    for (const w of [localStorage, sessionStorage]) Object.keys(w || {}).filter((y => y.startsWith("_zaraz_"))).forEach((x => {
                        try {
                            f[h]["z_" + x.slice(7)] = JSON.parse(w.getItem(x))
                        } catch {
                            f[h]["z_" + x.slice(7)] = w.getItem(x)
                        }
                    }));
                    n.referrerPolicy = "origin";
                    n.src = "https://colorlib.com/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(f[h])));
                    m.parentNode.insertBefore(n, m)
                };
                ["complete", "interactive"].includes(g.readyState) ? zaraz.init() : f.addEventListener("DOMContentLoaded", zaraz.init)
            }(w, d, "zarazData", "script");
        })(window, document);
    </script>
</head>

<body>

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="index.php"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <li class="menu-title">Data-data Admin</li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Tabel</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-thumb-tack"></i><a href="">Data Tempat</a></li>
                            <li><i class="fa fa-tasks"></i><a href="">Data Menu</a></li>
                            <li><i class="fa fa-tag"></i><a href="">Data Jenis Makanan</a></li>
                            <li><i class="fa fa-group"></i><a href="">Data Users</a></li>
                            <li><i class="fa fa-book"></i><a href="">Data Posts</a></li>
                            <li><i class="fa fa-comments"></i><a href="">Data Ulasan</a></li>
                            <li><i class="fa fa-trophy"></i><a href="">Data Penghargaan</a></li>
                            <li><i class="fa fa-star"></i><a href="trend.html">Data Trend</a></li>
                            <li><i class="fa fa-tags"></i><a href="sub_kategori.html">Data Sub_category</a></li>
                            <li><i class="fa fa-exclamation-triangle"></i><a href="laporan.html">Data Laporan</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>


    <div id="right-panel" class="right-panel">

        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="https://colorlib.com/polygon/elaadmin/"><img src="" alt=""></a>
                    <a class="navbar-brand hidden" href="https://colorlib.com/polygon/elaadmin/"><img src="" alt="Logo"></a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="header-left">
                        <button class="search-trigger"><i class="fa fa-search"></i></button>
                        <div class="form-inline">
                            <form class="search-form">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                            </form>
                        </div>
                      
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="https://colorlib.com/polygon/elaadmin/images/admin.jpg" alt="User Avatar">
                        </a>
                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa-user"></i>My Profile</a>
                            <a class="nav-link" href="#"><i class="fa fa-bell-o"></i>Notifications <span class="count">13</span></a>
                            <a class="nav-link" href="#"><i class="fa fa-cog"></i>Settings</a>
                            <a class="nav-link" href="#"><i class="fa fa-power-off"></i>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="content pb-0">

            <div class="row">
                <div class="col-lg-3 col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-4">
                                    <i class="pe-7f-users"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count">2986</span></div>
                                        <div class="stat-heading">Clients</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix">

                                <h4 class="box-title">Orders </h4>
                            </div>
                            <div class="card-body--">
                                <div class="table-stats order-table ov-h">
                                    <table class="table table-bordered shadow p-3 mb-5 bg-white rounded table-hover">
                                        <thead>
                                            <tr align="center">
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>post</th>
                                                <th>laporan</th>
                                                <th align="center">aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-bordered">
                                            <tr align="center">
                                                <td class="serial">1.</td>
                                                <td> Adi Mahmudi </td>
                                                <td> <span class="name">Resep Molen isi Bihun</span> </td>
                                                <td><span class="name">Menurut saya ini agak aneh sejak kapan ada molen isi bihun</span></td>
                                                <td><button class="btn btn-danger" type="submit"> HAPUS </button></td>
                                            </tr>
                                            <tr align="center">
                                                <td class="serial">2.</td>
                                                <td> Haji Muhidin </td>
                                                <td> <span class="name">Bubur Naik Haji</span> </td>
                                                <td> <span class="name">Sejak kapan ada bubur naik haji naik apa dia?</span> </td>
                                                <td><button class="btn btn-danger" type="submit"> HAPUS </button></td>
                                            </tr>
                                            <tr align="center">
                                                <td class="serial">3.</td>
                                                <td> Garit Manusia ikan </td>
                                                <td> <span class="name"></span> Ikan masak asam </td>
                                                <td> <span class="product">Ikan masak asam ini sangat enak apalagi saya sebagai pecinta masakan ikan</span> </td>
                                                <td><button class="btn btn-danger" type="submit"> HAPUS </button></td>
                                            </tr>
                                            <tr align="center">
                                                <td class="serial">4.</td>
                                                <td> Habib Al Gatot </td>
                                                <td> <span class="name">Resto Makan semua</span> </td>
                                                <td> <span class="product">Disini Sangatlah enak apalagi ada pilihan all you can eat nya</span> </td>
                                                <td><button class="btn btn-danger" type="submit"> HAPUS </button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                
        <div class="clearfix"></div>
        <footer class="site-footer">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-6">
                        Copyright &copy; 2018 Ela Admin
                    </div>
                    <div class="col-sm-6 text-right">
                        Designed by <a href="https://colorlib.com/">Colorlib</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://colorlib.com/polygon/elaadmin/assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="https://colorlib.com/polygon/elaadmin/assets/js/popper.min.js"></script>
    <script src="https://colorlib.com/polygon/elaadmin/assets/js/plugins.js"></script>
    <script src="https://colorlib.com/polygon/elaadmin/assets/js/main.js"></script>
    <script src="https://colorlib.com/polygon/elaadmin/assets/js/lib/chart-js/Chart.bundle.js"></script>

    <script src="https://colorlib.com/polygon/elaadmin/assets/js/lib/chartist/chartist.min.js"></script>
    <script src="https://colorlib.com/polygon/elaadmin/assets/js/lib/chartist/chartist-plugin-legend.js"></script>
    <script src="https://colorlib.com/polygon/elaadmin/assets/js/lib/flot-chart/jquery.flot.js"></script>
    <script src="https://colorlib.com/polygon/elaadmin/assets/js/lib/flot-chart/jquery.flot.pie.js"></script>
    <script src="https://colorlib.com/polygon/elaadmin/assets/js/lib/flot-chart/jquery.flot.spline.js"></script>
    <script src="https://colorlib.com/polygon/elaadmin/assets/weather/js/jquery.simpleWeather.min.js"></script>
    <script src="https://colorlib.com/polygon/elaadmin/assets/weather/js/weather-init.js"></script>
    <script src="https://colorlib.com/polygon/elaadmin/assets/js/lib/moment/moment.js"></script>
    <script src="https://colorlib.com/polygon/elaadmin/assets/calendar/fullcalendar.min.js"></script>
    <script src="https://colorlib.com/polygon/elaadmin/assets/calendar/fullcalendar-init.js"></script>
    <script>
        jQuery(document).ready(function($) {
            "use strict";

            // Pie chart flotPie1 
            var piedata = [{
                    label: "Desktop visits",
                    data: [
                        [1, 32]
                    ],
                    color: '#5c6bc0'
                },
                {
                    label: "Tab visits",
                    data: [
                        [1, 33]
                    ],
                    color: '#ef5350'
                },
                {
                    label: "Mobile visits",
                    data: [
                        [1, 35]
                    ],
                    color: '#66bb6a'
                }
            ];

            $.plot('#flotPie1', piedata, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        innerRadius: 0.65,
                        label: {
                            show: true,
                            radius: 2 / 3,
                            threshold: 1
                        },
                        stroke: {
                            width: 0
                        }
                    }
                },
                grid: {
                    hoverable: true,
                    clickable: true
                }
            });

            // Pie chart flotPie1  End




            var cellPaiChart = [{
                    label: "Direct Sell",
                    data: [
                        [1, 65]
                    ],
                    color: '#5b83de'
                },
                {
                    label: "Channel Sell",
                    data: [
                        [1, 35]
                    ],
                    color: '#00bfa5'
                }
            ];
            $.plot('#cellPaiChart', cellPaiChart, {
                series: {
                    pie: {
                        show: true,
                        stroke: {
                            width: 0
                        }
                    }
                },
                legend: {
                    show: false
                },
                grid: {
                    hoverable: true,
                    clickable: true
                }

            });















            // Line Chart  #flotLine5
            var newCust = [
                [0, 3],
                [1, 5],
                [2, 4],
                [3, 7],
                [4, 9],
                [5, 3],
                [6, 6],
                [7, 4],
                [8, 10]
            ];

            var plot = $.plot($('#flotLine5'), [{
                data: newCust,
                label: 'New Data Flow',
                color: '#fff'
            }], {
                series: {
                    lines: {
                        show: true,
                        lineColor: '#fff',
                        lineWidth: 2
                    },
                    points: {
                        show: true,
                        fill: true,
                        fillColor: "#ffffff",
                        symbol: "circle",
                        radius: 3
                    },
                    shadowSize: 0
                },
                points: {
                    show: true,
                },
                legend: {
                    show: false
                },
                grid: {
                    show: false
                }
            });

            // Line Chart  #flotLine5 End





            // Traffic Chart using chartist
            if ($('#traffic-chart').length) {
                var chart = new Chartist.Line('#traffic-chart', {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    series: [
                        [0, 18000, 35000, 25000, 22000, 0],
                        [0, 33000, 15000, 20000, 15000, 300],
                        [0, 15000, 28000, 15000, 30000, 5000]
                    ]
                }, {
                    low: 0,
                    showArea: true,
                    showLine: false,
                    showPoint: false,
                    fullWidth: true,
                    axisX: {
                        showGrid: true
                    }
                });

                chart.on('draw', function(data) {
                    if (data.type === 'line' || data.type === 'area') {
                        data.element.animate({
                            d: {
                                begin: 2000 * data.index,
                                dur: 2000,
                                from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                                to: data.path.clone().stringify(),
                                easing: Chartist.Svg.Easing.easeOutQuint
                            }
                        });
                    }
                });
            }
            // Traffic Chart using chartist End




            //Traffic chart chart-js 
            if ($('#TrafficChart').length) {
                var ctx = document.getElementById("TrafficChart");
                ctx.height = 150;
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
                        datasets: [{
                                label: "Visit",
                                borderColor: "rgba(4, 73, 203,.09)",
                                borderWidth: "1",
                                backgroundColor: "rgba(4, 73, 203,.5)",
                                data: [0, 2900, 5000, 3300, 6000, 3250, 0]
                            },
                            {
                                label: "Bounce",
                                borderColor: "rgba(245, 23, 66, 0.9)",
                                borderWidth: "1",
                                backgroundColor: "rgba(245, 23, 66,.5)",
                                pointHighlightStroke: "rgba(245, 23, 66,.5)",
                                data: [0, 4200, 4500, 1600, 4200, 1500, 4000]
                            },
                            {
                                label: "Targeted",
                                borderColor: "rgba(40, 169, 46, 0.9)",
                                borderWidth: "1",
                                backgroundColor: "rgba(40, 169, 46, .5)",
                                pointHighlightStroke: "rgba(40, 169, 46,.5)",
                                data: [1000, 5200, 3600, 2600, 4200, 5300, 0]
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        tooltips: {
                            mode: 'index',
                            intersect: false
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        }

                    }
                });
            }
            //Traffic chart chart-js  End 



            // Bar Chart #flotBarChart
            $.plot("#flotBarChart", [{
                data: [
                    [0, 18],
                    [2, 8],
                    [4, 5],
                    [6, 13],
                    [8, 5],
                    [10, 7],
                    [12, 4],
                    [14, 6],
                    [16, 15],
                    [18, 9],
                    [20, 17],
                    [22, 7],
                    [24, 4],
                    [26, 9],
                    [28, 11]
                ],
                bars: {
                    show: true,
                    lineWidth: 0,
                    fillColor: '#ffffff8a'
                }
            }], {
                grid: {
                    show: false
                }
            });
            // Bar Chart #flotBarChart End

        }); // End of Document Ready 
    </script>
    <div id="container">
    </div>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vaafb692b2aea4879b33c060e79fe94621666317369993" integrity="sha512-0ahDYl866UMhKuYcW078ScMalXqtFJggm7TmlUtp0UlD4eQk0Ixfnm5ykXKvGJNFjLMoortdseTfsRT8oCfgGA==" data-cf-beacon='{"rayId":"7961bcc4ff39df78","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2022.11.3","si":100}' crossorigin="anonymous"></script>
</body>

<!-- Mirrored from colorlib.com/polygon/elaadmin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Feb 2023 04:49:23 GMT -->

>>>>>>> 69210baf0725d74f27ef06fbf51259d640bae072
</html>