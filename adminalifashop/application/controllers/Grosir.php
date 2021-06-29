<?php 
class Grosir extends CI_Controller{
	public function __construct(){
		parent:: __construct();
		$this->load->model("GrosirModel");
	}
	public function index(){
		$id = $this->input->get("v");
        $data["pr"] = $this->GrosirModel->produkId($id);
        //$data["tampil"] = $this->GrosirModel->tampilGrosir();
        $this->load->view('pages/katalog/detail_produk',$data);
	}
	public function tampilData(){
		$id = $this->input->get("IdMhsw");
		$tampil = $this->GrosirModel->tampilGrosir($id);
		?>
		<script src="<?=base_url('assets/vendor/datatables/jquery.dataTables.min.js')?>"></script>
    <script src="<?=base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js')?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?=base_url('assets/js/demo/datatables-demo.js')?>"></script>
		<div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Jumlah</th>
                                            <th>Harga Grosir (Satuan)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($tampil as $tampil): ?>
                                        <tr>
                                            <td><?=$tampil["qty"];?></td>
                                            <td><?="Rp ".number_format($tampil["harga"], 0, ".", ".");?></td>

                                            <td>
                                                <a class="btn btn-warning btn-sm my-1" data-toggle="modal"
                                                    data-target="#editGrosir">
                                                    <i class="far fa-edit" id="btnUbah" value="<?=$tampil['id_grosir']?>"></i></a>
                                                <a class="btn btn-danger btn-sm my-1" id="btnHapus" value="<?=$tampil['id_grosir']?>">
                                                    <i class="far fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
		<?php
	}
	public function updateData(){
		if($this->GrosirModel->updateData()){
			echo "Berhasil";
		}else{
			echo "Gagal";
		}
	}
	public function insertData(){
		if($this->GrosirModel->inputData()){
			echo "Berhasil";
		}else{
			echo "Gagal";
		}
	}
	public function hapusData(){
		$id = $this->input->post("IdMhsw");
		if($this->GrosirModel->hapusGrosir($id)){
			echo "Berhasil";
		}else{
			echo "Gagal";
		}
	}
	public function tampilDetail(){
    $id = $this->input->post("IdMhsw");
    $tampil = $this->GrosirModel->tampilGrosirId($id);
    foreach($tampil as $tampil):
    ?>
    <script type="text/javascript">
    	$(document).on("submit", "#updateForm", function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'Grosir/updateData',
                    type: 'post',
                    data: $(this).serialize(),
                    success: function(data) {
                        if(data=="Berhasil"){
                            $('#editGrosir').modal('toggle'); 
                            swal("Sukses! Data berhasil diubah!", {
                            icon: "success",
                            });
                        }else{
                            $('#editGrosir').modal('toggle'); 
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Harga Grosir:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateForm" method="post">
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
                                              <input type="hidden" name="id_grosir" value="<?=$id;?>">
                                              <input type="text" class="form-control" value="<?=$tampil['qty'];?>" name="qty" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
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
                                              <input type="text" class="form-control" value="<?=$tampil['harga'];?>" name="harga" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
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
    
    <?php
endforeach;
 }  

}
 ?>