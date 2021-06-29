<?php
class Katalog extends CI_Controller
{
	public function __construct(){
		parent:: __construct();
		$this->load->model("ProdukModel");
        $this->load->library('Cetak_pdf');
	}
    public function index()
    {
        $data["terlaris"] = $this->ProdukModel->produkTerlaris();
        $data["totalproduk"] = $this->ProdukModel->hitungProduk();
        $data["totalkategori"] = $this->ProdukModel->hitungKategori();
        $this->load->view('pages/katalog/index',$data);
    }
    public function laporanProduk(){
        $tgl1 = date("Y-m-d");
        
        $nama_file = "LAPORAN DATA PRODUK";
        $pdf = new FPDF('L', 'mm', 'Letter');

        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 7, 'LAPORAN DATA PRODUK', 0, 1, 'C');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 3, 'TANGGAL CETAK', 0, 0, 'L');
        $pdf->Cell(45, 3, ": ".$tgl1, 0, 1, 'L');
        $pdf->Cell(10, 3, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 3, 'NAMA ADMIN        ', 0, 0, 'L');
        $pdf->Cell(45, 3, ": ".strtoupper($this->session->userdata("NAMA_LENGKAP")), 0, 1, 'L');
        $pdf->Cell(10, 3, '', 0, 1);

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(80, 6, 'Nama Produk', 1, 0, 'L');
        $pdf->Cell(42, 6, 'Jumlah Transaksi', 1, 0, 'C');
        $pdf->Cell(42, 6, 'Jumlah Terjual', 1, 0, 'C');
        $pdf->Cell(60, 6, 'Peminat (Belum beli)', 1, 1, 'C');
