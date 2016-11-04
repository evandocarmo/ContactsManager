<?php

class Foreigner extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
        /* load log model */
        $this->load->model('log');
        /* load search model */
        $this->load->model('search');
    }

    function get($id = NULL, $limit = NULL, $start = NULL, $search = NULL, $not = NULL)
    {
        if (isset($search))
        {
            $this->search->executeSearch($search);
        }

        if (isset($start))
        {
            $this->db->limit($limit, $start);
        }

        $this->db->order_by('for_id', 'desc');

        $this->db->select('foreigner.for_id, foreigner.for_name, foreigner.for_nationality, foreigner.for_route, foreigner.for_street_number, foreigner.for_sublocality, foreigner.for_complement, foreigner.for_telephone, foreigner.for_locality, foreigner.for_location, foreigner.sta_id, foreigner.cat_id, COUNT(visits.vis_id) AS vis_amount');
        $this->db->from('foreigner');
        $this->db->join('visits', 'foreigner.for_id=visits.vis_foreigner', 'left');
        $this->db->group_by('foreigner.for_id');

        if (isset($id))
        {
            $this->db->where(array('for_id' => $id));
        }

        if (isset($not))
        {
            $this->db->where($not);
        }

        $query = $this->db->get();

        return $query->result();
    }

    function edit($data)
    {

        $ident = $data['for_id'];

        /* unset javascript bindings */
        unset($data['for_address']);
        unset($data['for_id']);

        /* decode the submitted strings */
        foreach ($data as $id => $row)
        {
            $newData[$id] = (empty($row)) ? utf8_decode("Uninformed") : utf8_decode(htmlentities($row, ENT_QUOTES, "UTF-8"));
        }

        /* insert the new contact */
        if (empty($ident))
        {
            $this->db->insert('foreigner', $newData);
            /* log */
            $this->log->set('INSERT', $this->db->insert_id(), 'foreigner');
        }
        /* update the existing one */
        else
        {
            $this->db->where('for_id', $ident);
            $this->db->update('foreigner', $newData);
            /* log */
            $this->log->set('UPDATE', $ident, 'foreigner');
        }
    }

}
