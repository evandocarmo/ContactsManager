<?php

class mpublishers extends CI_Model
{

    public function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
        /* load log model */
        $this->load->model('log');

        $this->load->library('encrypt');
    }

    public function get($id = NULL)
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

        $return = array();

        foreach ($query->result() as $value)
        {
            $index = str_replace('%2F', '--', urlencode($this->encrypt->encode($value->pus_iden)));

            $return[$index] = $value;
        }

        return $return;
    }

    public function add($data)
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

    public function edit($index, $data)
    {
        /* Edit */
        $this->db->where('pus_iden', $index);
        $this->db->update('personal_users', $data);

        /* Log the Query */
        $this->log->set('UPDATE', $index, 'personal_users');
    }

}
