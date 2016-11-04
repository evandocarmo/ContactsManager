<?php

class Country extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
        /* load log model */
        $this->load->model('log');
    }

    function get($id = NULL, $counter = FALSE)
    {
        /* $id = ($id == 0) ? NULL : $id; */

        $filter = array();

        if (!is_null($id))
        {
            $filter['id'] = $id;
        }

        $this->db->select('country.name, country.id');

        if ($counter)
        {

            $this->db->select('COUNT(foreigner.for_nationality) AS number');
            $this->db->join('foreigner', 'foreigner.for_nationality = country.id');
            $this->db->group_by('foreigner.for_nationality');
            $this->db->order_by('number', 'desc');
        }

        $query = $this->db->get_where('country', $filter);

        return $query->result();
    }

}
