<?php
class MasterTransaksiModel extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	public function tampilAllTransaksi($id){
		$query = $this->db->query("select penjualan.id_penjualan,penjualan.tgl_rekam,count(det_penjualan.chat_masuk) as total_chat, sum(if(det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.closing='Transfer',1,0)) as total_closing from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where penjualan.id_user='$id' group by penjualan.id_penjualan order by det_penjualan.id_det_penjualan desc");
		return $query->result_array();
	}
	public function tampilAllChat($id){
		$query = $this->db->query("select count(det_penjualan.chat_masuk) as total_chat, sum(if(det_penjualan.closing='COD',1,0)) as total_cod, sum(if(det_penjualan.closing='Transfer',1,0)) as total_transfer, sum(if(det_penjualan.closing='Batal',1,0)) as total_batal from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where penjualan.id_user='$id'");
		return $query->result_array();
	}
	public function getKategori(){
		$query = $this->db->query("select*from kategori");
		return $query->result_array();
	}
}
?>