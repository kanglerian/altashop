<?php
class TransaksiModel extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	public function getTransaksi(){
		$bulan = date("m");
		$query = $this->db->query("select sum(if(det_penjualan.chat_masuk='Today' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Today' and det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.chat_masuk='Follow Up' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Follow Up' and det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.chat_masuk='Re-marketing' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Re-marketing' and det_penjualan.closing='COD',1,0)) as TOTAL_TRANSAKSI,sum(if(det_penjualan.closing='Transfer',1,0)) as TOTAL_TRANSFER,sum(if(det_penjualan.closing='COD',1,0)) as TOTAL_COD from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where month(penjualan.tgl_rekam) = $bulan");
		return $query->result_array();
	}
	public function tampilData(){
		$query = $this->db->query("select penjualan.tgl_rekam as TGL,penjualan.id_penjualan as NO_REC,users.nama_user as NAMA_USER, count(det_penjualan.chat_masuk) as TOTAL_CHAT,sum(if(det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.closing='Transfer',1,0)) as TOTAL_CLOSING from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) join users on(users.id_user=penjualan.id_user) group by penjualan.id_penjualan order by penjualan.tgl_rekam desc");
		return $query->result_array();
	}
	public function queryLaporan($id){
		$query = $this->db->query("select produk.nama_produk as PRODUK, sum(if(det_penjualan.chat_masuk='Today',1,0)) as CHAT_TODAY,sum(if(det_penjualan.closing='COD' and det_penjualan.chat_masuk='Today',1,0)) as COD_TODAY,sum(if(det_penjualan.closing='Transfer' and det_penjualan.chat_masuk='Today',1,0)) as TRANSFER_TODAY, sum(if(det_penjualan.chat_masuk='Follow Up',1,0)) as CHAT_FOLLOW,sum(if(det_penjualan.closing='COD' and det_penjualan.chat_masuk='Follow Up',1,0)) as COD_FOLLOW,sum(if(det_penjualan.closing='Transfer' and det_penjualan.chat_masuk='Follow Up',1,0)) as TRANSFER_FOLLOW,sum(if(det_penjualan.chat_masuk='Re-marketing',1,0)) as CHAT_RE,sum(if(det_penjualan.closing='COD' and det_penjualan.chat_masuk='Re-marketing',1,0)) as COD_RE,sum(if(det_penjualan.closing='Transfer' and det_penjualan.chat_masuk='Re-marketing',1,0)) as TRANSFER_RE from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) join produk on(produk.id_produk=det_penjualan.id_produk) where det_penjualan.id_penjualan='$id' GROUP BY produk.nama_produk");
		return $query->result_array();
	}
	public function laporanByTanggal($t1,$t2){
		$query = $this->db->query("select produk.nama_produk as PRODUK, sum(if(det_penjualan.chat_masuk='Today',1,0)) as CHAT_TODAY,sum(if(det_penjualan.closing='COD' and det_penjualan.chat_masuk='Today',1,0)) as COD_TODAY,sum(if(det_penjualan.closing='Transfer' and det_penjualan.chat_masuk='Today',1,0)) as TRANSFER_TODAY, sum(if(det_penjualan.chat_masuk='Follow Up',1,0)) as CHAT_FOLLOW,sum(if(det_penjualan.closing='COD' and det_penjualan.chat_masuk='Follow Up',1,0)) as COD_FOLLOW,sum(if(det_penjualan.closing='Transfer' and det_penjualan.chat_masuk='Follow Up',1,0)) as TRANSFER_FOLLOW,sum(if(det_penjualan.chat_masuk='Re-marketing',1,0)) as CHAT_RE,sum(if(det_penjualan.closing='COD' and det_penjualan.chat_masuk='Re-marketing',1,0)) as COD_RE,sum(if(det_penjualan.closing='Transfer' and det_penjualan.chat_masuk='Re-marketing',1,0)) as TRANSFER_RE from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) join produk on(produk.id_produk=det_penjualan.id_produk) where penjualan.tgl_rekam between '$t1' and '$t2' GROUP BY produk.nama_produk");
		return $query->result_array();
	}
}
?>