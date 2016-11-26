<?php

class FieldService extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in'))
        {
            redirect('login', 'refresh');
        }

        $this->load->library("pagination");

        $this->load->model('foreigner');
        $this->load->model('mfieldservice');

        $this->load->helper('url');
        $this->load->helper('form');
    }

    public function browse()
    {
        $browse = $this->mfieldservice->browse();

        foreach ($browse as $index => $value)
        {
            $browse[$index]->foreigers = $this->mfieldservice->getForeigersByFieldservice($value->fis_iden);
        }

        $data['browse']   = $browse;
        $data['unlisted'] = $this->mfieldservice->getUnlisted();

        $this->load->view('fieldservice/browse', $data);
    }

    public function browselists()
    {
        /* pagination */
        $uri_segment = 3;

        $data['pager'] = empty($this->uri->segment($uri_segment)) ? 0 : $this->uri->segment($uri_segment);

        $data['total'] = $this->mfieldservice->browseLists();

        $config['base_url']        = site_url("fieldservice/browselists");
        $config['first_url']       = $config['base_url'] . '?' . http_build_query($_GET);
        $config['total_rows']      = $data['total'];
        $config['per_page']        = 15;
        $config['uri_segment']     = $uri_segment;
        $config['prev_link']       = 'Previous';
        $config['next_link']       = 'Next';
        $config['full_tag_open']   = '<ul>';
        $config['full_tag_close']  = '</ul>';
        $config['first_tag_open']  = '<li class="first">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open']   = '<li class="last">';
        $config['last_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="current">';
        $config['cur_tag_close']   = '</li>';
        $config['next_tag_open']   = '<li class="next">';
        $config['next_tag_close']  = '</li>';
        $config['prev_tag_open']   = '<li class="prev">';
        $config['prev_tag_close']  = '</li>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';
        $config['suffix']          = (count($_GET) > 0) ? '?' . http_build_query($_GET, '', "&") : "";

        $this->pagination->initialize($config);

        /* list all fieldsearch schedule */
        /* order by date, the most recent first */
        $data['browse'] = $this->mfieldservice->browseLists(array($data['pager'], $config['per_page']));

        $this->load->view('fieldservice/browselists', $data);
    }

    public function printer($ident)
    {
        $data['printer'] = $this->mfieldservice->printer($ident);

        $html = $this->load->view('fields/print', $data, true);

        header('Content-Type: application/pdf');
        $snappy = new Knp\Snappy\Pdf('wkhtmltopdf');
        print $snappy->getOutputFromHtml($html);

        // print $html;
    }

    public function read($identify)
    {
        $data['identify'] = $identify;

        $fieldservice = $this->mfieldservice->getForeigersByFieldservice($identify);

        $data['listings'] = $this->mfieldservice->getListByFieldservice($identify);

        $data['location'] = array();
        $data['foreigne'] = array();
        $data['for_list'] = array();

        foreach ($fieldservice as $key => $value)
        {
            $foreigner = $this->foreigner->get($value->fif_foreigner);

            $data['foreigne'][$key] = array_merge((array) $value, (array) $foreigner[0]);
            $data['location'][$key] = $foreigner[0]->for_location;

            $data['for_list'][$key] = $value->fif_foreigner;
        }

        $this->load->view('fieldservice/read', $data);
    }

    public function edit()
    {
        /* edit information */
    }

    public function addWork()
    {
        $data['fia_date'] = $this->input->post('fia_date');
        $data['fia_cond'] = $this->input->post('fia_cond');
        $data['fia_fore'] = $this->input->post('fia_fore');
        $data['fis_iden'] = $this->input->post('fis_iden');

        $valid = TRUE;

        foreach ($data as $key => $value)
        {
            if (empty($value))
            {
                $valid = FALSE;

                $this->session->set_flashdata('error', "The field '{$key}' are empty.");
            }
        }

        if ($valid)
        {
            $this->mfieldservice->addWork($data['fia_date'], $data['fia_cond'], $data['fia_fore'], $data['fis_iden']);
        }

        redirect(site_url("fieldservice/read/{$data['fis_iden']}"));
    }

    public function add()
    {
        $name = $this->input->post('name');

        if (empty($name))
        {
            $this->session->set_flashdata('error', 'Please insert a name for the territory.');
        }
        else
        {
            /* add fieldservice territory */
            $this->mfieldservice->insert($name);
        }

        redirect(site_url("fieldservice/browse"));
    }

}
