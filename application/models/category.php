<?php

class Category extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructorok */
        parent::__construct();
        /* load log model */
        $this->load->model('log');
    }

    function get($id = NULL)
    {
        $SQL = " SELECT cat_id, cat_name, cat_color FROM category";

        if (!is_null($id))
        {
            $SQL .= " WHERE cat_id = {$id}";
        }

        $SQL .= " ORDER BY FIELD(cat_name, \"Unknown\") DESC, cat_name ASC";

        $query = $this->db->query($SQL);

        return $query->result();
    }

    function edit($data)
    {
        /* before persist data, remove '#' from color hex code */
        $data['cat_color'] = str_replace("#", "", $data['cat_color']);

        /* if cat_id is not set */
        if (empty($data['cat_id']))
        {
            /* make the insertion */
            $this->db->insert('category', $data);
            /* log */
            $this->log->set('INSERT', $this->db->insert_id(), 'category');
        }
        else
        {
            /* select right row */
            $this->db->where('cat_id', $data['cat_id']);
            /* make the update */
            $this->db->update('category', $data);
            /* log */
            $this->log->set('UPDATE', $data['cat_id'], 'category');
        }
    }

    function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3)
        {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        }
        else
        {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        /* return implode(",", $rgb); // returns the rgb values separated by commas */
        return array($r, $g, $b);
    }

}
