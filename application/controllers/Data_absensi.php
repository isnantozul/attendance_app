<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_absensi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('absensi_model');
    }

    public function index()
    {
        $data["data_absensi"] = $this->absensi_model->get_data_absensiall();
        $this->load->view('templates/header', $data);
        $this->load->view('data_absensi/read', $data);
        $this->load->view('templates/footer');
    }

    public function export_excel()
    {
        $data["data_absensi"] = $this->absensi_model->get_data_absensiall();
        $this->load->view('download/export', $data);
    }
}
