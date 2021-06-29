<?php
class Rekap extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("PenjualanModel");
        $this->load->library('Cetak_pdf');
    }
    public function index()
    {
        list($a, $b) = explode(" ", $this->session->userdata("NAMA_LENGKAP"));
        $tgl = date("Y-m-d");
        $cekResi = $this->PenjualanModel->cekFaktur();
        $resi = "";
        foreach ($cekResi as $cekResi):
            if ($cekResi["jumlah"] == "0" || $cekResi["jumlah"] == 0) {
                $resi = "REC" . strtoupper($a) . date("Ymd") . $this->session->userdata("ID");
                $this->PenjualanModel->insertFaktur($resi);
            } else {
                $showFaktur = $this->PenjualanModel->showFaktur();
                foreach ($showFaktur as $showFaktur):
                    $resi = $showFaktur["id_penjualan"];
                endforeach;
            }
        endforeach;
        $data["id_faktur"] = $resi;
        $data["tampil"] = $this->PenjualanModel->tampildetTransaksi($resi);
        $data["detTran"] = $this->PenjualanModel->detailTransaksi($resi);
        //$data["produk"] = $this->PenjualanModel->getProduk();
        $this->load->view("rekap_penjualan", $data);
    }
    public function insertData()
    {
        $ket = $this->input->post("ket");
        if ($this->PenjualanModel->insertData()) {
            redirect("penjualan?k=".$ket);
        } else {
            redirect("penjualan?k=".$ket);
        }
    }
    public function update()
    {
        $ket = $this->input->post("ket");
        if ($this->PenjualanModel->ubahData()) {
            redirect("penjualan?k=".$ket);
        } else {
            redirect("penjualan?k=".$ket);
        }
    }
    public function tampilDetail()
    {
        error_reporting(0);
        list($id_faktur,$kt) = explode("-", $this->input->post("IdMhsw"));
        $produk = $this->PenjualanModel->getProduk($kt);
        $data = $this->PenjualanModel->getDetailPenjualan($id_faktur);
        $arr_chat = array("Today","Follow Up","Re-marketing");
        $arr_closing = array("Transfer","COD","Batal");
        $txt_closing = array("Transfer","COD","Belum Closing");
        $nama_produk = "";
        $closing = "";
        $chat_m = "";
        //echo "lslakslakslka";
        foreach ($data as $data):
            list($a, $b) = explode("-", $data["keterangan"]);
            $nama_produk = $data["nama_produk"];
            $chat_m = $data["chat_masuk"];
            $closing = $data["closing"];
            ?>

<script type="text/javascript">
$(function() {
    $('.chosen-select').chosen();
    $('.chosen-select-deselect').chosen({
        allow_single_deselect: true
    });
    //$('.chosen-container').css({ 'width':'auto !important' });
});
</script>
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form ubah pembelian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="<?=site_url('Rekap/update');?>" method="POST">
        <div class="modal-body">

            <div class="form-row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Tanggal Chat :</label>
                        <input type="hidden" name="id_det_penjualan" value="<?=$id_faktur;?>">
                        <input type="date" class="form-control datepicker" id="myDate"
                            value="<?=$data['tgl_chat_masuk'];?>" name="tgl_chat" required>
                            <input type="hidden" name="ket" value="<?=$kt;?>">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Nama Produk :</label><br>
                        <select data-placeholder="Choose a Country..." class="chosen-select" tabindex="1" id="sort"
                            name="produk" required>
                            <option value=""></option>
                            </option>
                            <option>Pilih Produk</option>
                            <?php foreach ($produk as $produk): 
                                if($produk["nama_produk"] == $nama_produk){
                                ?>
                            <option value="<?=$produk['id_produk'];?>" selected><?=$produk["nama_produk"];?></option>
                        <?php }else{ ?>
                            <option value="<?=$produk['id_produk'];?>"><?=$produk["nama_produk"];?></option>
                        <?php }?>
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
                            <option>Pilih</option>
                            <?php $n=0;$t_c="";while($n<=3){
                                $t_c = $arr_chat[$n];
                            if($t_c == $chat_m){
                            ?>
                            <option value="<?=$arr_chat[$n];?>" selected><?=$arr_chat[$n];?></option>
                            <?php }else{?>
                                <option value="<?=$arr_chat[$n];?>"><?=$arr_chat[$n];?></option>
                                <?php }?>
                        <?php $n++;}?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-12 col-md-8">
                                <div class="form-group">
                                    <label>Catatan :</label>
                                    <input type="text" class="form-control" placeholder="Masukan catatan.." name="keterangan" value="<?=$data['keterangan'];?>">
                                </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label>Jumlah :</label>
                        <input type="number" class="form-control" placeholder="Contoh: 4" name="jumlah"
                            value="<?=$data['jumlah'];?>" required>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Closing :</label>
                        <select class="form-control" name="closing" required>
                            <option value="<?=$data['closing'];?>" selected><?=$data['closing'];?></option>
                            <option>Pilih</option>
                            <?php $n2=0;$t_cl="";while($n2<=2){
                                $t_cl=$arr_closing[$n2];
                                if($t_cl == $closing){?>
                            <option value="<?=$t_cl;?>" selected><?=$txt_closing[$n2];?></option>
                        <?php }else{?>
                            <option value="<?=$t_cl;?>"><?=$txt_closing[$n2];?></option>
                            <?php }
                            $n2++;}?>
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
<?php
endforeach;
    }
    public function hapusData()
    {
        $id = $this->input->post("IdMhsw");
        if ($this->PenjualanModel->hapusData($id)) {
            redirect("penjualan");
        } else {
            redirect("penjualan");
        }
    }
    public function cetakLaporan()
    {
        $id = $this->input->get("id");
        $tanggal = $this->input->get("tgl");
        $nama_file = "LAPORAN PENJUALAN_" . $tanggal . "_" . strtoupper($this->session->userdata("NAMA_LENGKAP"));
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
        $pdf->Cell(45, 3, ": " . strtoupper($this->session->userdata("NAMA_LENGKAP")), 0, 1, 'L');
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
        $data = $this->PenjualanModel->queryLaporan($id);
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