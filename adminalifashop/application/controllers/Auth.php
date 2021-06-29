<?php
class Auth extends CI_Controller {
	public function __construct(){
		parent:: __construct();
		$this->load->model("LoginModel");
	}
	public function index()
	{
		if(!empty($this->session->userdata("ID"))){
			redirect("dashboard");
		}else{
		$this->load->view('auth/login');
		}
	}
	public function loginProses(){
		$id = $this->input->post("username");
		$pass = $this->input->post("password");
		$cek = $this->LoginModel->cariData($id,$pass);
		foreach($cek as $cek):
			if($cek["a"]=="0" || $cek["a"]==0){
				redirect("");
			}else{
				$tampil = $this->LoginModel->tampilData($id,$pass);
				foreach($tampil as $tampil):
					$session = array(
						"ID"=>$tampil["id_user"],
						"NAMA_LENGKAP"=>$tampil["nama_user"],
						"STATUS"=>$tampil["status"]
					);
					$this->session->set_userdata($session);
                	redirect('dashboard','refresh');
				endforeach;
			}
		endforeach;
	}
	public function logout(){
		$this->session->unset_userdata('ID');
		$this->session->unset_userdata('NAMA_LENGKAP');
		$this->session->unset_userdata('STATUS');
		redirect("");
	}
}
?>