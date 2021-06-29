<?php
class BarangModel extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	public function tampilData(){
		$query = $this->db->query("select nama_produk,nama_kategori,harga,stok,sum(det_penjualan.jumlah) as terjual from produk join kategori on(kategori.id_kategori=produk.id_kategori) join det_penjualan on(produk.id_produk=det_penjualan.id_produk) group by nama_produk");
		return $query->result_array();
	}
	public function jumlahKategori(){
		$query = $this->db->query("select count(*) as a from kategori");
		return $query->result_array();
	}
	public function jumlahProduk(){
		$query = $this->db->query("select count(*) as a from produk");
		return $query->result_array();
	}
	public function produkTerlaris(){
		$query = $this->db->query("select nama_produk,sum(det_penjualan.jumlah) as jumlah from det_penjualan join produk on(produk.id_produk=det_penjualan.id_produk) group by det_penjualan.id_produk ORDER by det_penjualan.jumlah desc limit 1");
		return $query->result_array();
	}

}
?>