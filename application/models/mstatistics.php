<?php

class mStatistics extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }

    function getVisits()
    {
        $query = $this->db
                ->select('YEAR(vis_date) AS YEAR, MONTH(vis_date) AS MONTH, COUNT(vis_id) AS COUNT')
                ->from('visits')
                ->group_by('YEAR(vis_date)')
                ->group_by('MONTH(vis_date)')
                ->where('vis_date >= DATE_SUB(NOW(), INTERVAL 1 YEAR)')
                ->get();

        return $query->result();
    }

}
