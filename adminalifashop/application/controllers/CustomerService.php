<?php
class CustomerService extends CI_Controller{
	public function __construct(){
		parent:: __construct();
		$this->load->model("CustomerModel");
        $this->load->library('Cetak_pdf');
	}
    public function index(){
        $data["csterbaik"] = $this->CustomerModel->getCSTerbaik();
        $data["totalcs"] = $this->CustomerModel->jumlahCs();
        $this->load->view('pages/admin/index',$data);
    }
    public function insertData(){
    	if($this->CustomerModel->insertData()){
    		echo "Berhasil";
    	}else{
    		echo "Gagal";
    	}
    }
    public function updateData(){
    	if($this->CustomerModel->updateData()){
    		echo "Berhasil";
    	}else{
    		echo "Gagal";
    	}
    }
    public function hapusData(){
    	$id = $this->input->post("IdMhsw");
    	$faktur = $this->CustomerModel->tampilFaktur($id);
    	foreach($faktur as $faktur):
    		$this->CustomerModel->hapusDetPenjualan($faktur["id_penjualan"]);
    	endforeach;
    	$this->CustomerModel->hapusPenjualan($id);
    	if($this->CustomerModel->hapusUser($id)){
    		echo "Berhasil";
    	}else{
    		echo "Gagal";
    	}
    }
    public function laporanCustomer(){
        $tgl1 = date("Y-m-d");
        
        $nama_file = "LAPORAN CUSTOMER SERVICE";
        $pdf = new FPDF('P', 'mm', 'Letter');

        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 7, 'LAPORAN CUSTOMER SERVICE', 0, 1, 'C');
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
        $pdf->Cell(100, 6, 'Nama Customer Service', 1, 0, 'L');
        $pdf->Cell(70, 6, 'Penjualan Bulan Ini', 1, 1, 'C');
//----------------------------------------------------------
        $pdf->SetFont('Arial', '', 10);
        $data = $this->CustomerModel->queryLaporan();
        $no = 1;
        foreach ($data as $data):
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(100, 6, $data["NAMA_USER"], 1, 0, 'L');
            $pdf->Cell(70, 6, $data["TOTAL_TRANSAKSI"], 1, 1, 'C');
            $no++;
        endforeach;
        $pdf->Output($nama_file . ".pdf", "D");
    }
    public function tampilDetail(){
    	$id = $this->input->post("IdMhsw");
    	$data = $this->CustomerModel->showDataId($id);
    	$arr_status = array("CS","Admin","Nonaktif");
    	$arr_txt = array("Customer Service","Admin","Nonaktif");
    	$status="";
    	$arr_sts="";
    	//$no=0;
    	foreach($data as $data):
    		$status=$data["status"];
    	?>
    	<script type="text/javascript">
    	$(document).on("submit", "#updateForm", function(e) {
    			var url = "<?=site_url('CustomerService/updateData');?>";
                e.preventDefault();
                $.ajax({
                    url: url,
                    type: 'post',
                    data: $(this).serialize(),
                    success: function(data) {
                        if(data=="Berhasil"){
                            $('#editCS').modal('toggle'); 
                            swal("Sukses! Data berhasil diubah!", {
                            icon: "success",
                            });
                        }else{
                            $('#editCS').modal('toggle'); 
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
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="updateForm">
                <div class="modal-body">
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nama lengkap :</label>
                                    <input type="text" class="form-control" value="<?=$data['nama_user'];?>" name="nama_user" required="required">
                                    <input type="hidden" name="id_user" value="<?=$id;?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Status :</label>
                                    <select class="form-control" name="status" required="required">
                                    	<option>Pilih</option>
                                    	<?php $n=0;while($n<=2){
                                    		$arr_sts = $arr_status[$n];
                                    		if($status==$arr_sts){
                                    	?>
                                        <option value="<?=$arr_status[$n];?>" selected><?=$arr_txt[$n];?></option>
                                        <?php }else{?>
                                        	<option value="<?=$arr_status[$n];?>" ><?=$arr_txt[$n];?></option>
                                        <?php }
                                        $n++; 
                                    }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Username :</label>
                                    <input type="text" class="form-control" name="username" value="<?=$data['username'];?>" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>password :</label>
                                    <input type="text" class="form-control" name="password" value="<?=$data['password'];?>" required="required">
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
    public function ShowData(){
    	$data = $this->CustomerModel->showData();
    	?>
    	<script src="<?=base_url('assets/vendor/datatables/jquery.dataTables.min.js')?>"></script>
    	<script src="<?=base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js')?>"></script>
    	<!-- Page level custom scripts -->
    	<script src="<?=base_url('assets/js/demo/datatables-demo.js')?>"></script>
    	<div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php $no=1;foreach($data as $data):?>
                                        <tr>
                                            <td><?=$no;?></td>
                                            <td><?=$data["nama_user"];?></td>
                                            <td><?=$data["username"];?></td>
                                            <td>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" class="form-control" value="<?=$data['password'];?>"
                                                        disabled>
                                                    <div class="input-group-append">
                                                        <a class="btn btn-outline-secondary" type="button"><i
                                                                class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?=$data["status"];?></td>
                                            <td>
                                                <a class="btn btn-warning btn-sm my-1" data-toggle="modal"
                                                    data-target="#editCS" id="btnUbah" value="<?=$data['id_user'];?>">
                                                    <i class="far fa-edit"></i></a>
                                                <a class="btn btn-danger btn-sm my-1" id="btnHapus" value="<?=$data['id_user'];?>">
                                                    <i class="far fa-trash-alt"></i></a>
                                            </td>
                                        </tr> 
                                        <?php $no++; endforeach;?>          
                                    </tbody>
                                </table>
                            </div>
                            <script>
    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("fa-eye-slash");
                $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("fa-eye-slash");
                $('#show_hide_password i').addClass("fa-eye");
            }
        });
    });
    </script>
    	<?php
    }
}
?>