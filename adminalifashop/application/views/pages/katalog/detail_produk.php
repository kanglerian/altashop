<?php
$id = $this->session->userdata("ID");
if(isset($id)==null){
  redirect('');
}
?>
<?php 
$id = $this->input->get("v");
$nama_produk="";
$harga_jual = 0;
$harga_pokok = 0;
foreach($pr as $pr):
    $nama_produk=$pr["nama_produk"];
    $harga_pokok=$pr["harga_pokok"];
    $harga_jual=$pr["harga"];
    endforeach;
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
                e.preventDefault();
                $.ajax({
                    url: 'Grosir/insertData',
                    type: 'post',
                    data: $(this).serialize(),
                    success: function(data) {
                        if(data=="Berhasil"){
                            $('#tambahGrosir').modal('toggle'); 
                            swal("Sukses! Data berhasil disimpan!", {
                            icon: "success",
                            });
                        }else{
                            $('#tambahGrosir').modal('toggle'); 
                           swal("Gagal! Data gagal disimpan!", {
                            icon: "error",
                            }); 
                        }
                        tampilTabel();
                        document.getElementById("nama_produk").value = "";
                        document.getElementById("harga_satuan").value = "";
                    }
                });
            });
         $("#contentTabel").on("click", "#btnHapus", function() {
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
                    url: 'Grosir/hapusData',
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
                var url = "<?=site_url('Grosir/tampilDetail');?>";
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
        var IdMhsw = <?=$id;?>;
            $.ajax({
                url: 'Grosir/tampilData',
                type: 'get',
                data: {
                        IdMhsw: IdMhsw
                    },
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
                    <h1 class="h3 mb-4 text-gray-800">Detail Harga Produk <?=$nama_produk;?></h1>
                    
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-12">
                                <label for="inputEmail4">Harga Satuan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Rp0" value="<?='Rp '.number_format($harga_jual, 0, '.', '.');?>" disabled>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="inputEmail4">Harga Pokok Penjualan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Rp0" value="<?='Rp '.number_format($harga_pokok, 0, '.', '.');?>" disabled>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="card my-2">
                        <div class="card-header py-3">
                            <a href="<?=base_url();?>katalog" class="btn btn-light btn-sm my-1"><i class="fas fa-chevron-left"></i></a>
                            <a href="#" class="btn btn-primary btn-sm my-1" data-toggle="modal" data-target="#tambahGrosir"><i
                                    class="fas fa-plus"></i> Tambah Harga Grosir</a>
                           
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
                        <span>Copyright &copy; Alta Shop 2021</span>
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
    <div class="modal fade" id="hapusGrosir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
    
    <!-- Modal Tambah Grosir -->
    <div class="modal fade" id="tambahGrosir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Harga Grosir: <?=$nama_produk;?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="insertForm" method="post">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                
                                  <div class="row">
                                    <div class="col-md-6 col-12">
                                      <div class="form-group">
                                          <label>Jumlah min:</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">≥</span>
                                              </div>
                                              <input type="text" class="form-control" placeholder="Jumlah order" name="qty" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                              <input type="hidden" name="id_produk" value="<?=$id;?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                      <div class="form-group">
                                          <label>Harga Grosir:</label>
                                            <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                              </div>
                                              <input type="text" class="form-control" placeholder="Rp0" name="harga" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal Edit Grosir -->
    <div class="modal fade" id="editGrosir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="tampilDetail">
                
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