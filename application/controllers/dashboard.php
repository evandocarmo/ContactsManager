<?php

class DashBoard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in'))
        {
            redirect('login', 'refresh');
        }

        $this->load->model('mdashboard');
        $this->load->model('mstatistics');
    }

    public function index()
    {
        $this->load->model('mfieldsearch');
        $this->load->model('mfieldservice');

        /* statistcs */
        $stats            = $this->mfieldsearch->browse(false, array());
        $colors           = array();
        $colors['red']    = 0;
        $colors['green']  = 0;
        $colors['blue']   = 0;
        $colors['yellow'] = 0;

        foreach ($stats as $value)
        {
            foreach ($value->fie_foreigners_ as $value_)
            {
                $colors[$value_[1]] ++;
            }
        }

        $data['stats'] = $colors;

        $data['unlisted'] = $this->mfieldsearch->readUnlisted();

        $data['visits'] = $this->mstatistics->getVisits();

        /* Update Info */
        $data['update'] = $this->mdashboard->browseUpdate($this->input->post("sync"));

        $this->load->view('dashboard/browse', $data);
    }

}
