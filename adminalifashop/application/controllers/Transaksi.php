<?php
class Transaksi extends CI_Controller
{
	public function __construct(){
		parent:: __construct();
		$this->load->model("TransaksiModel");
		$this->load->library('Cetak_pdf');
	}
    public function index()
    {
        $data["tmpl"]=$this->TransaksiModel->getTransaksi();
        $this->load->view('pages/transaksi/index',$data);
    }
    public function showData(){
    	$data = $this->TransaksiModel->tampilData();
    	?>
    	<script src="<?=base_url('assets/vendor/datatables/jquery.dataTables.min.js')?>"></script>
    	<script src="<?=base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js')?>"></script>
    	<!-- Page level custom scripts -->
    	<script src="<?=base_url('assets/js/demo/datatables-demo.js')?>"></script>
 		<div class="table-responsive">
 								<form action="<?=site_url('Transaksi/cetakLaporanTanggal');?>" method="GET">
                                <div class="form-row align-items-right mb-2">
                                    <div class="col-12 col-md-5">
                                        <div class="form-group">
                                            <input type="date" class="form-control" name="tgl1">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <div class="form-group">
                                            <input type="date" class="form-control" name="tgl2">
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
                                            <th>Tanggal</th>
                                            <th>Transaksi</th>
                                            <th>Nama CS</th>
                                            <th>Total Chat Masuk</th>
                                            <th>Total Closing</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php $no=1;foreach($data as $data):
                                    	?>
                                        <tr>
                                            <td><?=$no;?></td>
                                            <td><?=$data["TGL"];?></td>
                                            <td><?=$data["NO_REC"];?></td>
                                            <td><?=$data["NAMA_USER"];?></td>
                                            <td><?=$data["TOTAL_CHAT"];?></td>
                                            <td><?=$data["TOTAL_CLOSING"];?></td>
                                            <td>
                                                <a href="<?=site_url('Transaksi/cetakLaporan?id='.$data['NO_REC'].'&tgl='.$data['TGL'].'&nama='.$data['NAMA_USER']);?>" class="btn btn-info btn-sm" target="_blank"><i class="fas fa-print"></i></a>
                                        </tr>
                                        <?php $no++; endforeach;?>
                                    </tbody>
                                </table>
                            </div>
    	<?php
    }
    public function cetakLaporan()
    {
        $id = $this->input->get("id");
        $tanggal = $this->input->get("tgl");
        $nama_file = "LAPORAN PENJUALAN_" . $tanggal . "_" . strtoupper($this->input->get("nama"));
        $pdf = new FPDF('L', 'mm', 'Letter');

        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 7, 'LAPORAN PENJUALAN', 0, 1, 'C');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 3, 'TANGGAL        ', 0, 0, 'L');
        $pdf->Cell(45, 3, ": " . $tanggal, 0, 1, 'L');
        $pdf->Cell(10, 3, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 3, 'ID TRANSAKSI', 0, 0, 'L');
        $pdf->Cell(45, 3, ": " . $id, 0, 1, 'L');
        $pdf->Cell(10, 3, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 3, 'NAMA CS        ', 0, 0, 'L');
        $pdf->Cell(45, 3, ": " . strtoupper($this->input->get("nama")), 0, 1, 'L');
        $pdf->Cell(10, 7, '', 0, 1);

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(10, 12, 'No', 1, 0, 'C');
        $pdf->Cell(80, 12, 'Nama Barang', 1, 0, 'L');
        $pdf->Cell(42, 6, 'Today', 1, 0, 'C');
        $pdf->Cell(42, 6, 'Follow Up', 1, 0, 'C');
        $pdf->Cell(42, 6, 'Re-marketing', 1, 0, 'C');
        $pdf->Cell(42, 6, 'Total', 1, 1, 'C');

        $pdf->SetFont('Arial', 'B', 9);

        $pdf->Cell(10, 6, '', 0, 0);
        $pdf->Cell(80, 6, '', 0, 0);
        $pdf->Cell(14, 6, 'Chat', 1, 0, 'C');
        $pdf->Cell(14, 6, 'COD', 1, 0, 'C');
        $pdf->Cell(14, 6, 'Transfer', 1, 0, 'C');
        $pdf->Cell(14, 6, 'Chat', 1, 0, 'C');
        $pdf->Cell(14, 6, 'COD', 1, 0, 'C');
        $pdf->Cell(14, 6, 'Transfer', 1, 0, 'C');
        $pdf->Cell(14, 6, 'Chat', 1, 0, 'C');
        $pdf->Cell(14, 6, 'COD', 1, 0, 'C');
        $pdf->Cell(14, 6, 'Transfer', 1, 0, 'C');
        $pdf->Cell(14, 6, 'Chat', 1, 0, 'C');
        $pdf->Cell(14, 6, 'COD', 1, 0, 'C');
        $pdf->Cell(14, 6, 'Transfer', 1, 1, 'C');
