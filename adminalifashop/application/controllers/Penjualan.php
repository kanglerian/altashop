<?php
class Penjualan extends CI_Controller
{
	public function __construct(){
		parent:: __construct();
		$this->load->model("PenjualanModel");
		$this->load->library('Cetak_pdf');
	}

    public function index()
    {
        $data["All"] = $this->PenjualanModel->getDetailHeader();
        $this->load->view('pages/penjualan/index',$data);
    }
    public function laporanPenjualan(){
    	$tgl1 = $this->input->get("tgl1");
        $tgl2 = $this->input->get("tgl2");
        list($cs,$nama_cs)   = explode("-", $this->input->get("cs"));
        list($kat,$nama_kategori) =explode("-", $this->input->get("kategori"));
        $data;
        if(empty($cs) && empty($kat)){
        	$nama_cs = "SEMUA CUSTOMER SERVICE";
        	$nama_kategori = "SEMUA KATEGORI";
        	$data = $this->PenjualanModel->queryLaporan($tgl1,$tgl2);
        }else if(!empty($cs) && empty($kat)){
        	$nama_kategori = "SEMUA KATEGORI";
        	$data = $this->PenjualanModel->laporanCs($cs,$tgl1,$tgl2);
        }else if(empty($cs) && !empty($kat)){
        	$nama_cs = "SEMUA CUSTOMER SERVICE";
        	$data = $this->PenjualanModel->laporanKategori($kat,$tgl1,$tgl2);
        }else{
        	$data = $this->PenjualanModel->laporanAll($kat,$cs,$tgl1,$tgl2);
        }
        
        $totalQty=0;
        $totalHarga=0;
        $totalPendapatan=0;
        $totalHpp=0;
        $totalPHpp=0;
        $totalMargin=0;

        $nama_file = "LAPORAN RINCIAN PENJUALAN_".$tgl1." SAMPAI ".$tgl2;
        $pdf = new FPDF('L', 'mm', 'Letter');

        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 7, 'LAPORAN RINCIAN PENJUALAN', 0, 1, 'C');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 3, 'TANGGAL        ', 0, 0, 'L');
        $pdf->Cell(45, 3, ": ".$tgl1." SAMPAI ".$tgl2, 0, 1, 'L');
        $pdf->Cell(10, 3, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 3, 'KATEGORI        ', 0, 0, 'L');
        $pdf->Cell(45, 3, ": ".strtoupper($nama_kategori), 0, 1, 'L');
        $pdf->Cell(10, 3, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 3, 'NAMA CS        ', 0, 0, 'L');
        $pdf->Cell(45, 3, ": ".strtoupper($nama_cs), 0, 1, 'L');
        $pdf->Cell(10, 7, '', 0, 1);

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Nama Barang', 1, 0, 'L');
        $pdf->Cell(35, 6, 'Kategori', 1, 0, 'C');
        $pdf->Cell(15, 6, 'QTY', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Harga Jual', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Pendapatan', 1, 0, 'C');
        $pdf->Cell(30, 6, 'HPP', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Total HPP', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Margin', 1, 1, 'C');
