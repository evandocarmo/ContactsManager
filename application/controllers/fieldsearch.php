<?php

class FieldSearch extends CI_Controller
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
        $this->load->model('mfieldsearch');
        $this->load->model('qrhash');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    public function browse()
    {
        /* filter */
        $filter = array();

        if (!empty($_GET))
        {
            foreach ($_GET as $key => $val)
            {
                if (!empty($val))
                {
                    $filter[$key] = $val;
                }
            }
        }

        $data['status'] = array(
            array('sta_id' => "1", 'sta_name' => "Active"),
            array('sta_id' => "3", 'sta_name' => "Waiting")
        );
        /* pagination */
        $uri_segment    = 3;

        $data['pager'] = empty($this->uri->segment($uri_segment)) ? 0 : $this->uri->segment($uri_segment);
        $data['total'] = $this->mfieldsearch->browse(null, $filter);

        $config['base_url']        = site_url("fieldsearch/browse");
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
        $data['browse'] = $this->mfieldsearch->browse(array($data['pager'], $config['per_page']), $filter);

        /* statistcs */
        $stats            = $this->mfieldsearch->browse(false, $filter);
        $colors           = array();
        $colors['red']    = 0;
        $colors['green']  = 0;
        $colors['blue']   = 0;
        $colors['yellow'] = 0;

        foreach ($stats as $key => $value)
        {
            foreach ($value->fie_foreigners_ as $value_)
            {
                $colors[$value_[1]] ++;
            }
        }

        $data['stats'] = $colors;

        $data['unlisted'] = $this->mfieldsearch->readUnlisted();

        $this->load->view('fieldsearch/browse', $data);
    }

    public function printer($date, $group)
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];

        $data['printer'] = $this->mfieldsearch->printer($date, $group);

        $html = $this->load->view('fieldsearch/print', $data, true);

        header('Content-Type: application/pdf');

        $snappy = new Knp\Snappy\Pdf('wkhtmltopdf');

        print $snappy->getOutputFromHtml($html);

        /* print $html; */
    }

    public function add()
    {
        /* add new field service */
        $data['data'] = $this->input->post();
        $this->load->view('fieldsearch/add', $data);
    }

    public function delete($contact, $id)
    {
        $this->mfieldsearch->delete($id);
        redirect("/profile/contact/{$contact}", 'refresh');
    }

}
