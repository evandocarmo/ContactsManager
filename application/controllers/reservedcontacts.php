<?php

class ReservedContacts extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in'))
        {
            redirect('login', 'refresh');
        }

        $this->load->model('mreserved');

        $this->load->helper('url');
    }

    public function check($for_iden)
    {
        $this->db->where('for_id', $for_iden);
        $this->db->update('personal_reserved', array('per_chck' => date('Y-m-d H:i:s')));

        redirect("/reservedcontacts/browse", 'refresh');
    }

    public function browse()
    {
        $data['browse'] = $this->mreserved->browse();

        $data['unlisted'] = $this->mreserved->getUnlisted();

        $this->load->view('reservedcontacts/browse', $data);
    }

}
