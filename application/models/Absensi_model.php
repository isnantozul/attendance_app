<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Absensi_model extends CI_Model
{

    public function get_data_absensiall()
    {
        $q = $this->db->query("SELECT CONCAT(B.NAMA_DEPAN,' ',B.NAMA_BELAKANG) AS NAMA_USER, A.* FROM TA_ABSENSI A JOIN TA_USER B ON A.USER_ID = B.ID_USER")->result_array();
        return $q;
    }


    public function get_data_absensi_by_userid($userid)
    {
        $today = $this->get_today_date();
        $q = $this->db->get_where("TA_ABSENSI", ["TGL_ABSEN" => $today, "USER_ID" => $userid])->row_array();
        return $q;
    }

    public function get_data_absensiall_by_userid($userid)
    {
        $q = $this->db->query("SELECT CONCAT(B.NAMA_DEPAN,' ',B.NAMA_BELAKANG) AS NAMA_USER, A.* FROM TA_ABSENSI A JOIN TA_USER B WHERE A.USER_ID ='$userid' AND B.ID_USER = '$userid' ORDER BY A.ID_ABSENSI DESC")->result_array();
        return $q;
    }

    public function get_today_date()
    {
        $bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        return $hari[(int)date("w")] . ', ' . date("j ") . $bulan[(int)date('m')] . date(" Y");
    }
}
