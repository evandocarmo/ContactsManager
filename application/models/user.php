<?php

class User extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }

    function login($username, $password)
    {

        $this->db->select('users.id, users.username, users.password, users.loc_id, location.loc_name, location.loc_coord');
        $this->db->from('users');
        $this->db->join('location', 'location.loc_id = users.loc_id');
        $this->db->where('username', $username);
        $this->db->where('password', MD5($password));

        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1)
        {
            /* $user = $query->result_array(); */
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function get($id)
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
        $query = $this->db->get_where('users', $filter);

        return $query->result();
    }

    function changePassword($user, $password)
    {


        $this->db->where('id', $user);
        $this->db->update('users', array('password' => md5($password)));

        /* log */
        $this->log->set('UPDATE', $user, 'users');

        return TRUE;
    }

}
