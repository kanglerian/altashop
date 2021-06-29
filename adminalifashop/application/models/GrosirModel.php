<?php
class GrosirModel extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	public function tampilData(){
		$query = $this->db->query("select*from produk join kategori on(kategori.id_kategori=produk.id_kategori) order by produk.id_produk desc");
		return $query->result_array();
	}
	public function produkId($id){
		$query = $this->db->query("select*from produk where id_produk='$id'");
		return $query->result_array();
	}
	public function getById($id){
		$query = $this->db->query("select*from produk join kategori on(kategori.id_kategori=produk.id_kategori) where produk.id_produk='$id'");
		return $query->result_array();
	}
	public function getKategori(){
		$query =  $this->db->query("select*from kategori order by nama_kategori asc");
		return $query->result_array();
	}
	public function inputData(){
		$insert = array(
			"id_produk"=>$this->input->post("id_produk"),
			"qty"=>$this->input->post("qty"),
			"harga"=>$this->input->post("harga")
		);
		return $this->db->insert("grosir",$insert);
	}
	public function updateData(){
		$insert = array(
			"qty"=>$this->input->post("qty"),
			"harga"=>$this->input->post("harga")
		);
		$this->db->where("id_grosir",$this->input->post("id_grosir"));
		return $this->db->update("grosir",$insert);
	}
	public function hapusDetPenjualan($id){
		$this->db->where("id_produk",$id);
		return $this->db->delete("det_penjualan");
	}
	public function hapusGrosir($id){
		$this->db->where("id_grosir",$id);
		return $this->db->delete("grosir");
	}
	public function hapusProduk($id){
		$this->db->where("id_produk",$id);
		return $this->db->delete("produk");
	}
	public function tampilGrosir($id){
		$query =  $this->db->query("select*from grosir where id_produk='$id' order by qty asc");
		return $query->result_array();
	}
	public function tampilGrosirId($id){
		$query = $this->db->query("select*from grosir where id_grosir='$id'");
		return $query->result_array();
	}
}
?>