<?php
class MasterTransaksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("MasterTransaksiModel");
    }
    public function index()
    {
        $id = $this->session->userdata("ID");
        $data['Trans'] = $this->MasterTransaksiModel->tampilAllTransaksi($id);
        $data['Chat'] = $this->MasterTransaksiModel->tampilAllChat($id);
        $this->load->view("laporan_belanja", $data);
    }

}