//----------------------------------------------------------
        $pdf->SetFont('Arial', '', 9);
        $data = $this->TransaksiModel->queryLaporan($id);
        $no = 1;
        foreach ($data as $data):
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(80, 6, $data["PRODUK"], 1, 0);
            $pdf->Cell(14, 6, $data["CHAT_TODAY"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["COD_TODAY"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["TRANSFER_TODAY"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["CHAT_FOLLOW"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["COD_FOLLOW"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["TRANSFER_FOLLOW"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["CHAT_RE"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["COD_RE"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["TRANSFER_RE"], 1, 0, 'C');
            $pdf->Cell(14, 6, ($data["CHAT_RE"] + $data["CHAT_FOLLOW"] + $data["CHAT_TODAY"]), 1, 0, 'C');
            $pdf->Cell(14, 6, ($data["COD_RE"] + $data["COD_FOLLOW"] + $data["COD_TODAY"]), 1, 0, 'C');
            $pdf->Cell(14, 6, ($data["TRANSFER_RE"] + $data["TRANSFER_FOLLOW"] + $data["TRANSFER_TODAY"]), 1, 1, 'C');
            $no++;
        endforeach;
        $pdf->Output($nama_file . ".pdf", "D");
    }
    public function cetakLaporanTanggal(){
    	$tgl1 = $this->input->get("tgl1");
        $tgl2 = $this->input->get("tgl2");
        $nama_file = "LAPORAN PENJUALAN_" . $tgl1 . "s/d" . $tgl2;
        $pdf = new FPDF('L', 'mm', 'Letter');

        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 7, 'LAPORAN PENJUALAN', 0, 1, 'C');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 3, 'TANGGAL        ', 0, 0, 'L');
        $pdf->Cell(45, 3, ": " . $tgl1 . " s/d " . $tgl2, 0, 1, 'L');
        $pdf->Cell(10, 3, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 3, 'ID TRANSAKSI', 0, 0, 'L');
        $pdf->Cell(45, 3, ": SEMUA TRANSAKSI", 0, 1, 'L');
        $pdf->Cell(10, 3, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(45, 3, 'NAMA CS        ', 0, 0, 'L');
        $pdf->Cell(45, 3, ": SEMUA CUSTOMER SERVICE", 0, 1, 'L');
        $pdf->Cell(10, 7, '', 0, 1);

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(10, 12, 'No', 1, 0, 'C');
        $pdf->Cell(80, 12, 'Nama Barang', 1, 0, 'L');
        $pdf->Cell(42, 6, 'Today', 1, 0, 'C');
        $pdf->Cell(42, 6, 'Follow Up', 1, 0, 'C');
        $pdf->Cell(42, 6, 'Re-marketing', 1, 0, 'C');
        $pdf->Cell(42, 6, 'Total', 1, 1, 'C');

        $pdf->SetFont('Arial', 'B', 9);

        $pdf->Cell(10, 6, '', 0, 0);
        $pdf->Cell(80, 6, '', 0, 0);
        $pdf->Cell(14, 6, 'Chat', 1, 0, 'C');
        $pdf->Cell(14, 6, 'COD', 1, 0, 'C');
        $pdf->Cell(14, 6, 'Transfer', 1, 0, 'C');
        $pdf->Cell(14, 6, 'Chat', 1, 0, 'C');
        $pdf->Cell(14, 6, 'COD', 1, 0, 'C');
        $pdf->Cell(14, 6, 'Transfer', 1, 0, 'C');
        $pdf->Cell(14, 6, 'Chat', 1, 0, 'C');
        $pdf->Cell(14, 6, 'COD', 1, 0, 'C');
        $pdf->Cell(14, 6, 'Transfer', 1, 0, 'C');
        $pdf->Cell(14, 6, 'Chat', 1, 0, 'C');
        $pdf->Cell(14, 6, 'COD', 1, 0, 'C');
        $pdf->Cell(14, 6, 'Transfer', 1, 1, 'C');
//----------------------------------------------------------
        $pdf->SetFont('Arial', '', 9);
        $data = $this->TransaksiModel->laporanByTanggal($tgl1,$tgl2);
        $no = 1;
        foreach ($data as $data):
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(80, 6, $data["PRODUK"], 1, 0);
            $pdf->Cell(14, 6, $data["CHAT_TODAY"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["COD_TODAY"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["TRANSFER_TODAY"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["CHAT_FOLLOW"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["COD_FOLLOW"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["TRANSFER_FOLLOW"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["CHAT_RE"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["COD_RE"], 1, 0, 'C');
            $pdf->Cell(14, 6, $data["TRANSFER_RE"], 1, 0, 'C');
            $pdf->Cell(14, 6, ($data["CHAT_RE"] + $data["CHAT_FOLLOW"] + $data["CHAT_TODAY"]), 1, 0, 'C');
            $pdf->Cell(14, 6, ($data["COD_RE"] + $data["COD_FOLLOW"] + $data["COD_TODAY"]), 1, 0, 'C');
            $pdf->Cell(14, 6, ($data["TRANSFER_RE"] + $data["TRANSFER_FOLLOW"] + $data["TRANSFER_TODAY"]), 1, 1, 'C');
            $no++;
        endforeach;
        $pdf->Output($nama_file . ".pdf", "D");
    }

}
?>