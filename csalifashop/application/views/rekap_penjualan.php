
<?php
error_reporting(0);
$id = $this->session->userdata("ID");
if(isset($id)==null){
  redirect('login');
}
$this->load->model("PenjualanModel");
$kat = $this->PenjualanModel->getKategori();
$k = $this->input->get("k");
$produk =$this->PenjualanModel->getProduk($k);
$getChat  = $this->PenjualanModel->getChat($id_faktur);
?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Alta Shop - Dashboard</title>
 <link rel="stylesheet" href="<?=base_url();?>/assets/component-chosen.css">
  
    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css');?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/css/sb-admin-2.min.css');?>" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css')?>" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="<?=base_url();?>/assets/docsupport/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script src="<?=base_url();?>/assets/chosen.jquery.js?<?php echo time();?>" type="text/javascript"></script>
<script>
    
      $(function() {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
        //$('.chosen-container').css({ 'width':'auto !important' });
        
      });
      $(document).ready(function(){
        $("#contentTabel").on("click", "#btnEdit", function() {
                var IdMhsw = $(this).attr("value");
                $.ajax({
                    url: 'Rekap/tampilDetail',
                    type: 'post',
                    data: {
                        IdMhsw: IdMhsw
                    },
                    success: function(data) {
                        $('#tampilDetail').html(data);
                    }
                });
            });
        $("#contentTabel").on("click", "#btnHapus", function() {
                var IdMhsw = $(this).attr("value");
                swal({
                title: "Apakah kamu yakin?",
                text: "Ketika terhapus, data tidak bisa dipulihkan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                $.ajax({
                    url: 'Rekap/hapusData',
                    type: 'post',
                    data: {
                        IdMhsw: IdMhsw
                    },
                    success: function(data) {
                        window.location = "<?=site_url('penjualan?k='.$k);?>";
                    }
                });
                swal("Sukses! Data berhasil dihapus!", {
                icon: "success",
                });

                } else {
                
                }
                });
                
            });

      });

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
                <div class="sidebar-brand-text mx-3">Alta Shop</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Katalog
            </div>

            <!-- Nav Item - Pages Collapsea Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-cart-plus"></i>
                    <span>Penjualan</span>
                </a>
                <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu Penjualan:</h6>
                        <?php foreach($kat as $kat):?>
                        <a class="collapse-item" href="<?=base_url();?>penjualan?k=<?=$kat['nama_kategori'];?>"><?=$kat['nama_kategori'];?></a>
                    <?php endforeach;?>
                    </div>
                </div>
            </li>

           <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Laporan
            </div>

            <!-- Nav Item - Pages Collapsea Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="far fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu:</h6>
                        <a class="collapse-item" href="<?=base_url();?>transaksi/">Laporan Transaksi</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <p class="text-center mb-2"><strong>Peringatan!</strong> jangan lupa update informasi hariannya</p>
                <a class="btn btn-success btn-sm" href="<?= base_url();?>/belanja">Perbarui</a>
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
                                <a class="dropdown-item text-center small text-gray-500" href="#">Lihat semua pemberitahuan</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=$this->session->userdata("NAMA_LENGKAP");?></span>
                                <img class="img-profile rounded-circle" src="<?= base_url('assets/img/undraw_profile.svg');?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?=site_url('Login/logout');?>">
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
<?php


?>
<h1 class="h3 mb-4 text-gray-800">No Rec : <?=$id_faktur;?></h1>

<div class="row">
    <!-- Chat: Today -->
    <?php 
    $total_batal = "";
    foreach($detTran as $detTran):
            $total_closing = $detTran["cod"]+$detTran["transfer"];
            $closing_rate = $total_closing*100/$detTran["total_chat"];
            $total_batal = $detTran["total_batal"];
        ?>
    <div class="col-xl-3 col-12 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total
                            Chat
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$detTran["total_chat"];?></div>
                    </div>
                    <div class="col-auto">
                        <i class="far fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php foreach($getChat as $getChat):?>
    <div class="col-xl-3 col-12 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total
                            Chat Today
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$getChat["CHAT_TODAY"];?></div>
                    </div>
                    <div class="col-auto">
                        <i class="far fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-12 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total
                            Chat Follow Up
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$getChat["CHAT_FOLLOW"];?></div>
                    </div>
                    <div class="col-auto">
                        <i class="far fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-12 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total
                            Chat Remarketing
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$getChat["CHAT_RE"];?></div>
                    </div>
                    <div class="col-auto">
                        <i class="far fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach;?>
    <!-- Chat: Today -->
    <div class="col-xl-6 col-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Closing
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$total_closing;?></div>
                    </div>
                    <div class="col-auto">
                        <i class="far fa-credit-card fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Chat: Today -->
    <div class="col-xl-6 col-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Closing Rate
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?=round($closing_rate);?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-percent fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach;?>
</div>