//----------------------------------------------------------
        $pdf->SetFont('Arial', '', 9);
        
        $no = 1;
        foreach ($data as $data):
        	$qJual = $data["QTY"];
        	$qGrosir;
        	$hJual=0;
        	$hGrosir;
        	$grosir = $this->PenjualanModel->getGrosir($data["ID_PRODUK"]);
        	$n=0;
        	$paramG = count($grosir);
        	if($paramG == NULL || $paramG == 0 || $paramG == "0"){
        		$hJual = $data["HARGA_SATUAN"];
        	}else{
        		foreach($grosir as $grosir):
        			if($grosir["qty"] == 1 || $grosir["qty"] == "1"){
        				$hJual = $grosir["harga"];
        			}else{
        				if($qJual>=$grosir["qty"]){
        					$hJual = $grosir["harga"];
        				}else if($qJual == 1 || $qJual == "1"){
        					$hJual = $data["HARGA_SATUAN"];
        				}
        			}
        		endforeach;
        	}
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(50, 6, $data["PRODUK"], 1, 0, 'L');
        	$pdf->Cell(35, 6, $data["KATEGORI"], 1, 0, 'C');
        	$pdf->Cell(15, 6, $data["QTY"], 1, 0, 'C');
        	$pdf->Cell(30, 6, "Rp ".number_format($hJual, 0, ".", "."), 1, 0, 'C');
        	$pdf->Cell(30, 6, "Rp ".number_format($data["QTY"]*$hJual, 0, ".", "."), 1, 0, 'C');
        	$pdf->Cell(30, 6, "Rp ".number_format($data["HPP"], 0, ".", "."), 1, 0, 'C');
        	$pdf->Cell(30, 6, "Rp ".number_format($data["QTY"]*$data["HPP"], 0, ".", "."), 1, 0, 'C');
        	$pdf->Cell(30, 6, "Rp ".number_format(($data["QTY"]*$hJual)-($data["QTY"]*$data["HPP"]), 0, ".", "."), 1, 1, 'C');
        	$totalQty+=$data["QTY"];
        	$totalHarga+=$hJual;
        	$totalPendapatan+=$data["QTY"]*$hJual;
        	$totalHpp+=$data["HPP"];
        	$totalPHpp+=$data["QTY"]*$data["HPP"];
        	$totalMargin+=($data["QTY"]*$hJual)-($data["QTY"]*$data["HPP"]);
            $no++;
        endforeach;
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(95, 6, 'JUMLAH', 1, 0, 'C');
        $pdf->Cell(15, 6, $totalQty, 1, 0, 'C');
        $pdf->Cell(30, 6, "Rp ".number_format($totalHarga, 0, ".", "."), 1, 0, 'C');
        $pdf->Cell(30, 6, "Rp ".number_format($totalPendapatan, 0, ".", "."), 1, 0, 'C');
        $pdf->Cell(30, 6, "Rp ".number_format($totalHpp, 0, ".", "."), 1, 0, 'C');
        $pdf->Cell(30, 6, "Rp ".number_format($totalPHpp, 0, ".", "."), 1, 0, 'C');
        $pdf->Cell(30, 6, "Rp ".number_format($totalMargin, 0, ".", "."), 1, 1, 'C');
        $pdf->Output($nama_file . ".pdf", "D");
    }
    public function tampilData(){
    	$data = $this->PenjualanModel->showData();
    	$kategori = $this->PenjualanModel->getKategori();
    	$cs = $this->PenjualanModel->getCustomer();
    	?>
    	<script src="<?=base_url('assets/vendor/datatables/jquery.dataTables.min.js')?>"></script>
    	<script src="<?=base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js')?>"></script>
    	<!-- Page level custom scripts -->
    	<script src="<?=base_url('assets/js/demo/datatables-demo.js')?>"></script>
    	<div class="table-responsive">
    		<form action="<?=site_url('Penjualan/laporanPenjualan');?>" method="GET">
                                <div class="form-row align-items-right mb-2">
                                	
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <input type="date" class="form-control" name="tgl1" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <input type="date" class="form-control" name="tgl2" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" name="cs">
                                                <option value="" selected>Semua CS</option>
                                                <?php foreach($cs as $cs):?>
                                                	<option value="<?=$cs['id_user'].'-'.$cs['nama_user'];?>"><?=$cs["nama_user"];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <select class="form-control" name="kategori">
                                                <option value="" selected>Semua Kategori</option>
                                                <?php foreach($kategori as $kategori):?>
                                                	<option value="<?=$kategori['id_kategori'].'-'.$kategori['nama_kategori'];?>"><?=$kategori["nama_kategori"];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-1">
                                        <button type="submit" class="btn btn-info mb-2 btn-block"><i class="fas fa-print"></i></button>
                                    </div>
                                
                                </div>
                                </form>
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Trx.</th>
                                            <th>Nama CS</th>
                                            <th>Produk</th>
                                            <th>Chat</th>
                                            <th>Closing</th>
                                            <th>Keterangan</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php $no=1;foreach($data as $data):
                                    	$badge1="";
                                    	$badge2="";
                                    	if($data["CHAT"]=="Today"){
                                    		$badge1="badge-success";
                                    	}else if($data["CHAT"]=="Follow Up"){
                                    		$badge1="badge-warning";
                                    	}else if($data["CHAT"]=="Re-marketing"){
                                    		$badge1="badge-danger";
                                    	}
                                    	if($data["CLOSING"]=="COD"){
                                    		$badge2="badge-success";
                                    	}else if($data["CLOSING"]=="Transfer"){
                                    		$badge2="badge-warning";
                                    	}else if($data["CLOSING"]=="Batal"){
                                    		$badge2="badge-danger";
                                    	}
                                    	?>
                                        <tr>
                                            <td><?=$no;?></td>
                                            <td><?=$data["TANGGAL"];?></td>
                                            <td><?=$data["NAMA_USER"];?></td>
                                            <td><?=$data["PRODUK"];?></td>
                                            <td>
                                                <span class="badge <?=$badge1;?>"><?=$data["CHAT"];?></span>
                                            </td>
                                            <td>
                                                <span class="badge <?=$badge2;?>"><?=$data["CLOSING"];?><span>
                                            </td>
                                            <td><?=$data["KETERANGAN"];?></td>
                                            <td><?=$data["JUMLAH"];?></td>
                                        </tr>
                                    <?php $no++;endforeach;?>
                                    </tbody>
                                </table>
                            </div>
    	<?php
    }

}
?>