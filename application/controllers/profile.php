<?php

class Profile extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in'))
        {
            redirect('login', 'refresh');
        }

        $this->load->model('user', '', TRUE);
        $this->load->model('foreigner');
        $this->load->model('visits');
        $this->load->model('country');
        $this->load->model('status');
        $this->load->model('category');
        $this->load->model('mfieldsearch');
        $this->load->model('mfieldservice');
        $this->load->model('mreserved');

        $this->load->library('encrypt');
    }

    public function fieldsearch()
    {
        $fie_foreigner = $this->uri->segment(3);
        $fie_date      = $this->input->post('fie_date');
        $fie_conductor = $this->input->post('fie_conductor');
        $fie_group     = $this->input->post('fie_group');

        $this->mfieldsearch->add($fie_foreigner, $fie_date, $fie_conductor, $fie_group);

        redirect("profile/contact/{$fie_foreigner}", 'refresh');
    }

    public function fieldservice()
    {
        $fif_foreigner = $this->uri->segment(3);
        $argument      = $this->uri->segment(4);

        $fif_fieldservice = $this->input->post('fif_fieldservice');

        $this->mfieldservice->add($fif_foreigner, $fif_fieldservice);

        if ($argument)
        {
            redirect("statistics/foreigners/{$fif_foreigner}", 'refresh');
        }
        else
        {
            redirect("profile/contact/{$fif_foreigner}", 'refresh');
        }
    }

    public function contact($id = NULL, $visit = NULL)
    {

        if (!is_null($id) && !is_null($visit))
        {
            /* load the requested visit */
            $data['visit'] = $this->visits->get($id, $visit);
            /* submit the changed visit */
            if ($this->input->post())
            {
                /* insert or edit visit */
                $this->visits->set($this->input->post(), $visit);
                /* redirect user to visited foreigner page */
                redirect("profile/contact/{$id}", 'refresh');
            }
        }
        else if (!is_null($id) && $this->input->post())
        {
            /* define the foreigner data */
            $changedData = $this->input->post();

            /* define the foreigner id */
            $changedData['vis_foreigner'] = $id;

            /* insert or edit visit */
            $this->visits->set($changedData, $visit);

            /* redirect user to visited foreigner page */
            redirect("profile/contact/{$id}", 'refresh');
        }

        $foreigner       = $this->foreigner->get($id);
        $visits          = $this->visits->get($id);
        $fieldsearch     = $this->mfieldsearch->browseForeigners($id);
        $for_nationality = $this->country->get($foreigner[0]->for_nationality);

        $data['id']          = $id;
        $data['foreigner']   = $foreigner[0];
        $data['fieldsearch'] = $fieldsearch;
        $data['visits']      = $visits;

        $data['messages'] = urldecode($this->encrypt->decode($this->input->get('m')));

        $data['for_nationality'] = (empty($for_nationality)) ? "unknown" : $for_nationality[0]->name;
        $data['sta_id']          = $this->status->get($foreigner[0]->sta_id);
        $data['cat_id']          = $this->category->get($foreigner[0]->cat_id);
        $data['fieldservice']    = $this->mfieldservice->browse();
        $data['fieldservic_']    = $this->mfieldservice->getFieldserviceByForeiger($id);

        if ($data['sta_id'][0]->sta_name == 'Reserved')
        {
            $data['publishers']  = $this->mreserved->getPublishers();
            $data['publishers_'] = $this->mreserved->getReturnVisit($id);
        }

        $this->load->view('visits/index', $data);
    }

    public function elders($id = NULL)
    {
        if (is_null($id))
        {
            redirect('login', 'refresh');
        }

        $for = $this->foreigner->get($id);
        $vis = $this->visits->get($id);
        $nat = $this->country->get($for[0]->for_nationality);

        $data["for"] = $for[0];
        $data["vis"] = $vis[0];
        $data["nat"] = $nat;


        $html = $this->load->view('visits/elders', $data, true);

        header('Content-Type: application/pdf');

        $snappy = new Knp\Snappy\Pdf('wkhtmltopdf');

        print $snappy->getOutputFromHtml($html);
    }

    public function setReturnVisitUpdate($vis_foreigner)
    {
        $pub_iden = $this->input->post('pub_iden');

        if (is_numeric($pub_iden) && is_numeric($vis_foreigner))
        {
            $this->mreserved->setReturnVisit($pub_iden, $vis_foreigner);

            redirect("/profile/contact/{$vis_foreigner}", 'refresh');
        }
        else
        {
            redirect("/foreigners/contacts", 'refresh');
        }
    }

    public function form($foreigner, $vis_id = NULL)
    {

        /* verify if $_POST was made */
        if ($this->input->post())
        {
            /* insert or edit visit */
            $this->visits->set($this->input->post(), $vis_id);

            /* redirect user to visited foreigner page */
            redirect('/perfil/index/' . $this->input->post('foreigner'), 'refresh');
        }

        /* visit if is set */
        $visit = (isset($vis_id)) ? $this->visits->get($foreigner, $vis_id) : array();

        $data['visit'] = (isset($vis_id)) ? $visit[0] : array();

        /* set user id to view hidden element */
        $data['id'] = $foreigner;

        $this->load->view('visits/form', $data);
    }

}
