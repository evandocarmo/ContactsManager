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
        $stats = $this->mfieldsearch->browse(false, array());

        $colors = $this->evaluateColors($stats);

        $data['stats'] = $colors;

        $data['unlisted'] = $this->mfieldsearch->readUnlisted();

        $data['visits'] = $this->mstatistics->getVisits();

        /* Update Info */
        $data['update'] = $this->mdashboard->browseUpdate($this->input->post("sync"));

        $this->load->view('dashboard/browse', $data);
    }

    private function evaluateColors($stats)
    {
        $infor = array();
        foreach ($stats as $value)
        {
            foreach ($value->fie_foreigners_ as $value_)
            {
                $color = $value_[1];
                if (!isset($infor[$color]))
                {
                    $infor[$color]          = array();
                    $infor[$color]['total'] = 0;
                    $infor[$color]['label'] = $this->evaluateLabels($color);
                }
                $infor[$color]['total'] ++;
            }
        }
        return $infor;
    }

    private function evaluateLabels($color)
    {
        switch ($color)
        {
            case 'red':
                $label = "Contacts who were once assigned but not visited.";
                break;
            case 'green':
                $label = "Contacts made, but not confirmed or unconfirmed.";
                break;
            case 'blue':
                $label = "Re-assigned contacts waiting to be done.";
                break;
            case 'yellow':
                $label = "Previously assigned contacts waiting to be done.";
                break;
        }
        return $label;
    }

}
