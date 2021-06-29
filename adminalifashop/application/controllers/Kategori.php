<?php
class Kategori extends CI_Controller{
public function __construct(){
	parent:: __construct();
	$this->load->model("KategoriModel");
}
    public function index()
    {
    	$data["tampil"] = $this->KategoriModel->tampilKategori();
        $this->load->view('pages/katalog/kategori',$data);
    }
    public function tambahData(){
    	if($this->KategoriModel->tambahKategori()){
    		echo "Berhasil";
    	}else{
    		echo "Gagal";
    	}	
    }
    public function update(){
    	if($this->KategoriModel->update()){
    		echo "Berhasil";
    	}else{
    		echo "Gagal";
    	}
    }
    public function tampilTabel(){
    	$tampil = $this->KategoriModel->tampilKategori();
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
                                            <th>Nama Kategori</th>
                                            <th>Harga</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1;foreach($tampil as $tampil):?>
                                        <tr>
                                            <td><?=$no;?></td>
                                            <td><?=$tampil["nama_kategori"];?></td>
                                            <td><?="Rp ".number_format($tampil["range_harga"], 0, ".", ".");?></td>
                                            <td>
                                                <a class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#editKategori" value="<?=$tampil['id_kategori'];?>" id="btnUbah">
                                                    <i class="far fa-edit"></i></a>
                                                <a class="btn btn-danger btn-sm" value="<?=$tampil['id_kategori'];?>" id="btnHapus">
                                                    <i class="far fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                        <?php $no++; endforeach;?>
                                    </tbody>
                                </table>
                            </div>
    	<?php
    }
    public function hapus(){
        $id = $this->input->post("IdMhsw");
        $produk = $this->KategoriModel->showProduk($id);
        foreach($produk as $produk):
            $this->KategoriModel->hapusDetPenjualan($produk["id_produk"]);
        endforeach;
        if($this->KategoriModel->hapusProduk($id)){
            if($this->KategoriModel->hapus($id)){
                echo "Berhasil";
            }else{
                echo "Gagal";
            }
        }else{
            echo "Gagal";
        }
    	
    }
    public function tampilDetail(){
    	$id = $this->input->post("IdMhsw");
    	$tampil = $this->KategoriModel->getById($id);
    	foreach($tampil as $tampil):
    	?>
    	<script type="text/javascript">
    		$(document).on("submit", "#updateForm", function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'Kategori/update',
                    type: 'post',
                    data: $(this).serialize(),
                    success: function(data) {
                        if(data=="Berhasil"){
                            $('#editKategori').modal('toggle'); 
                            swal("Sukses! Data berhasil diubah!", {
                            icon: "success",
                            });
                        }else{
                            $('#editKategori').modal('toggle'); 
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
                    <h5 class="modal-title" id="exampleModalLabel">Form edit kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateForm" method="POST">
                <div class="modal-body">
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nama kategori :</label>
                                    <input type="text" class="form-control" name="nama_kategori" value="<?=$tampil['nama_kategori'];?>">
                                    <input type="hidden" name="id_kategori" value="<?=$id;?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Harga :</label>
                                    <input type="number" class="form-control" name="harga" value="<?=$tampil['range_harga'];?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
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