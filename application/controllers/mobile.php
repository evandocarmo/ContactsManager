<?php

class Mobile extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('foreigner');
        $this->load->model('country');
        $this->load->model('status');
        $this->load->model('category');
        $this->load->model('qrhash');
        $this->load->model('visits');
        $this->load->model('mmobile');

        $this->load->library('form_validation');

        $this->load->helper('cookie');
        $this->load->helper('form');
    }

    public function index()
    {
        $contact = $this->input->get('contact');

        if (empty($contact))
        {
            redirect('mobile/login', 'refresh');
        }
        else
        {
            redirect("mobile/confirm?contact={$contact}", 'refresh');
        }
    }

    public function confirm()
    {
        $contact_ = $this->input->get('contact');

        if (!$this->session->userdata('logged_personal'))
        {
            $cookie = array(
                'name'   => 'contact',
                'value'  => $contact_,
                'expire' => 86500,
                'path'   => '/'
            );

            $this->input->set_cookie($cookie);

            redirect('mobile/login', 'refresh');
        }

        $contact = urldecode(base64_decode($contact_));

        $foreigner = array_shift($this->foreigner->get($contact));

        $data['foreigner'] = is_null($foreigner) ? array_shift($this->foreigner->get($contact_)) : $foreigner;
        $data['country']   = array_shift($this->country->get($data['foreigner']->for_nationality));
        $data['status']    = array_shift($this->status->get($data['foreigner']->sta_id));
        $data['category']  = array_shift($this->category->get($data['foreigner']->cat_id));
        $data['visits']    = $this->visits->get($contact);

        $this->load->view('mobile/contact', $data);
    }

    public function dashboard()
    {
        if (!$this->session->userdata('logged_personal'))
        {
            redirect('mobile/login', 'refresh');
        }

        $contact = $this->input->cookie('contact');

        if (!empty($contact))
        {
            delete_cookie('contact');

            redirect("mobile/confirm?contact={$contact}", 'refresh');
        }

        $data['info'] = $this->session->userdata('logged_personal');

        $data['fore'] = $this->mmobile->dashboard($data['info']->pus_iden);

        $this->load->view('mobile/dashboard', $data);
    }

    public function add()
    {
        if (!$this->session->userdata('logged_personal'))
        {
            redirect('mobile/login', 'refresh');
        }

        $data['messanger'] = $this->session->flashdata('messanger');

        $data['info'] = $this->session->userdata('logged_personal');

        $data['assign'] = $this->mmobile->assign($data['info']->pus_iden);

        $this->load->view('mobile/add', $data);
    }

    public function update($pet_iden)
    {
        if (!$this->session->userdata('logged_personal'))
        {
            redirect('mobile/login', 'refresh');
        }

        $pet_desc = $this->input->post('pet_desc');

        if (empty($pet_desc))
        {
            $this->session->set_flashdata('messanger', "Feedback field is required.");

            redirect('mobile/add', 'refresh');
        }

        if (!is_numeric($pet_iden))
        {
            $this->session->set_flashdata('messanger', "Error, try again later.");

            redirect('mobile/add', 'refresh');
        }

        $this->mmobile->update($pet_iden, $pet_desc);

        redirect('mobile/dashboard', 'refresh');
    }

    public function login()
    {
        if ($this->session->userdata('logged_personal'))
        {
            redirect('mobile/dashboard', 'refresh');
        }

        $data = array();

        if (!empty($_POST))
        {
            $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

            if ($this->form_validation->run() == FALSE)
            {
                $data['errors'] = validation_errors();
            }
            else
            {
                redirect('mobile/dashboard', 'refresh');
            }
        }


        $this->load->view('mobile/login', $data);
    }

    public function logout()
    {
        if (!$this->session->userdata('logged_personal'))
        {
            redirect('mobile/login', 'refresh');
        }

        $this->session->unset_userdata('logged_personal');
        /* session_destroy(); */
        redirect('mobile/login', 'refresh');
    }

    public function check_database($password)
    {

        $result = $this->mmobile->login($this->input->post('username'), $password);

        if ($result)
        {
            foreach ($result as $row)
            {
                $this->session->set_userdata('logged_personal', $row);
            }
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('check_database', 'Invalid username or password');

            return FALSE;
        }
    }

}
