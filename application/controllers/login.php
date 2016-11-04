<?php

if (!defined('BASEPATH'))
{
    exit('No direct script access allowed');
}

class Login extends CI_Controller
{

    function __construct()
    {
        /* heritage of parent constructor */
        parent::__construct();
    }

    function index()
    {
        /* if the user is already logged, redirect to foregners listing page */
        if ($this->session->userdata('logged_in'))
        {
            redirect('dashboard', 'refresh');
        }

        /* form helper */
        $this->load->helper('form');

        /* login view */
        $this->load->view('login');
    }

    function verify()
    {
        /* if the user is already logged, redirect to foregners listing page */
        if ($this->session->userdata('logged_in'))
        {
            redirect('dashboard', 'refresh');
        }

        /* this method will have the credentials validation */
        $this->load->library('form_validation');

        /* form validation */
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

        /* field validation failed */
        if ($this->form_validation->run() == FALSE)
        {
            $data['errors'] = validation_errors();

            /* reload the login view */
            $this->load->view('login', $data);
        }
        /* Go to private area */
        else
        {
            /* redirect to foregners list */
            redirect('dashboard', 'refresh');
        }
    }

    function check_database($password)
    {
        /* load user model */
        $this->load->model('user', '', TRUE);

        /* if the user is already logged, redirect to foregners listing page */
        if ($this->session->userdata('logged_in'))
        {
            redirect('dashboard', 'refresh');
        }

        /* make the user validation */
        $result = $this->user->login($this->input->post('username'), $password);

        /* valid user */
        if ($result)
        {
            /* loop the result (it's just one) */
            foreach ($result as $row)
            {
                /* session params */
                $sess_array = array(
                    'id'        => $row->id,
                    'username'  => $row->username,
                    'loc_id'    => $row->loc_id,
                    'loc_name'  => $row->loc_name,
                    'loc_coord' => $row->loc_coord,
                );

                /* set the session params */
                $this->session->set_userdata('logged_in', $sess_array);
            }

            /* user is valid */
            return TRUE;
        }
        /* unvalid user */
        else
        {
            /* set form validation */
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            /* return false will prevent user to pass */
            return FALSE;
        }
    }

    function changePassword()
    {

        /* include form validation library */
        $this->load->library('form_validation');

        /* se existe post */
        if ($this->input->post())
        {
            /* form validation */
            $this->form_validation->set_rules('password_current', 'Current Password', 'trim|required|xss_clean|callback_current_password');
            $this->form_validation->set_rules('password_new', 'New Password', 'trim|required|xss_clean|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'trim|required|xss_clean');

            /* field validation failed. */
            if ($this->form_validation->run() == FALSE)
            {
                /* reload the login view */
                $this->load->view('/login/change_password');
            }
            /* Go to private area */
            else
            {
                /* current logged user */
                $logged_user = $this->session->userdata('logged_in');
                /* change the password */
                $this->user->changePassword($logged_user['id'], $this->input->post('password_new'));
                /* unset login */
                $this->session->unset_userdata('logged_in');
                /* redirect to login page */
                redirect('/', 'refresh');
            }
        }
        else
        {
            $this->load->view('/login/change_password');
        }
    }

    function current_password($password)
    {
        /* load user model */
        $this->load->model('user', '', TRUE);

        /* if the user is already logged, redirect to foregners listing page */
        if (!$this->session->userdata('logged_in'))
        {
            redirect('/', 'refresh');
        }

        /* current logged user */
        $logged_user = $this->session->userdata('logged_in');

        /* get total logged user information */
        $user_information = $this->user->get($logged_user['id']);

        if (md5($password) == $user_information[0]->password)
        {
            return TRUE;
        }
        else
        {
            /* set form validation */
            $this->form_validation->set_message('current_password', 'Current password wrong');
            return FALSE;
        }
    }

    function logout()
    {
        $this->session->unset_userdata('logged_in');
        /* session_destroy(); */
        redirect($this->config->base_url() . 'foreigners', 'refresh');
    }

}
