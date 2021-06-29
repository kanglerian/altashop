<?php
$id = $this->session->userdata("ID");
if(isset($id)==null){
  redirect('');
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
    <link href="<?=base_url();?>/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="<?=base_url();?>/assets/vendor/datatables/dataTables.bootstrap4.min.css?<?php echo time();?>" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?=base_url();?>/assets/vendor/jquery/jquery.min.js?<?php echo time();?>"></script>
    <script>
    $(document).ready(function() {
        tampilTabel();
        //---insert data--
         $(document).on("submit", "#insertForm", function(e) {
                var url = "<?=site_url('CustomerService/insertData');?>";
                e.preventDefault();
                $.ajax({
                    url: url,
                    type: 'post',
                    data: $(this).serialize(),
                    success: function(data) {
                        if(data=="Berhasil"){
                            $('#tambahCS').modal('toggle'); 
                            swal("Sukses! Data berhasil disimpan!", {
                            icon: "success",
                            });
                        }else{
                            $('#tambahCS').modal('toggle'); 
                           swal("Gagal! Data gagal disimpan!", {
                            icon: "error",
                            }); 
                        }
                        tampilTabel();
                        var myComboBox = $("#status");
                        myComboBox.prop('selectedIndex', 0);
                        document.getElementByName("nama_user").value = "";
                        document.getElementByName("username").value = "";
                        document.getElementByName("password").value = "";
                    }
                });
            });
         $("#contentTabel").on("click", "#btnHapus", function() {
                var url = "<?=site_url('CustomerService/hapusData');?>";
                var IdMhsw = $(this).attr("value");
                swal({
                title: "Apakah kamu yakin?",
                text: "Ketika data terhapus, data tidak bisa dipulihkan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        IdMhsw: IdMhsw
                    },
                    success: function(data) {
                        if(data=="Berhasil"){
                            //$('#tambahKategori').modal('toggle'); 
                            swal("Sukses! Data berhasil dihapus!", {
                            icon: "success",
                            });
                        }else{
                            //$('#tambahKategori').modal('toggle'); 
                           swal("Gagal! Data gagal dihapus!", {
                            icon: "error",
                            }); 
                        }
                        tampilTabel();
                    }
                });

                } else {
                
                }
                });
                
            });
         $("#contentTabel").on("click", "#btnUbah", function() {
                var IdMhsw = $(this).attr("value");
                var url = "<?=site_url('CustomerService/tampilDetail');?>";
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        IdMhsw: IdMhsw
                    },
                    success: function(data) {
                        $('#tampilDetail').html(data);
                    },
                    error: function(data) {
                        $('#tampilDetail').html(data);
                    }
                
                });
        });
    });
    function tampilTabel(){
        var url = "<?=site_url('Penjualan/tampilData');?>";
            $.ajax({
                url: url,
                type: 'POST',
                success: function(data) {
                    $('#contentTabel').html(data);
                }
            });
           
        }
    </script>
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

            <!-- Divider -->
            <hr class="sidebar-divider">

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
            <hr class=" sidebar-divider d-none d-md-block">

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
                    <h1 class="h3 mb-4 text-gray-800">Daftar Semua Penjualan</h1>

                    <div class="row">
                        <?php foreach($All as $All): ?>
                        <!-- Chat: Today -->
                        <div class="col-xl-3 col-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total
                                                Chat
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$All["CHAT_MASUK"];?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="far fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Chat: Today -->
                        <div class="col-xl-3 col-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total
                                                Today
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$All["TODAY"];?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="far fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Chat: Today -->
                        <div class="col-xl-3 col-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total
                                                Follow Up
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$All["FOLLOW"];?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="far fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Chat: Today -->
                        <div class="col-xl-3 col-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total
                                                Re Marketing
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$All["RE"];?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="far fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        </div>
                        <div class="card-body" id="contentTabel">
                            
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


    <!-- Delee Modal-->
    <div class="modal fade" id="hapusBeli" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title">Beneran, mau dihapus?</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-danger btn-sm">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah CS -->
    <div class="modal fade" id="tambahBeli" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form tambah penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        <div class="form-row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Chat :</label>
                                    <input type="date" class="form-control" value="<?php echo date("m/d/Y"); ?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Kontak :</label>
                                    <input type="text" class="form-control" placeholder="Isi nomor whatsapp disini..">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 ">
                                <div class="form-group">
                                    <label>Nama Produk :</label>
                                    <select class="form-control">
                                        <option selected>Pilih</option>
                                        <option>Sal chosennya wkwk</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 ">
                                <div class="form-group">
                                    <label>Chat masuk :</label>
                                    <select class="form-control">
                                        <option selected>Pilih</option>
                                        <option>Today</option>
                                        <option>Follow</option>
                                        <option>Re-marketing</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Warna :</label>
                                    <input type="text" class="form-control" placeholder="Masukan warna disini..">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Ukuran :</label>
                                    <select class="form-control">
                                        <option selected>Pilih</option>
                                        <option>XL</option>
                                        <option>L</option>
                                        <option>M</option>
                                        <option>S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Jumlah :</label>
                                    <input type="number" class="form-control" placeholder="Masukan jumlah disini..">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 ">
                                <div class="form-group">
                                    <label>Closing :</label>
                                    <select class="form-control">
                                        <option selected>Pilih</option>
                                        <option>Transfer</option>
                                        <option>COD</option>
                                        <option>Batal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah CS -->
    <div class="modal fade" id="editBeli" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form edit penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        <div class="form-row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Tanggal :</label>
                                    <input type="date" class="form-control" value="<?=date("m/d/Y");?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Kontak :</label>
                                    <input type="text" class="form-control" value="6281286501015">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 ">
                                <div class="form-group">
                                    <label>Nama Produk :</label>
                                    <select class="form-control">
                                        <option selected>Sal chosennya wkwk</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 ">
                                <div class="form-group">
                                    <label>Chat masuk :</label>
                                    <select class="form-control">
                                        <option selected>Today</option>
                                        <option>Follow</option>
                                        <option>Re-marketing</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Warna :</label>
                                    <input type="text" class="form-control" value="Merah">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Ukuran :</label>
                                    <select class="form-control">
                                        <option>XL</option>
                                        <option selected>L</option>
                                        <option>M</option>
                                        <option>S</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Jumlah :</label>
                                    <input type="number" class="form-control" value="2">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 ">
                                <div class="form-group">
                                    <label>Closing :</label>
                                    <select class="form-control">
                                        <option selected>Transfer</option>
                                        <option>COD</option>
                                        <option>Batal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
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

</body>

</html>