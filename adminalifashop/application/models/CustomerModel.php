<?php 
class CustomerModel extends CI_Model{
	public function __construct(){
		$this->load->database();
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
	public function queryLaporan(){
		$bulan = date("m");
		$query = $this->db->query("select users.nama_user as NAMA_USER, sum(if(det_penjualan.chat_masuk='Today' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Today' and det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.chat_masuk='Follow Up' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Follow Up' and det_penjualan.closing='COD',1,0))+sum(if(det_penjualan.chat_masuk='Re-marketing' and det_penjualan.closing='Transfer',1,0))+sum(if(det_penjualan.chat_masuk='Re-marketing' and det_penjualan.closing='COD',1,0)) as TOTAL_TRANSAKSI from users join penjualan on(users.id_user=penjualan.id_user) join det_penjualan on(penjualan.id_penjualan=det_penjualan.id_penjualan) where month(penjualan.tgl_rekam) = $bulan and users.status='CS' group by users.nama_user order by TOTAL_TRANSAKSI desc");
		return $query->result_array();
	}
	public function showData(){
		$query = $this->db->query("select*from users");
		return $query->result_array();
	}
	public function hapusData($id){
		$this->db->where("id_user",$id);
		return $this->db->delete("users");
	}
	public function showDataId($id){
		$query = $this->db->query("select*from users where id_user='$id'");
		return $query->result_array();
	} 
	public function insertData(){
		$insert = array(
			"nama_user"=>$this->input->post("nama_user"),
			"username"=>$this->input->post("username"),
			"password"=>$this->input->post("password"),
			"status"=>$this->input->post("status")
		);
		return $this->db->insert("users",$insert);
	}
	public function updateData(){
		$insert = array(
			"nama_user"=>$this->input->post("nama_user"),
			"username"=>$this->input->post("username"),
			"password"=>$this->input->post("password"),
			"status"=>$this->input->post("status")
		);
		$this->db->where("id_user",$this->input->post("id_user"));
		return $this->db->update("users",$insert);
	}
	public function tampilFaktur($id){
		$query = $this->db->query("select*from penjualan where id_user='$id'");
		return $query->result_array();
	}
	public function hapusDetPenjualan($idFak){
		$this->db->where("id_penjualan",$idFak);
		return $this->db->delete("det_penjualan");
	}
	public function hapusPenjualan($id_user){
		$this->db->where("id_user",$id_user);
		return $this->db->delete("penjualan");
	}
	public function hapusUser($id){
		$this->db->where("id_user",$id);
		return $this->db->delete("users");
	}
}
 ?>