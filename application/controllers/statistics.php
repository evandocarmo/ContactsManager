<?php

class Statistics extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in'))
        {
            redirect('login', 'refresh');
        }

        $this->load->model('country');
        $this->load->model('status');
        $this->load->model('category');
        $this->load->model('foreigner');
        $this->load->model('visits');
        $this->load->model('mstatistics');
        $this->load->model('mfieldservice');
    }

    public function heatmap()
    {

        $data['table'] = $this->foreigner->get(null, null, null, null, "foreigner.sta_id != 2");
        $data['user']  = $this->session->userdata('logged_in');

        $this->load->view('statistics/heatmap', $data);
    }

    public function foreigners()
    {

        $data['user'] = $this->session->userdata('logged_in');

        $data['country']  = $this->country->get(NULL, TRUE);
        $data['status']   = $this->status->get();
        $data['category'] = $this->category->get();

        $query_string = explode('&p=', $this->input->server("REQUEST_URI"));

        if ($this->input->get())
        {
            $search             = $this->input->get();
            $config['base_url'] = $query_string[0];
        }
        else
        {
            $search             = NULL;
            $config['base_url'] = base_url('foreigners/contacts?');
        }

        foreach ($this->foreigner->get(null, null, null, $search, "foreigner.sta_id != 2") as $key => $row)
        {

            $pais     = $this->country->get($row->for_nationality);
            $status   = $this->status->get($row->sta_id);
            $category = $this->category->get($row->cat_id);

            $row->for_country      = (empty($pais)) ? "Uninformed" : $pais[0]->name;
            $row->for_status       = (empty($status)) ? "Uninformed" : $status[0]->sta_name;
            $row->for_category     = (empty($category)) ? "Uninformed" : $category[0]->cat_name;
            $row->for_fieldservice = $this->mfieldservice->getFieldserviceByForeiger($row->for_id);

            $data['table'][$key] = $row;
        }

        $data['fieldservice'] = $this->mfieldservice->browse();

        $data['fif_foreigner'] = $this->uri->segment(3);

        $this->load->view('statistics/foreigners', $data);
    }

    public function loginformation()
    {

        $this->load->model('log');
        $this->load->model('user');

        foreach ($this->log->get() as $id => $row)
        {
            $row->log_username = $this->user->get($row->log_user);
            $log[$id]          = $row;
        }

        $data['log'] = $log;

        $this->load->view('statistics/log', $data);
    }

}
