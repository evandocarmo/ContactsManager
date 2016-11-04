<?php

class General extends CI_Controller
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
    }

    public function index()
    {
        if (!$this->session->userdata('logged_personal'))
        {
            redirect('mobile/login', 'refresh');
        }

        $data['foreigner'] = $this->foreigner->get();

        $this->load->view('general/list', $data);
    }

}
