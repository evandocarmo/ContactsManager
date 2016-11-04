<?php

class mpublishers extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
        /* load log model */
        $this->load->model('log');
    }

    function get($id = NULL)
    {
        $filter = array();

        if (!is_null($id))
        {
            $filter['pus_iden'] = $id;
        }
        else
        {
            unset($filter['pus_iden']);
        }

        $query = $this->db->order_by('pus_name', 'ASC')->get_where('personal_users', $filter);

        return $query->result();
    }

    function edit($data)
    {
        /* set default password */
        $data["pus_pass"] = $this->config->item('defaultPass');

        /* set status */
        $data["pus_stts"] = 1;

        /* insert on database */
        $this->db->insert('personal_users', $data);

        /* log */
        $this->log->set('INSERT', $this->db->insert_id(), 'personal_users');
    }

}
