<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
	public function __construct(){
		parent:: __construct();
		$this->load->model("DashboardModel");
	}

    public function index()
    {
    	$data["chartPie"] = $this->DashboardModel->kategoriTerlaris();
    	$data["csterbaik"] = $this->DashboardModel->getCSTerbaik();
    	$data["jumlahcs"] = $this->DashboardModel->jumlahCs();
    	$data["allclosing"] = $this->DashboardModel->getAllClosing();
        $this->load->view('pages/dashboard/index',$data);
    }

}