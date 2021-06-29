<?php 
class KategoriModel extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	public function tampilKategori(){
		$query = $this->db->query("select*from kategori order by id_kategori desc");
		return $query->result_array();
	}
	public function tambahKategori(){
		$insert = array(
			"nama_kategori" => $this->input->post("nama_kategori"),
			"range_harga" => $this->input->post("harga")
		);
		return $this->db->insert("kategori",$insert);
	}
	public function getById($id){
		$query = $this->db->query("select*from kategori where id_kategori='$id'");
		return $query->result_array();
	}
	public function update(){
		$insert = array(
			"nama_kategori" => $this->input->post("nama_kategori"),
			"range_harga" => $this->input->post("harga")
		);
		$this->db->where("id_kategori",$this->input->post("id_kategori"));
		return $this->db->update("kategori",$insert);
	}
	public function showProduk($id){
		$query = $this->db->query("select*from produk where id_kategori='$id'");
		return $query->result_array();
	}
	public function hapusDetPenjualan($id_produk){
		$this->db->where("id_produk",$id_produk);
		return $this->db->delete("det_penjualan");
	}
	public function hapusProduk($id){
		$this->db->where("id_kategori",$id);
		return $this->db->delete("produk");
	}
	public function hapus($id){
		$this->db->where("id_kategori",$id);
		return $this->db->delete("kategori");
	}
}
?>