<div class="row">
    <div class="col-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Informasi!</strong> Closing transaksi pada hari ini berakhir pada pukul pukul 22.00 waktu setempat.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
        if($total_batal==0){

        }else{
            ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Informasi!</strong> Anda memiliki <?=$total_batal;?> chat yang belum closing.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <?php
        }
        ?>
        
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="#" class="btn btn-info btn-sm" data-toggle="modal"
            data-target="#tambahPembelian"><i class="fas fa-plus"></i> Tambah</a>
        <a href="<?=site_url('Rekap/cetakLaporan?id='.$id_faktur."&tgl=".date("Y-m-d"));?>" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-print"></i> Cetak (.pdf)</a>

    </div>
    <div class="card-body">
        <div class="table-responsive" id="contentTabel">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Chat</th>
                        <th>Closing</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no=1;
                    $badge1="";
                    $badge2="";
                    $txt_cls = "";
                    foreach($tampil as $tampil):
                        if($tampil["chat_masuk"]=="Today"){
                            $badge1="badge-success";
                        }else if($tampil["chat_masuk"]=="Follow Up"){
                            $badge1="badge-warning";
                        }else if($tampil["chat_masuk"]=="Re-marketing"){
                            $badge1="badge-danger";
                        }
                        if($tampil["closing"]=="Transfer"){
                            $badge2="badge-success";
                            $txt_cls="Today";
                        }else if($tampil["closing"]=="COD"){
                            $badge2="badge-warning";
                            $txt_cls="COD";
                        }else if($tampil["closing"]=="Batal"){
                            $badge2="badge-danger";
                            $txt_cls="Belum Closing";
                        }
                    ?>
                    <tr>
                        <td><?=$no;?></td>
                        <td><?=$tampil["nama_produk"];?></td>
                        <td>
                            <span class="badge <?=$badge1;?>"><?=$tampil["chat_masuk"];?></span>
                        </td>
                        <td>
                            <span class="badge <?=$badge2;?>"><?=$txt_cls;?><span>
                        </td>
                        <td><?=$tampil["jumlah"];?></td>
                        <td><?=$tampil["keterangan"];?></td>
                        <td>
                            <a class="btn btn-warning btn-sm" data-toggle="modal"
                                data-target="#editPembelian" id="btnEdit" value="<?=$tampil["id_det_penjualan"];?>-<?=$tampil["nama_kategori"];?>">
                                <i class="far fa-edit"></i></a>
                            <a class="btn btn-danger btn-sm"  id="btnHapus" value="<?=$tampil["id_det_penjualan"];?>">
                                <i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
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

    <!-- Modal Tambah Pembelian -->
    <div class="modal fade" id="tambahPembelian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form tambah pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?=site_url('Rekap/insertData');?>" method="POST">
                <div class="modal-body">
                    
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tanggal Chat :</label>
                                    <input type="hidden" name="id_penjualan" value="<?=$id_faktur;?>">
                                    <input type="date" class="form-control datepicker" id="myDate" value="<?=date('Y-m-d');?>" name="tgl_chat" required>
                                    <input type="hidden" name="ket" value="<?=$k;?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nama Produk :</label><br>
                                    <select data-placeholder="Choose a Country..." class="chosen-select" id="sort-order" name="produk" required>
                                        <option value=""></option>
                                        <option selected="selected">Pilih Produk</option>
                                        <?php foreach($produk as $produk):?>    
                                        <option value="<?=$produk['id_produk'];?>"><?=$produk["nama_produk"];?></option>
                                    <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Chat masuk :</label>
                                    <select class="form-control" name="chat_masuk" required>
                                        <option value="" selected>Pilih</option>
                                        <option value="Today">Today</option>
                                        <option value="Follow Up">Follow Up</option>
                                        <option value="Re-marketing">Re-marketing</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-8">
                                <div class="form-group">
                                    <label>Catatan :</label>
                                    <input type="text" class="form-control" placeholder="Masukan catatan.." name="keterangan">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Jumlah :</label>
                                    <input type="number" class="form-control" placeholder="Contoh: 4" name="jumlah" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Closing :</label>
                                    <select class="form-control" name="closing" required>
                                        <option value="" selected>Pilih</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="COD">COD</option>
                                        <option value="Batal">Belum Closing</option>
                                    </select>
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

    <!-- Modal Edit Pembelian -->
    <div class="modal fade" id="editPembelian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document" id="tampilDetail">
            
        </div>
    </div>

    <!-- Delee Modal-->
    <div class="modal fade" id="hapusPembelian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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

    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="tambahProduk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form tambah produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>ID Produk :</label>
                                    <input type="text" class="form-control" placeholder="Masukan ID product disini...">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nama Produk :</label>
                                    <input type="text" class="form-control" placeholder="Masukan nama produk disini...">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Kategori :</label>
                                    <select class="form-control">
                                        <option selected>Pilih</option>
                                        <option value="Hijab">Hijab</option>
                                        <option value="Buku">Buku</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Harga :</label>
                                    <input type="text" class="form-control" placeholder="Masukan harga disini...">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Stok Produk :</label>
                                    <input type="number" class="form-control" placeholder="Masukan stok disini...">
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
    
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js')?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/js/sb-admin-2.min.js')?>"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js')?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('assets/js/demo/datatables-demo.js')?>"></script>
    
 


</body>

</html>