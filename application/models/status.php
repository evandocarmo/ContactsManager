<?php

class Status extends CI_Model
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
            $filter['sta_id'] = $id;
        }
        else
        {
            unset($filter['sta_id']);
        }

        $query = $this->db->get_where('status', $filter);

        return $query->result();
    }

    function edit($data)
    {
        if (empty($data['sta_id']))
        {
            $this->db->insert('status', $data);
            /* log */
            $this->log->set('INSERT', $this->db->insert_id(), 'status');
        }
        else
        {
            $this->db->where('sta_id', $data['sta_id']);
            $this->db->update('status', $data);
            /* log */
            $this->log->set('UPDATE', $data['sta_id'], 'status');
        }
    }

}
