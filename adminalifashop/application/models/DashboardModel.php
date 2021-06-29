<?php
class DashboardModel extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	public function kategoriTerlaris(){
		$bulan = date("m");
		$query = $this->db->query("select kategori.nama_kategori as NAMA_KATEGORI,sum(if(det_penjualan.chat_masuk='Today' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Today' and det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.chat_masuk='Follow Up' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Follow Up' and det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.chat_masuk='Re-marketing' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Re-marketing' and det_penjualan.closing='COD',1,0)) as TOTAL_TRANSAKSI from kategori join produk on(kategori.id_kategori=produk.id_kategori) join det_penjualan on(produk.id_produk=det_penjualan.id_produk) join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where month(penjualan.tgl_rekam) = $bulan group by kategori.nama_kategori order by TOTAL_TRANSAKSI desc limit 3");
		return $query->result_array();
	}
	public function tampilData(){
		$tgl = date("Y-m-d");
		$query = $this->db->query("select penjualan.tgl_rekam as TGL,penjualan.id_penjualan as NO_REC,users.nama_user as NAMA_USER, count(det_penjualan.chat_masuk) as TOTAL_CHAT,sum(if(det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.closing='Transfer',1,0)) as TOTAL_CLOSING from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) join users on(users.id_user=penjualan.id_user) where penjualan.tgl_rekam = '$tgl' group by penjualan.id_penjualan order by penjualan.tgl_rekam desc");
		return $query->result_array();
	}
	public function statistikCOD($bulan){
		$query = $this->db->query("select sum(det_penjualan.jumlah) as Jumlah from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where month(penjualan.tgl_rekam) = $bulan and det_penjualan.closing='COD'");
		return $query->result_array();
	}
	public function statistikTran($bulan){
		$query = $this->db->query("select sum(det_penjualan.jumlah) as Jumlah from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where month(penjualan.tgl_rekam) = $bulan and det_penjualan.closing='Transfer'");
		return $query->result_array();
	}
	public function getCSTerbaik(){
		$bulan = date("m");
		$query = $this->db->query("select users.nama_user as NAMA_USER, sum(if(det_penjualan.chat_masuk='Today' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Today' and det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.chat_masuk='Follow Up' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Follow Up' and det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.chat_masuk='Re-marketing' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Re-marketing' and det_penjualan.closing='COD',1,0)) as TOTAL_TRANSAKSI from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) join users on(users.id_user=penjualan.id_user) where month(penjualan.tgl_rekam) = $bulan group by users.nama_user order by TOTAL_TRANSAKSI desc limit 1");
		return $query->result_array();
	}
	public function jumlahCs(){
		$query = $this->db->query("select count(nama_user) as JUMLAH from users where status='CS'");
		return $query->result_array();
	}
	public function getAllClosing(){
		$bulan = date("m");
		$query = $this->db->query("select count(det_penjualan.chat_masuk) as TOTAL_CHAT, sum(if(det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.closing='Transfer',1,0)) as TOTAL_CLOSING from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where month(penjualan.tgl_rekam) = $bulan");
		return $query->result_array();
	}
}
?>