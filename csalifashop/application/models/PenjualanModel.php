<?php
class PenjualanModel extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	public function cekFaktur(){
		$tanggal = date("Y-m-d");
		$id_user = $this->session->userdata("ID");
		$query = $this->db->query("select count(*) as jumlah from penjualan where id_user='$id_user' and tgl_rekam='$tanggal'");
		return $query->result_array();
	}
	public function showFaktur(){
		$tanggal = date("Y-m-d");
		$id_user = $this->session->userdata("ID");
		$query = $this->db->query("select*from penjualan where id_user='$id_user' and tgl_rekam='$tanggal'");
		return $query->result_array();
	}
	public function insertFaktur($id_fak){
		$tanggal = date("Y-m-d");
		$id_user = $this->session->userdata("ID");
		$insert = array(
			"id_penjualan"=>$id_fak,
			"tgl_rekam"=>$tanggal,
			"id_user"=>$id_user
		);
		return $this->db->insert("penjualan",$insert);
	}
	public function tampildetTransaksi($id_fak){
		$query = $this->db->query("select*from det_penjualan join produk on(produk.id_produk=det_penjualan.id_produk) join kategori on(kategori.id_kategori=produk.id_kategori) where id_penjualan='$id_fak' order by id_det_penjualan desc");
		return $query->result_array();
	}
	public function detailTransaksi($id_fak){
		$query = $this->db->query("select count(det_penjualan.chat_masuk) as total_chat, sum(if(det_penjualan.closing='COD',1,0)) as cod, sum(if(det_penjualan.closing='Transfer',1,0)) as transfer, sum(if(det_penjualan.closing='Batal',1,0)) as total_batal from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where penjualan.id_penjualan='$id_fak'");
		return $query->result_array();
	}
	public function getProduk($id){
		//$id = $this->input->get("k");
		$query = $this->db->query("select*from produk join kategori on(kategori.id_kategori=produk.id_kategori) where kategori.nama_kategori='$id'");
		return $query->result_array();
	}
	public function getChat($id){
		$query = $this->db->query("select sum(if(det_penjualan.chat_masuk='Today',1,0)) as CHAT_TODAY,sum(if(det_penjualan.chat_masuk='Follow Up',1,0)) as CHAT_FOLLOW,sum(if(det_penjualan.chat_masuk='Re-marketing',1,0)) as CHAT_RE from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where det_penjualan.id_penjualan='$id'");
		return $query->result_array();
	}
	public function getKategori(){
		$query = $this->db->query("select*from kategori");
		return $query->result_array();
	}
	public function insertData(){
		$insert = array(
			"tgl_chat_masuk"=>$this->input->post("tgl_chat"),
			"id_penjualan"=>$this->input->post("id_penjualan"),
			"id_produk"=>$this->input->post("produk"),
			"no_wa"=>"",
			"chat_masuk"=>$this->input->post("chat_masuk"),
			"closing"=>$this->input->post("closing"),
			"jumlah"=>$this->input->post("jumlah"),
			"keterangan"=>$this->input->post("keterangan")
		);
		return $this->db->insert("det_penjualan",$insert);
	}
	public function ubahData(){
			$insert = array(
			"tgl_chat_masuk"=>$this->input->post("tgl_chat"),
			"id_produk"=>$this->input->post("produk"),
			"no_wa"=>"",
			"chat_masuk"=>$this->input->post("chat_masuk"),
			"closing"=>$this->input->post("closing"),
			"jumlah"=>$this->input->post("jumlah"),
			"keterangan"=>$this->input->post("keterangan")
		);
		$this->db->where("id_det_penjualan",$this->input->post("id_det_penjualan"));
		return $this->db->update("det_penjualan",$insert);
	}
	public function  getDetailPenjualan($id){
		$query =  $this->db->query("select*from det_penjualan join produk on(produk.id_produk=det_penjualan.id_produk) where id_det_penjualan='$id'");
		return $query->result_array();
	}
	public function hapusData($id){
		$this->db->where("id_det_penjualan",$id);
		return $this->db->delete("det_penjualan");
	}
	public function queryLaporan($id){
		$query = $this->db->query("select produk.nama_produk as PRODUK, sum(if(det_penjualan.chat_masuk='Today',1,0)) as CHAT_TODAY,sum(if(det_penjualan.closing='COD' and det_penjualan.chat_masuk='Today',1,0)) as COD_TODAY,sum(if(det_penjualan.closing='Transfer' and det_penjualan.chat_masuk='Today',1,0)) as TRANSFER_TODAY, sum(if(det_penjualan.chat_masuk='Follow Up',1,0)) as CHAT_FOLLOW,sum(if(det_penjualan.closing='COD' and det_penjualan.chat_masuk='Follow Up',1,0)) as COD_FOLLOW,sum(if(det_penjualan.closing='Transfer' and det_penjualan.chat_masuk='Follow Up',1,0)) as TRANSFER_FOLLOW,sum(if(det_penjualan.chat_masuk='Re-marketing',1,0)) as CHAT_RE,sum(if(det_penjualan.closing='COD' and det_penjualan.chat_masuk='Re-marketing',1,0)) as COD_RE,sum(if(det_penjualan.closing='Transfer' and det_penjualan.chat_masuk='Re-marketing',1,0)) as TRANSFER_RE from det_penjualan join penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) join produk on(produk.id_produk=det_penjualan.id_produk) where det_penjualan.id_penjualan='$id' GROUP BY produk.nama_produk");
		return $query->result_array();
	}

}
?>