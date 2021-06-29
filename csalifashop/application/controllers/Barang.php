<?php
class Barang extends CI_Controller{
	public function __construct(){
		parent:: __construct();
		$this->load->model("BarangModel");
	}
	public function index(){
		$data["barang"] = $this->BarangModel->tampilData();
		$data["jumKategori"] = $this->BarangModel->jumlahKategori();
		$data["jumProduk"] = $this->BarangModel->jumlahProduk();
		$data["produkTerlaris"] = $this->BarangModel->produkTerlaris();
		$this->load->view("katalog_produk",$data);
	}
}
?>