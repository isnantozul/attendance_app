<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function get_user_listall()
    {
        $q =  $this->db->query("SELECT CONCAT(NAMA_DEPAN,' ',NAMA_BELAKANG) AS NAMA_USER, A.* FROM TA_USER A")->result_array();
        return $q;
    }

    public function get_data_user($id)
    {
        $q = $this->db->query("SELECT CONCAT(NAMA_DEPAN,' ',NAMA_BELAKANG) AS NAMA_USER, A.* FROM TA_USER A WHERE ID_USER='$id'")->row_array();
        return $q;
    }

    public function get_data_user_by_name($username)
    {
        $q = $this->db->query("SELECT * FROM TA_USER WHERE CONCAT(NAMA_DEPAN,' ',NAMA_BELAKANG) = '$username'")->row_array();
        return $q;
    }

    public function add_new()
    {

        $data = [
            "NAMA_DEPAN" => $this->input->post("nama_depan", true),
            "NAMA_BELAKANG" => $this->input->post("nama_belakang", true),
            "TANGGAL_LAHIR" => $this->input->post("tanggal_lahir", true),
            "TEMPAT_LAHIR" => $this->input->post("tempat_lahir", true),
            "JENIS_KELAMIN" => $this->input->post("jenis_kelamin", true),
            "STATUS_PERNIKAHAN" => $this->input->post("status_pernikahan", true),
            "ALAMAT" => $this->input->post("alamat", true),
            "ALAMAT2" => $this->input->post("alamat2", true),
            "KODE_POS" => $this->input->post("kode_pos", true),
            "PROVINSI" => $this->input->post("provinsi", true),
            "KOTA" => $this->input->post("kota", true),
            "KECAMATAN" => $this->input->post("kecamatan", true),
            "KELURAHAN" => $this->input->post("kelurahan", true),
        ];
        $this->db->insert("TA_USER", $data);
        return $this->db->insert_id();
    }

    public function edit($id)
    {
        $data = [
            "TANGGAL_LAHIR" => $this->input->post("tanggal_lahir", true),
            "TEMPAT_LAHIR" => $this->input->post("tempat_lahir", true),
            "JENIS_KELAMIN" => $this->input->post("jenis_kelamin", true),
            "STATUS_PERNIKAHAN" => $this->input->post("status_pernikahan", true),
            "ALAMAT" => $this->input->post("alamat", true),
            "ALAMAT2" => $this->input->post("alamat2", true),
            "KODE_POS" => $this->input->post("kode_pos", true),
            "PROVINSI" => $this->input->post("provinsi", true),
            "KOTA" => $this->input->post("kota", true),
            "KECAMATAN" => $this->input->post("kecamatan", true),
            "KELURAHAN" => $this->input->post("kelurahan", true),
        ];
        $this->db->update("TA_USER", $data, ["ID_USER" => $id]);
    }

    public function delete($id)
    {
        $this->db->delete("TA_ABSENSI", ["USER_ID" => $id]);
        $this->db->delete("TA_FOTO_USER", ["USER_ID" => $id]);
        $this->db->delete("TA_USER", ["ID_USER" => $id]);
    }

    public function upload_foto($id, $user_id)
    {
        $foto_user = $this->db->get_where("TA_FOTO_USER", ["USER_ID" => $user_id])->row_array();
        $data = [];
        switch ($id) {
            case 1:
                $data = ["USER_ID" => $user_id, "FOTO1" => "1.jpg", "LENGKAP" => 0];
                break;
            case 2:
                $data = ["USER_ID" => $user_id, "FOTO2" => "2.jpg", "LENGKAP" => 0];
                break;
            default:
                $data = ["USER_ID" => $user_id, "FOTO3" => "3.jpg", "LENGKAP" => 0];
                break;
        }
        if (!$foto_user) {
            $this->db->insert("TA_FOTO_USER", $data);
        } else {
            $this->db->where("USER_ID", $user_id);
            $this->db->update("TA_FOTO_USER", $data);
        }
    }

    public function check_upload_foto($user_id)
    {
        $foto_user = $this->db->get_where("TA_FOTO_USER", ["USER_ID" => $user_id])->row_array();
        if ($foto_user) {
            if ($foto_user["FOTO1"] != NULL && $foto_user["FOTO2"] != NULL && $foto_user["FOTO3"] != NULL) {
                $data = [
                    "LENGKAP" => 1
                ];
                $this->db->where("USER_ID", $user_id);
                $this->db->update("TA_FOTO_USER", $data);

                $data = [
                    "LENGKAP_FOTO" => 1
                ];
                $this->db->where("ID_USER", $user_id);
                $this->db->update("TA_USER", $data);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function deleteall_user_photozero()
    {
        $this->db->where("LENGKAP", 0);
        if ($this->db->delete("TA_FOTO_USER")) {
            $this->db->where("LENGKAP_FOTO", 0);
            if ($this->db->delete("TA_USER")) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
