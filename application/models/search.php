<?php

class Search extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }

    function recordCount($id = NULL, $limit = NULL, $start = NULL, $search = NULL)
    {
        if (isset($search))
        {
            $this->search->executeSearch($search);
        }
        $this->db->order_by('for_id', 'desc');
        $this->db->select('for_id');
        $this->db->from('foreigner');
        $this->db->join('visits', 'foreigner.for_id=visits.vis_foreigner', 'left');
        $this->db->group_by('foreigner.for_id');
        if (isset($id))
        {
            array('for_id' => $id);
        }
        $query  = $this->db->get();
        $result = count($query->result());
        return $result;
    }

    function executeSearch($search)
    {
        foreach ($search as $key => $value)
        {
            if ($key == "p")
            {
                continue;
            }
            else if ($key == "for_name" && !empty($value))
            {
                $this->db->like($key, $value);
            }
            else if ($key == "for_id" && !empty($value))
            {
                $this->db->where($key, $value);
            }
            else if ($key == "vis_amount" && ($value == "0" || !empty($value)))
            {
                $this->db->having('COUNT(visits.vis_id)', $value);
            }
            else if ($value <> "ALL" && $key <> "for_name" && $key <> "for_id" && $key <> "vis_amount")
            {
                $this->db->where($key, $value);
            }
        }
    }

}
