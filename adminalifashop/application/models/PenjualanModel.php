<?php
class PenjualanModel extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	public function showData(){
		$query  = $this->db->query("select penjualan.tgl_rekam as TANGGAL,users.nama_user as NAMA_USER,produk.nama_produk as PRODUK, det_penjualan.chat_masuk as CHAT,det_penjualan.closing as CLOSING,det_penjualan.keterangan as KETERANGAN,det_penjualan.jumlah as JUMLAH from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) join produk on(produk.id_produk=det_penjualan.id_produk) join users on(users.id_user=penjualan.id_user) order by det_penjualan.id_det_penjualan desc");
		return $query->result_array();
	}
	public function queryLaporan($t1,$t2){
		$query = $this->db->query("select det_penjualan.id_produk as ID_PRODUK,produk.nama_produk as PRODUK,kategori.nama_kategori as KATEGORI,det_penjualan.jumlah as QTY,produk.harga as HARGA_SATUAN,produk.harga_pokok as HPP from det_penjualan join produk on(produk.id_produk=det_penjualan.id_produk) join kategori on(kategori.id_kategori=produk.id_kategori) join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where penjualan.tgl_rekam between '$t1' and '$t2' order by kategori.nama_kategori asc");
		return $query->result_array();
	}
	public function laporanCs($cs,$t1,$t2){
		$query = $this->db->query("select det_penjualan.id_produk as ID_PRODUK,produk.nama_produk as PRODUK,kategori.nama_kategori as KATEGORI,det_penjualan.jumlah as QTY,produk.harga as HARGA_SATUAN,produk.harga_pokok as HPP from det_penjualan join produk on(produk.id_produk=det_penjualan.id_produk) join kategori on(kategori.id_kategori=produk.id_kategori) join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where penjualan.tgl_rekam between '$t1' and '$t2' and penjualan.id_user='$cs' order by kategori.nama_kategori asc");
		return $query->result_array();
	}
	public function laporanKategori($cs,$t1,$t2){
		$query = $this->db->query("select det_penjualan.id_produk as ID_PRODUK,produk.nama_produk as PRODUK,kategori.nama_kategori as KATEGORI,det_penjualan.jumlah as QTY,produk.harga as HARGA_SATUAN,produk.harga_pokok as HPP from det_penjualan join produk on(produk.id_produk=det_penjualan.id_produk) join kategori on(kategori.id_kategori=produk.id_kategori) join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where penjualan.tgl_rekam between '$t1' and '$t2' and produk.id_kategori='$cs' order by kategori.nama_kategori asc");
		return $query->result_array();
	}
	public function laporanAll($kat,$cs,$t1,$t2){
		$query = $this->db->query("select det_penjualan.id_produk as ID_PRODUK,produk.nama_produk as PRODUK,kategori.nama_kategori as KATEGORI,det_penjualan.jumlah as QTY,produk.harga as HARGA_SATUAN,produk.harga_pokok as HPP from det_penjualan join produk on(produk.id_produk=det_penjualan.id_produk) join kategori on(kategori.id_kategori=produk.id_kategori) join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where penjualan.tgl_rekam between '$t1' and '$t2' and penjualan.id_user='$cs' and produk.id_kategori='$kat' order by kategori.nama_kategori asc");
		return $query->result_array();
	}
	public function getCsId($id){
		$query = $this->db->query("select*from users where id_user='$id'");
		return $query->result_array();
	}
	public function getGrosir($id){
		$query = $this->db->query("select*from grosir where id_produk='$id'");
		return $query->result_array();
	}
	public function getKategori(){
		$query =  $this->db->query("select*from kategori");
		return $query->result_array();
	}
	public function getCustomer(){
		$query = $this->db->query("select*from users where status='CS'");
		return $query->result_array();
	}
	public function getDetailHeader(){
		$bulan = date("m");
		$query = $this->db->query("select count(det_penjualan.chat_masuk) as CHAT_MASUK,sum(if(det_penjualan.chat_masuk='Today',1,0)) as TODAY,sum(if(det_penjualan.chat_masuk='Follow Up',1,0)) as FOLLOW,sum(if(det_penjualan.chat_masuk='Re-marketing',1,0)) as RE from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where month(penjualan.tgl_rekam) = $bulan");
		return $query->result_array();
	}
}
?>