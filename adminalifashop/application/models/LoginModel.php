<?php
class LoginModel extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	public function cariData($a,$b){
		$query =  $this->db->query("select count(*) as a from users where username='$a' and password='$b' and status='Admin'");
		return $query->result_array();
	}
	public function tampilData($a,$b){
		$query =  $this->db->query("select*from users where username='$a' and password='$b'");
		return $query->result_array();
	}
}
?>