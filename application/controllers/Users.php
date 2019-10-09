<?php

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('session', 'form_validation'));
    }

    public function index() {
        $this->register();
    }

    public function register() {
        $this->form_validation->set_rules('fullname', 'FullName', 'trim|required|alpha|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
        $data['title'] = 'Register';

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('users/register');
            // $this->load->view('templates/footer');

        } else {
            if ($this->user_model->set_user()) {
                $this->session->set_flashdata('msg_success', 'Registration Successful!');
                redirect('users/register');
            } else {
                $this->session->set_flashdata('msg_error', 'Error! Please try again later.');
                redirect('users/register');
            }
        }
    }

    public function login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|md5');

        $data['title'] = 'Login';

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('users/login');
            $this->load->view('templates/footer');

        } else {
            if ($user = $this->user_model->get_user_login($email, $password)) {
                /*$user_data = array(
                              'email' => $email,
                              'is_logged_in' => true
                         );
                     
                $this->session->set_userdata($user_data);*/

                $this->session->set_userdata('email', $email);
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('is_logged_in', true);
                $this->session->set_userdata('role', $user['role']);



                $this->session->set_flashdata('msg_success', 'Login Successful!');
                redirect('users/getUsers');
            } else {
                $this->session->set_flashdata('msg_error', 'Login credentials does not match!');

                $currentClass = $this->router->fetch_class(); // class = controller
                $currentAction = $this->router->fetch_method(); // action = function

                redirect("$currentClass/$currentAction");
                //redirect('user/login');
            }
        }
    }

    public function addUser(){

        if (!$this->session->userdata('is_logged_in')) {
            redirect(site_url('users/login'));
        } else {
            $data['user_id'] = $this->session->userdata('user_id');
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Add User';

        $this->form_validation->set_rules('fullname', 'Fullname', 'required');
        // $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/admin-header', $data);
            $this->load->view('templates/admin-sidebar');
            $this->load->view('users/addUser');
            $this->load->view('templates/footer');
        } else {
            $this->user_model->set_user();
            $this->load->view('templates/admin-header', $data);
            $this->load->view('templates/admin-sidebar');
            $this->load->view('news/success');
            $this->load->view('templates/footer');
            redirect(site_url('users/getUsers'));
        }
    }

    public function edit(){
        if (!$this->session->userdata('is_logged_in')) {
            redirect(site_url('users/login'));
        } else {
            $data['user_id'] = $this->session->userdata('user_id');
        }

        $id = $this->uri->segment(3);
        //$id = $this->input->post('id');

        if (empty($id)) {
            show_404();
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Edit User';
        $data['user_item'] = $this->user_model->get_user($id);

        $this->form_validation->set_rules('fullname', 'Fullname', 'required');
        // $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/admin-header', $data);
            $this->load->view('templates/admin-sidebar');
            $this->load->view('users/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $this->user_model->set_user($id);
            //$this->load->view('news/success');
            redirect(site_url('users/getUsers'));
        }
    }

    public function delete() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect(site_url('users/login'));
        }

        $id = $this->uri->segment(3);

        if (empty($id)) {
            show_404();
        }

        // $news_item = $this->news_model->get_news_by_id($id);

        // if ($news_item['user_id'] != $this->session->userdata('user_id')) {
        //     $currentClass = $this->router->fetch_class(); // class = controller
        //     redirect(site_url($currentClass));
        // }

        $this->user_model->delete_user($id);
        redirect(base_url() . '/users/getUsers');
    }

    public function getUsers(){
        if (!$this->session->userdata('is_logged_in')) {
            redirect(site_url('users/login'));
        } else {
            $data['user_id'] = $this->session->userdata('user_id');
            $data['user_role'] = $this->session->userdata('role');
        }
        $data['users'] = $this->user_model->get_user();
        $data['title'] = 'UserList';

        $this->load->view('templates/admin-header', $data);
        $this->load->view('templates/admin-sidebar');
        $this->load->view('users/userlist', $data);
        $this->load->view('templates/footer');
    }

    public function logout() {
        if ($this->session->userdata('is_logged_in')) {

            //$this->session->unset_userdata(array('email' => '', 'is_logged_in' => ''));
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('is_logged_in');
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('role');
        }
        redirect('users/login');
    }
}
