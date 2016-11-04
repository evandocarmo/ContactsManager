<?php

class Log extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }

    function set($log_action, $log_effect, $log_type, $log_user = NULL)
    {
        $user = $this->session->userdata('logged_in');

        if ($log_user == NULL)
        {
            $log['log_user'] = $user['id'];
        }
        else
        {
            $log['log_user'] = $log_user;
        }

        $log['log_action'] = $log_action;
        $log['log_effect'] = $log_effect;
        $log['log_type']   = $log_type;
        $log['log_date']   = date('Y-m-d H:i:s');

        $this->db->insert('log', $log);
    }

    function get($id = NULL)
    {
        if (isset($id))
        {
            $filter = array('id' => $id);
        }
        else
        {
            $filter = array();
        }

        /* Query the database */
        $query = $this->db->order_by('log_date', 'DESC')->get_where('log', $filter);

        return $query->result();
    }

}