//----------------------------------------------------------
        $pdf->SetFont('Arial', '', 10);
        $data = $this->ProdukModel->queryLaporan();
        $tTrans=0;
        $tTerjual=0;
        $tPeminat=0;
        $no = 1;
        foreach ($data as $data):
            $qCOD=0;
            $qTrans=0;
            $cod = $this->ProdukModel->getQtyCod($data["ID_PRODUK"]);
            $transfer = $this->ProdukModel->getQtyTran($data["ID_PRODUK"]);
            foreach($cod as $cod):
                $qCOD = $cod["QTY"];
            endforeach;
            foreach($transfer as $transfer):
                $qTrans = $transfer["QTY"];
            endforeach;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(80, 6, $data["NAMA_PRODUK"], 1, 0, 'L');
            $pdf->Cell(42, 6, $data["TOTAL_TRANSAKSI"], 1, 0, 'C');
            $pdf->Cell(42, 6, $qTrans+$qCOD, 1, 0, 'C');
            $pdf->Cell(60, 6, $data["PEMINAT"], 1, 1, 'C');
            $tTrans+=$data["TOTAL_TRANSAKSI"];
            $tTerjual+=$qTrans+$qCOD;
            $tPeminat+=$data["PEMINAT"];
            $no++;
        endforeach;
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(90, 6, 'JUMLAH', 1, 0, 'C');
        $pdf->Cell(42, 6, $tTrans, 1, 0, 'C');
        $pdf->Cell(42, 6, $tTerjual, 1, 0, 'C');
        $pdf->Cell(60, 6, $tPeminat, 1, 1, 'C');
        $pdf->Output($nama_file . ".pdf", "D");
    }
    public function tampilTabel(){
    	$data = $this->ProdukModel->tampilData();
    	?>
    	<!-- Page level plugins -->
    <script src="<?=base_url('assets/vendor/datatables/jquery.dataTables.min.js')?>"></script>
    <script src="<?=base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js')?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?=base_url('assets/js/demo/datatables-demo.js')?>"></script>

    	<div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Kategori</th>
                                            <th>Harga Satuan</th>
                                            <th>Harga Pokok</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php $no=1;foreach($data as $data):?>
                                        <tr>
                                            <td><?=$no;?></td>
                                            <td><?=$data['nama_produk'];?></td>
                                            <td><?=$data['nama_kategori'];?></td>
                                            <td><?="Rp ".number_format($data['harga'], 0, ".", ".");?></td>
                                            <td><?="Rp ".number_format($data['harga_pokok'], 0, ".", ".");?></td>
                                            <td>
                                                <a href="<?=base_url();?>grosir?v=<?=$data['id_produk'];?>" class="btn btn-primary btn-sm my-1" title="Settingan Produk">
                                                    <i class="fas fa-cogs"></i></a>
                                                <a class="btn btn-warning btn-sm my-1" data-toggle="modal"
                                                    data-target="#ubahProduk" id="btnUbah" value="<?=$data['id_produk'];?>" title="Edit Produk">
                                                    <i class="far fa-edit"></i></a>
                                                <a class="btn btn-danger btn-sm my-1" id="btnHapus" value="<?=$data['id_produk'];?>" title="Hapus Produk">
                                                    <i class="far fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                        <?php $no++;endforeach;?>
                                    </tbody>
                                </table>
                            </div>
    	<?php
    }
    
    public function insertData(){
        if($this->ProdukModel->inputData()){
            echo "Berhasil";
        }else{
            echo "Gagal";
        }
    }
    public function updateData(){
        if($this->ProdukModel->updateData()){
            echo "Berhasil";
        }else{
            echo "Gagal";
        }
    }
    public function hapusData(){
        $id=$this->input->post("IdMhsw");
        if($this->ProdukModel->hapusDetPenjualan($id)){
            if($this->ProdukModel->hapusGrosir($id)){
                if($this->ProdukModel->hapusProduk($id)){
                echo "Berhasil";
                }else{
                echo "Gagal";
                }
            }else{
                echo "Gagal";
            }
        }else{
            echo "Gagal";
        }
    }
    
    public function tampilDetail(){
        $id=$this->input->post("IdMhsw");
        $arr_kategori;
        $id_kat;
        $cnt = 0;
        $kategori = $this->ProdukModel->getKategori();
        $kat = $this->ProdukModel->getKategori();
        $p_kat="";
        $data = $this->ProdukModel->getById($id);
        foreach($data as $data):
            $p_kat = $data["nama_kategori"];
        ?>
        <script type="text/javascript">
            $(document).on("submit", "#updateForm", function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'Katalog/updateData',
                    type: 'post',
                    data: $(this).serialize(),
                    success: function(data) {
                        if(data=="Berhasil"){
                            $('#ubahProduk').modal('toggle'); 
                            swal("Sukses! Data berhasil diubah!", {
                            icon: "success",
                            });
                        }else{
                            $('#ubahProduk').modal('toggle'); 
                           swal("Gagal! Data gagal diubah!", {
                            icon: "error",
                            }); 
                        }
                        tampilTabel();
                    }
                });
            });
        </script>
        <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form edit produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="updateForm">
                <div class="modal-body">
                    
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nama Produk :</label>
                                    <input type="text" class="form-control" placeholder="Masukan nama produk disini..." name="nama_produk" value="<?=$data['nama_produk'];?>">
                                    <input type="hidden" name="id_produk" value="<?=$id;?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Kategori :</label>
                                    <select class="form-control" name="kategori" id="kategori">
                                        <option>Pilih</option>
                                        <?php $param_kat="";$n=0; foreach($kategori as $kategori):
                                            $param_kat = $kategori["nama_kategori"];
                                            if($param_kat == $p_kat){?>
                                                <option value="<?=$kategori['id_kategori'];?>" selected><?=$kategori["nama_kategori"];?></option>
                                            <?php }else{ ?>
                                                <option value="<?=$kategori['id_kategori'];?>"><?=$kategori["nama_kategori"];?></option>
                                        <?php }
                                        $n++;
                                    endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Harga Satuan:</label>
                                    <input type="text" class="form-control" placeholder="Masukan harga disini..." name="harga_satuan" value="<?=$data['harga'];?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Harga Pokok Penjualan:</label>
                                    <input type="text" class="form-control" placeholder="Masukan harga pokok penjualan disini..." name="hpp" value="<?=$data['harga_pokok'];?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                </div>
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </div>
                </form>
        <?php
    endforeach;
    }
  
}
?>