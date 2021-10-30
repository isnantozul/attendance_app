<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Coyl\Git\Git;

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('setting_model');
        $this->load->model('absensi_model');
        date_default_timezone_set("Asia/Jakarta");
    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        //delete user dengan foto tidak lengkap
        if ($this->user_model->deleteall_user_photozero()) {
            $data = array();
            $data["data_user"] = $this->user_model->get_user_listall();
            $data["face_detect"] = true;
            $this->load->view('templates/header', $data);
            $this->load->view('user/login_view', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('home');
        }
    }

    public function user_listall()
    {
        $data = $this->user_model->get_user_listall();
        $res = ["status" => true, "data" => $data, "errors" => null];
        echo json_encode($res);
    }

    public function doabsen()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $date = date("D");
            $clocknow = str_replace(" ", "", $this->input->post('clocknow'));
            //$clocknow = "16:02:00";
            $user_name = $this->input->post('user_name');
            $user_id = $this->user_model->get_data_user_by_name($user_name)["ID_USER"];

            $setting_app = $this->setting_model->get_data_setting();
            if ($this->hari_ini($date) == "Sabtu" || $this->hari_ini($date) == "Minggu") {
                $res = ["status" => false, "data" => null, "errors" => "Hari {$this->hari_ini($date)} libur", "msg" => null];
                echo json_encode($res);
            } else {
                if (strtotime($clocknow) <= strtotime($setting_app["ABSEN_MULAI"])) {
                    $res = ["status" => false, "data" => null, "errors" => "Belum waktunya absen masuk", "msg" => null];
                    echo json_encode($res);
                } else {
                    // do absen
                    $today = $this->absensi_model->get_today_date();
                    if (strtotime($clocknow) >= strtotime($setting_app["ABSEN_MULAI"]) && strtotime($clocknow) <= strtotime($setting_app["ABSEN_MULAI_SAMPAI"])) {
                        if ($this->absensi_model->get_data_absensi_by_userid($user_id)) {
                            $absensi = $this->db->query("SELECT '$user_name' AS NAMA_USER,A.USER_ID,A.JAM_MASUK,A.JAM_PULANG,A.TGL_ABSEN,A.STATUS_USER FROM TA_ABSENSI A JOIN TA_USER B WHERE A.TGL_ABSEN='$today' AND A.USER_ID = '$user_id'")->row_array();
                            $res = ["status" => true, "data" => $absensi, "errors" => null, "msg" => "Anda sudah melakukan absen masuk"];
                            echo json_encode($res);
                        } else {
                            $data = [
                                "USER_ID" => $user_id,
                                "TGL_ABSEN" => $today,
                                "JAM_MASUK" => $clocknow,
                                "JAM_PULANG" => "-",
                                "STATUS_USER" => 1
                            ];
                            $this->db->insert("TA_ABSENSI", $data);

                            $absensi = $this->db->query("SELECT '$user_name' AS NAMA_USER,A.USER_ID,A.JAM_MASUK,A.JAM_PULANG,A.TGL_ABSEN,A.STATUS_USER FROM TA_ABSENSI A JOIN TA_USER B WHERE A.TGL_ABSEN='$today' AND A.USER_ID = '$user_id'")->row_array();
                            $res = ["status" => true, "data" => $absensi, "errors" => null, "msg" => null];
                            echo json_encode($res);
                        }
                    } elseif (strtotime($clocknow) >  strtotime($setting_app["ABSEN_MULAI_SAMPAI"]) && strtotime($clocknow) <= strtotime($setting_app["ABSEN_VALID"])) {
                        // terlambat
                        if ($this->absensi_model->get_data_absensi_by_userid($user_id)) {
                            $absensi = $this->db->query("SELECT '$user_name' AS NAMA_USER,A.USER_ID,A.JAM_MASUK,A.JAM_PULANG,A.TGL_ABSEN,A.STATUS_USER FROM TA_ABSENSI A JOIN TA_USER B WHERE A.TGL_ABSEN='$today' AND A.USER_ID = '$user_id'")->row_array();
                            $res = ["status" => true, "data" => $absensi, "errors" => null, "msg" => "Anda sudah melakukan absen masuk"];
                            echo json_encode($res);
                        } else {
                            $data = [
                                "USER_ID" => $user_id,
                                "TGL_ABSEN" => $today,
                                "JAM_MASUK" => $clocknow,
                                "JAM_PULANG" => "-",
                                "STATUS_USER" => 2
                            ];
                            $this->db->insert("TA_ABSENSI", $data);

                            $absensi = $this->db->query("SELECT '$user_name' AS NAMA_USER,A.USER_ID,A.JAM_MASUK,A.JAM_PULANG,A.TGL_ABSEN,A.STATUS_USER FROM TA_ABSENSI A JOIN TA_USER B WHERE A.TGL_ABSEN='$today' AND A.USER_ID = '$user_id'")->row_array();
                            $res = ["status" => true, "data" => $absensi, "errors" => null, "msg" => null];
                            echo json_encode($res);
                        }
                    } elseif (strtotime($clocknow) > strtotime($setting_app["ABSEN_VALID"]) && strtotime($clocknow) < strtotime($setting_app["ABSEN_PULANG"])) {
                        $absensi_user = $this->absensi_model->get_data_absensi_by_userid($user_id);
                        if ($absensi_user && $absensi_user["STATUS_USER"] != 3) {
                            $absensi = $this->db->query("SELECT '$user_name' AS NAMA_USER,A.USER_ID,A.JAM_MASUK,A.JAM_PULANG,A.TGL_ABSEN,A.STATUS_USER FROM TA_ABSENSI A JOIN TA_USER B WHERE A.TGL_ABSEN='$today' AND A.USER_ID = '$user_id'")->row_array();
                            $res = ["status" => true, "data" => $absensi, "errors" => null, "msg" => "Belum waktunya absen pulang"];
                            echo json_encode($res);
                        } else {
                            if ($absensi_user && $absensi_user["STATUS_USER"] == 3) {

                                $absensi = $this->db->query("SELECT '$user_name' AS NAMA_USER,A.USER_ID,A.JAM_MASUK,A.JAM_PULANG,A.TGL_ABSEN,A.STATUS_USER FROM TA_ABSENSI A JOIN TA_USER B WHERE A.TGL_ABSEN='$today' AND A.USER_ID = '$user_id'")->row_array();
                                $res = ["status" => true, "data" => $absensi, "errors" => null, "msg" => null];
                                echo json_encode($res);
                            } else {
                                $data = [
                                    "USER_ID" => $user_id,
                                    "TGL_ABSEN" => $today,
                                    "JAM_MASUK" => "-",
                                    "JAM_PULANG" => "-",
                                    "STATUS_USER" => 3
                                ];
                                $this->db->insert("TA_ABSENSI", $data);

                                $absensi = $this->db->query("SELECT '$user_name' AS NAMA_USER,A.USER_ID,A.JAM_MASUK,A.JAM_PULANG,A.TGL_ABSEN,A.STATUS_USER FROM TA_ABSENSI A JOIN TA_USER B WHERE A.TGL_ABSEN='$today' AND A.USER_ID = '$user_id'")->row_array();
                                $res = ["status" => true, "data" => $absensi, "errors" => null, "msg" => null];
                                echo json_encode($res);
                            }
                        }
                    } elseif (strtotime($clocknow) > strtotime($setting_app["ABSEN_VALID"]) && strtotime($clocknow) >= strtotime($setting_app["ABSEN_PULANG"])) {
                        $absensi_user = $this->absensi_model->get_data_absensi_by_userid($user_id);
                        if ($absensi_user && $absensi_user["STATUS_USER"] != 3) {
                            $data = [
                                "JAM_PULANG" => $clocknow,
                            ];
                            $this->db->where('USER_ID', $user_id);
                            $this->db->update("TA_ABSENSI", $data);

                            $absensi = $this->db->query("SELECT '$user_name' AS NAMA_USER,A.USER_ID,A.JAM_MASUK,A.JAM_PULANG,A.TGL_ABSEN,A.STATUS_USER FROM TA_ABSENSI A JOIN TA_USER B WHERE A.TGL_ABSEN='$today' AND A.USER_ID = '$user_id'")->row_array();
                            $res = ["status" => true, "data" => $absensi, "errors" => null, "msg" => null];
                            echo json_encode($res);
                        } else {
                            if ($absensi_user && $absensi_user["STATUS_USER"] == 3) {
                                $absensi = $this->db->query("SELECT '$user_name' AS NAMA_USER,A.USER_ID,A.JAM_MASUK,A.JAM_PULANG,A.TGL_ABSEN,A.STATUS_USER FROM TA_ABSENSI A JOIN TA_USER B WHERE A.TGL_ABSEN='$today' AND A.USER_ID = '$user_id'")->row_array();
                                $res = ["status" => true, "data" => $absensi, "errors" => null, "msg" => null];
                                echo json_encode($res);
                            } else {
                                $data = [
                                    "USER_ID" => $user_id,
                                    "TGL_ABSEN" => $today,
                                    "JAM_MASUK" => "-",
                                    "JAM_PULANG" => "-",
                                    "STATUS_USER" => 3
                                ];
                                $this->db->insert("TA_ABSENSI", $data);

                                $absensi = $this->db->query("SELECT '$user_name' AS NAMA_USER,A.USER_ID,A.JAM_MASUK,A.JAM_PULANG,A.TGL_ABSEN,A.STATUS_USER FROM TA_ABSENSI A JOIN TA_USER B WHERE A.TGL_ABSEN='$today' AND A.USER_ID = '$user_id'")->row_array();
                                $res = ["status" => true, "data" => $absensi, "errors" => null, "msg" => null];
                                echo json_encode($res);
                            }
                        }
                    }
                }
            }
        }
    }

    public function register()
    {
        $data = array();
        $data["face_register"] = true;
        $data["status"] = ["Menikah", "Cerai", "Single"];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->form_validation->set_rules('nama_depan', 'Nama Depan', 'required');
            $this->form_validation->set_rules('nama_belakang', 'Nama Belakang', 'required');
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
                $this->load->view('user/register_view');
                $this->load->view('templates/footer');
            } else {
                $newid = $this->user_model->add_new();
                redirect("user/uploads/" . $newid);
            }
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('user/register_view');
            $this->load->view('templates/footer');
        }
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
                $this->load->view('user/edit_view', $data);
                $this->load->view('templates/footer', $data);
            } else {
                $this->user_model->edit($id);
                $this->session->set_flashdata('pesan-sukses', 'Berhasil update data');
                redirect("user/edit/" . $id);
            }
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('user/edit_view', $data);
            $this->load->view('templates/footer', $data);
        }
    }

    public function uploads($id)
    {
        $data["face_register"] = true;
        $data["user"] = $this->user_model->get_data_user($id);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $this->input->post('id');
            $base64image = $this->input->post('base64image');
            $user_name = $this->input->post('user_name');
            $user_id = $this->input->post('user_id');

            define('UPLOAD_DIR', 'uploads/face-recognition/labeled-images/' . $user_name . '/');
            if (!file_exists(UPLOAD_DIR)) {
                mkdir(UPLOAD_DIR, 0777, true);
            }

            $img = str_replace('data:image/jpeg;base64,', '', $base64image);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            $file = UPLOAD_DIR . $id . '.jpg';
            $success = file_put_contents($file, $data);
            if ($success) {
                // ============ Insert ke github dengan php
                $repo = Git::open('uploads/face-recognition');
                $repo->add('.');
                $repo->commit('Commit PHP pada ' . date("Y-m-d"));
                $repo->push('origin', 'main');

                $this->user_model->upload_foto($id, $user_id);
                $res = ["status" => true, "data" => ["foto" => $base64image, "nama" => $user_name], "errors" => null];
            } else {
                $res = ["status" => false, "data" => null, "errors" => "Unable to save the file."];
            }
            echo json_encode($res);
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('user/upload_view', $data);
            $this->load->view('templates/footer');
        }
    }

    public function check_upload_foto($user_id)
    {
        if ($this->user_model->check_upload_foto($user_id)) {
            redirect('home');
        } else {
            $this->session->set_flashdata('pesan', 'Foto belum lengkap, silahkan upload foto!!');
            redirect("user/uploads/" . $user_id);
        }
    }

    public function riwayat_absen($user_id)
    {
        $data["data_absensi"] = $this->absensi_model->get_data_absensiall_by_userid($user_id);
        $this->load->view('templates/header', $data);
        $this->load->view('user/list_absensi_view', $data);
        $this->load->view('templates/footer', $data);
    }

    private function hari_ini($hari)
    {
        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;

            case 'Mon':
                $hari_ini = "Senin";
                break;

            case 'Tue':
                $hari_ini = "Selasa";
                break;

            case 'Wed':
                $hari_ini = "Rabu";
                break;

            case 'Thu':
                $hari_ini = "Kamis";
                break;

            case 'Fri':
                $hari_ini = "Jumat";
                break;

            case 'Sat':
                $hari_ini = "Sabtu";
                break;

            default:
                $hari_ini = "Tidak di ketahui";
                break;
        }

        return $hari_ini;
    }
}
