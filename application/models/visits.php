<?php

Class Visits extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
        /* load log model */
        $this->load->model('log');
    }

    function get($foreigner = NULL, $vis_id = NULL)
    {
        /* get one especific visit */
        if (isset($vis_id))
        {
            $filter = array(
                'vis_foreigner' => $foreigner,
                'vis_id'        => $vis_id
            );
        }

        /* get all visits */
        else
        {
            $filter = array('vis_foreigner' => $foreigner);
        }

        $this->db->order_by('vis_date', 'asc');

        /* make the query */
        $query = (isset($foreigner)) ? $this->db->get_where('visits', $filter) : $this->db->get('visits');

        /* return results */
        return $query->result();
    }

    function set($data, $vis_id = NULL)
    {
        /* make the validation */
        foreach ($data as $id => $row)
        {
            /* $row is not empty */
            if ($row <> '')
            {
                /* change string to scaped html entites */
                $insertion[$id] = htmlentities($row, ENT_QUOTES, "UTF-8");
            }
            /* not informed */
            else
            {
                $insertion[$id] = 'Uninformed';
            }
            /* format and sanitize date */
            if ($id == 'vis_date')
            {
                /* if date id empty (set the current date) */
                if (empty($row))
                {
                    $insertion[$id] = date('Y-m-d');
                }
                else
                {
                    $insertion[$id] = date('Y-m-d', strtotime(str_replace('/', '-', $row)));
                }
            }
        }

        if (isset($vis_id))
        {
            /* edit */
            $this->db->where('vis_id', $vis_id);
            $this->db->update('visits', $insertion);

            /* Log the Query */
            $this->log->set('UPDATE', $vis_id, 'visits');
        }
        else
        {
            /* insert */
            $this->db->insert('visits', $insertion);

            /* Log the Query */
            $this->log->set('INSERT', $this->db->insert_id(), 'visits');
        }
    }

}
