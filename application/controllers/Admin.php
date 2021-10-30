<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller{

    public function login()
    {
        if($_SERVER['REQUEST_METHOD']=="POST")
        {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $this->doLogin($username,$password);
        }else{
            $this->load->view('templates/header_login');
            $this->load->view('admin/login');
            $this->load->view('templates/footer');
        }
    }

    private function doLogin($username,$password)
    {
        if($username=="admin")
        {
            if($password=="admin123")
            {
                $data = [
                    "admin_logged_in"=>true
                ];
                $this->session->set_userdata($data);
                redirect('home');
            }else{
                $this->session->set_flashdata('pesan',"Username / password salah !!");
                redirect('admin/login');
            }
        }else{
            $this->session->set_flashdata('pesan',"Username / password salah !!");
            redirect('admin/login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('home');
    }

}