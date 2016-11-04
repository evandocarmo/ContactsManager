<?php

class Personal extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in'))
        {
            redirect('login', 'refresh');
        }

        $this->load->model('mpersonal');

        $this->load->helper('url');

        $this->load->library('user_agent');
        $this->load->library('pagination');
    }

    public function index()
    {
        redirect('/personal/phonecalls', 'refresh');
    }

    public function phonecalls()
    {
        $data = array();

        /* pagination */
        $uri_segment = 3;

        $data['pager'] = empty($this->uri->segment($uri_segment)) ? 0 : $this->uri->segment($uri_segment);
        $data['total'] = $this->mpersonal->phonecalls_browse(null);

        $config['base_url']        = site_url("personal/phonecalls");
        $config['first_url']       = $config['base_url'] . '?' . http_build_query($_GET);
        $config['total_rows']      = $data['total'];
        $config['per_page']        = 10;
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
        $data['browse'] = $this->mpersonal->phonecalls_browse(array($data['pager'], $config['per_page']));

        $this->load->view('personal/browse', $data);
    }

    public function phonerenew()
    {
        $phonerenew = $this->uri->segment(3);

        if (isset($phonerenew) && is_numeric($phonerenew))
        {
            if ($this->mpersonal->phonecalls_renew($phonerenew))
            {
                redirect($this->agent->referrer());
            }
        }
        else
        {
            show_404();
        }
    }

}
