<?php

class mreserved extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getPublishers()
    {

        $SQL = " SELECT publishers.pub_iden, "
                . "        publishers.pub_name  "
                . "   FROM publishers           "
                . "  ORDER BY RAND()            ";

        $query = $this->db->query($SQL);

        $data = array();

        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }

        return $data;
    }

    function browse()
    {
        $SQL = "            SELECT DATE_FORMAT(personal_reserved.per_chck, '%d/%c/%Y') AS check_date, "
                . "                   foreigner.for_name,                                                "
                . "                   foreigner.for_id,                                                  "
                . "                   publishers.pub_name,                                               "
                . "                   category.cat_name                                                  "
                . "              FROM personal_reserved                                                  "
                . "        INNER JOIN foreigner ON foreigner.for_id = personal_reserved.for_id           "
                . "        INNER JOIN publishers ON publishers.pub_iden = personal_reserved.pub_iden     "
                . "        INNER JOIN category ON category.cat_id = foreigner.cat_id                     "
                . "             WHERE sta_id = 8                                                         "
                . "          ORDER BY per_chck ASC                                                      ";

        $query = $this->db->query($SQL);

        $data = array();

        foreach ($query->result() as $id => $row)
        {
            $data[$id] = $row;

            if (strtotime(str_replace('/', '-', $row->check_date)) > strtotime('-14 days'))
            {
                $data[$id]->color = 'green';
            }
            else
            {
                $data[$id]->color = 'red';
            }
        }

        return $data;
    }

    function getReturnVisit($foreigner)
    {
        $SQL = " SELECT pub_iden             "
                . "  FROM personal_reserved     "
                . " WHERE for_id = {$foreigner} ";

        $pub_iden = $this->db->query($SQL)->row();

        return (is_object($pub_iden)) ? $pub_iden->pub_iden : FALSE;
    }

    function getUnlisted()
    {
        $SQL = "    SELECT foreigner.for_id                            "
                . "      FROM foreigner                                   "
                . " LEFT JOIN personal_reserved                           "
                . "        ON personal_reserved.for_id = foreigner.for_id "
                . "     WHERE foreigner.sta_id = 8                        "
                . "       AND personal_reserved.per_iden IS NULL          ";

        $query = $this->db->query($SQL);

        $data = array();

        foreach ($query->result() as $id => $row)
        {
            $data[$id] = $row;
        }

        return $data;
    }

    function setReturnVisit($pub_iden, $vis_foreigner)
    {
        /* delete que contact from the return visit table */
        $this->db->where('for_id', $vis_foreigner);
        $this->db->delete('personal_reserved');

        /* add the contact with the publisher */
        $data = array(
            'per_chck' => date('Y-m-d H:i:s'),
            'pub_iden' => $pub_iden,
            'for_id'   => $vis_foreigner
        );

        $this->db->insert('personal_reserved', $data);
    }

}
