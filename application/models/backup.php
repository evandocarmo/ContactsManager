<?php

class Backup extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
        /* load log model */
        $this->load->model('log');
    }

    function get($limit = NULL, $start = NULL)
    {
        $this->db->order_by('bac_id', 'desc');

        if (isset($start))
        {
            $this->db->limit($limit, $start);
        }

        /* Query the database */
        $query = $this->db->get('backup');

        return $query->result();
    }

    function set($date)
    {
        $data['bac_id']   = NULL;
        $data['bac_date'] = $date;

        /* insert registry */
        $this->db->insert('backup', $data);

        /* return inserted id */
        return $this->db->insert_id();
    }

    function record_count()
    {
        $this->db->from('backup');

        return $this->db->count_all_results();
    }

}
