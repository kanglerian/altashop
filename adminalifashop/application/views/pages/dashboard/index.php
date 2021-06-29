<?php
$id = $this->session->userdata("ID");
if(isset($id)==null){
  redirect('');
}
?>
<?php
    //Inisialisasi nilai variabel awal
    $arr_label = array("","","");
    $nom=0;
    $nama_jurusan= "";
    $jumlah=null;
    foreach ($chartPie as $chartPie):
        $arr_label[$nom] = $chartPie["NAMA_KATEGORI"];
        $jur=$chartPie["NAMA_KATEGORI"];
        $nama_jurusan .= "'$jur'". ", ";
        $jum=$chartPie["TOTAL_TRANSAKSI"];
        $jumlah .= "$jum". ", ";
        $nom++;
    endforeach;
    ?>
<?php 
$this->load->model("DashboardModel");
$tampilData = $this->DashboardModel->tampilData();
$tanggal_sekarang = date("Y-m-d");
list($a,$b,$c) = explode("-", $tanggal_sekarang);
$nama_bulan="";
$jumlah_penjualan = null;
$array_bulan = array("","","","","","");
$array_totalP = array("","","","","","");
$x=1;
while ($x<=5) {
    $tr=0;
    $bul="";
    $total=0;
    $cd=0;
    if($b == 0 || $b == NULL || $b == "0"){
        $b=12;
    }
    $bul = date('F', mktime(0, 0, 0, $b, 10));
    $array_bulan[$x] = $bul; 
    
    $cod = $this->DashboardModel->statistikCOD($b);
    $tran = $this->DashboardModel->statistikTran($b);
    foreach($cod as $cod):
        $cd = $cod["Jumlah"];
    endforeach;
    foreach($tran as $tran):
        $tr = $tran["Jumlah"];
    endforeach;
    $total = $tr+$cd;
    $array_totalP[$x] = $total;
    
    $b-=1;
    $x++;
}
$x2=5;
while($x2>=1){
    $nama_bulan .= "'$array_bulan[$x2]'". ", ";
    $jumlah_penjualan .= "$array_totalP[$x2]". ", ";
    $x2--;
}
 ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Alifa Shop - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="<?=base_url('assets/vendor/fontawesome-free/css/all.min.css');?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?=base_url('assets/css/sb-admin-2.min.css');?>" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="<?=base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css')?>" rel="stylesheet">
    <script src="<?=base_url('assets/vendor/chart.js/Chart.min.js')?>"></script>
    <script src="<?=base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
    
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Alifa Shop</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?=base_url();?>dashboard/">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Katalog
            </div>

            <!-- Nav Item - Pages Collapsea Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKatalog"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-store"></i>
                    <span>Daftar Barang</span>
                </a>
                <div id="collapseKatalog" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu Katalog:</h6>
                        <a class="collapse-item" href="<?=base_url();?>katalog">Katalog</a>
                        <a class="collapse-item" href="<?=base_url();?>kategori">Kategori</a>
                    </div>
                </div>
            </li>

            <!-- Heading -->
            <div class="sidebar-heading">
                Pengguna
            </div>

            <!-- Nav Item - Pages Collapsea Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#customerService"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-users"></i>
                    <span>Pengguna</span>
                </a>
                <div id="customerService" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu pengguna:</h6>
                        <a class="collapse-item" href="<?=base_url();?>CustomerService/">Daftar pengguna</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Penjualan
            </div>

            <!-- Nav Item - Pages Collapsea Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#penjualan"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-users"></i>
                    <span>Penjualan</span>
                </a>
                <div id="penjualan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu Penjualan:</h6>
                        <a class="collapse-item" href="<?=base_url();?>transaksi/">Data Master Transaksi</a>
                        <a class="collapse-item" href="<?=base_url();?>penjualan/">Data Master Penjualan</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">1+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Informasi terbaru
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-info">
                                            <i class="fas fa-shopping-bag text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="font-weight-bold">Produk baru, Hijab Suneo</span>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Lihat semua
                                    pemberitahuan</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=$this->session->userdata("NAMA_LENGKAP");?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?=base_url('assets/img/undraw_profile.svg');?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?=site_url('Auth/logout');?>">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <?php foreach($allclosing as $allclosing):?>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total
                                                Chat Bulan Ini</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$allclosing["TOTAL_CHAT"];?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Total Closing Bulan Ini</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$allclosing["TOTAL_CLOSING"];?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                CS Terbaik Bulan Ini</div>
                                                <?php foreach($csterbaik as $csterbaik):?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$csterbaik["NAMA_USER"];?>
                                            </div>
                                            <?php endforeach;?>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-medal fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <?php foreach($jumlahcs as $jumlahcs):?>
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Jumlah CS</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$jumlahcs["JUMLAH"];?></div>
                                        </div>
                                        <?php endforeach;?>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="card shadow mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary"> <span
                                            class="badge badge-info">4</span> Transaksi hari ini
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Transaksi</th>
                                                    <th>Total Chat</th>
                                                    <th>Total Closing</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $nomor=1;foreach($tampilData as $tampilData):?>
                                                <tr>
                                                    <td><?=$nomor;?></td>
                                                    <td>
                                                        <?=$tampilData["NO_REC"];?>
                                                    </td>
                                                    <td><?=$tampilData["TOTAL_CHAT"];?></td>
                                                    <td><?=$tampilData["TOTAL_CLOSING"];?></td>
                                                    <td>
                                                        <a href="<?=site_url('Transaksi/cetakLaporan?id='.$tampilData['NO_REC'].'&tgl='.$tampilData['TGL'].'&nama='.$tampilData['NAMA_USER']);?>" class="btn btn-info btn-sm" target="_blank"><i class="fas fa-print"></i></a>
                                                    </td>
                                                </tr>
                                                <?php $nomor++; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Kategori terlaris</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> <?=$arr_label[0];?>
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> <?=$arr_label[1];?>
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> <?=$arr_label[2];?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Statistik Closing</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin untuk keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Jika sudah, maka tinggal klik saja tombol "keluar"</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="login.html">Keluar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    
    <script src="<?=base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=base_url('assets/vendor/jquery-easing/jquery.easing.min.js')?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=base_url('assets/js/sb-admin-2.min.js')?>"></script>

    <!-- Page level plugins -->
    <script src="<?=base_url('assets/vendor/datatables/jquery.dataTables.min.js')?>"></script>
    <script src="<?=base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js')?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?=base_url('assets/js/demo/datatables-demo.js')?>"></script>
    <script type="text/javascript">
        // Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: [<?php echo $nama_jurusan; ?>],
    datasets: [{
      data: [<?php echo $jumlah; ?>],
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});

    </script>

    <!-- Page level plugins -->
 <script type="text/javascript">
     // Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: [<?php echo $nama_bulan; ?>],
    datasets: [{
      label: "Closing ",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [<?php echo $jumlah_penjualan; ?>],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
});

 </script>   

    <!-- Page level custom scripts -->

</body>

</html>