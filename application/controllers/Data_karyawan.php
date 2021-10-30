<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Coyl\Git\Git;
use Coyl\Git\ConsoleException;

class Data_karyawan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index()
    {
        $data["data_karyawan"] = $this->user_model->get_user_listall();
        $this->load->view('templates/header', $data);
        $this->load->view('data_karyawan/read', $data);
        $this->load->view('templates/footer');
    }

    public function detail($id)
    {
        $data["user"] = $this->user_model->get_data_user($id);
        $data["edit_profile_js"] = true;
        $this->load->view('templates/header', $data);
        $this->load->view('data_karyawan/detail', $data);
        $this->load->view('templates/footer', $data);
    }

    public function edit($id)
    {
        $data["user"] = $this->user_model->get_data_user($id);
        $data["edit_profile_js"] = true;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
            $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
            $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
            $this->form_validation->set_rules('status_pernikahan', 'Status Pernikahan', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('kode_pos', 'Kode Pos', 'required');
            $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
            $this->form_validation->set_rules('kota', 'Kota', 'required');
            $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
            $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required');
            if (!$this->form_validation->run()) {
                $this->session->set_flashdata('pesan', 'Harap isi semua data yang dibutuhkan!');
                $this->load->view('templates/header', $data);
                $this->load->view('data_karyawan/edit', $data);
                $this->load->view('templates/footer', $data);
            } else {
                $this->user_model->edit($id);
                $this->session->set_flashdata('pesan-sukses', 'Berhasil update data karyawan');
                redirect("data_karyawan");
            }
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('data_karyawan/edit', $data);
            $this->load->view('templates/footer');
        }
    }

    public function delete($id)
    {
        //get data user
        $user_name = $this->user_model->get_data_user($id)["NAMA_USER"];

        //get foto user
        $user_foto = $this->db->query("SELECT FOTO1,FOTO2,FOTO3 FROM TA_FOTO_USER WHERE USER_ID = '$id'")->row();

        if ($user_foto->FOTO1 != null || $user_foto->FOTO2 != null || $user_foto->FOTO3 != null) {
            // delete file
            $this->delete_files('uploads/face-recognition/labeled-images/' . $user_name . '/');

            try {
                // github update
                $repo = Git::open('uploads/face-recognition');
                $repo->add('.');
                $repo->commit('Commit PHP pada ' . date("Y-m-d"));
                $repo->push('origin', 'main');

                $this->delete_user_from_database($id);
            } catch (ConsoleException $error) {
                $this->delete_user_from_database($id);
            }
        } else {
            $this->delete_user_from_database($id);
        }
    }

    private function delete_user_from_database($id)
    {
        // delete from database
        $this->user_model->delete($id);

        $this->session->set_flashdata('pesan-sukses', 'Berhasil menghapus data karyawan');
        redirect("data_karyawan");
    }

    private function delete_files($target)
    {
        if (is_dir($target)) {
            $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

            foreach ($files as $file) {
                $this->delete_files($file);
            }

            rmdir($target);
        } elseif (is_file($target)) {
            unlink($target);
        }
    }
}
