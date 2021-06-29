<?php
class ProdukModel extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	public function queryLaporan(){
		$bulan = date("m");
		$query = $this->db->query("select produk.id_produk as ID_PRODUK,produk.nama_produk as NAMA_PRODUK, sum(if(det_penjualan.chat_masuk='Today' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Today' and det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.chat_masuk='Follow Up' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Follow Up' and det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.chat_masuk='Re-marketing' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Re-marketing' and det_penjualan.closing='COD',1,0)) as TOTAL_TRANSAKSI,sum(if(det_penjualan.closing='Batal',1,0)) as PEMINAT from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) join produk on(produk.id_produk=det_penjualan.id_produk) where month(penjualan.tgl_rekam) = $bulan group by produk.nama_produk order by TOTAL_TRANSAKSI desc");
		return $query->result_array();
	}
	public function getQtyCod($id){
		$bulan = date("m");
		$query=$this->db->query("select sum(det_penjualan.jumlah) as QTY from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where month(penjualan.tgl_rekam) = $bulan and det_penjualan.id_produk='$id' and det_penjualan.closing='COD'");
		return $query->result_array();
	}
	public function getQtyTran($id){
		$bulan = date("m");
		$query=$this->db->query("select sum(det_penjualan.jumlah) as QTY from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where month(penjualan.tgl_rekam) = $bulan and det_penjualan.id_produk='$id' and det_penjualan.closing='Transfer'");
		return $query->result_array();
	}
	public function produkTerlaris(){
		$bulan = date("m");
		$query = $this->db->query("select produk.nama_produk as NAMA_PRODUK, sum(if(det_penjualan.chat_masuk='Today' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Today' and det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.chat_masuk='Follow Up' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Follow Up' and det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.chat_masuk='Re-marketing' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Re-marketing' and det_penjualan.closing='COD',1,0)) as TOTAL_TRANSAKSI from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) join produk on(produk.id_produk=det_penjualan.id_produk) where month(penjualan.tgl_rekam) = $bulan group by produk.nama_produk order by TOTAL_TRANSAKSI desc limit 1");
		return $query->result_array();
	}
	public function hitungProduk(){
		$query = $this->db->query("select count(nama_produk) as Jumlah from produk");
		return $query->result_array();
	}
	public function hitungKategori(){
		$query = $this->db->query("select count(nama_kategori) as Jumlah from kategori");
		return $query->result_array();
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
			"nama_produk"=>$this->input->post("nama_produk"),
			"id_kategori"=>$this->input->post("kategori"),
			"stok" => "0",
			"harga"=>$this->input->post("harga_satuan"),
			"harga_pokok"=>$this->input->post("hpp")
		);
		return $this->db->insert("produk",$insert);
	}
	public function updateData(){
		$insert = array(
			"nama_produk"=>$this->input->post("nama_produk"),
			"id_kategori"=>$this->input->post("kategori"),
			"stok" => "0",
			"harga"=>$this->input->post("harga_satuan"),
			"harga_pokok"=>$this->input->post("hpp")
		);
		$this->db->where("id_produk",$this->input->post("id_produk"));
		return $this->db->update("produk",$insert);
	}
	public function hapusDetPenjualan($id){
		$this->db->where("id_produk",$id);
		return $this->db->delete("det_penjualan");
	}
	public function hapusGrosir($id){
		$this->db->where("id_produk",$id);
		return $this->db->delete("grosir");
	}
	public function hapusProduk($id){
		$this->db->where("id_produk",$id);
		return $this->db->delete("produk");
	}
	public function tampilGrosir(){
		$query =  $this->db->query("select*from grosir");
		return $query->result_array();
	}
}
?>