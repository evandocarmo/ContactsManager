<?php

use GabrielKaputa\Bitly\Bitly;

class mFieldSearch extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
        /* load log model */
        $this->load->model('log');
        $this->load->model('qrhash');
    }

    function browse($limit = null, $filter = array())
    {
        $SQL = "        SELECT fie_date, fie_id, fie_group,                                        "
                . "            GROUP_CONCAT(DISTINCT fieldsearch.fie_foreigner) AS fie_foreigners, "
                . "            GROUP_CONCAT(DISTINCT fieldsearch.fie_conductor) AS fie_conductors, "
                . "            UNIX_TIMESTAMP(fie_date) AS fie_timestamp                           "
                . "       FROM fieldsearch                                                         "
                . " INNER JOIN foreigner                                                           "
                . "         ON foreigner.for_id = fieldsearch.fie_foreigner                        ";

        $SQL .= " GROUP BY fieldsearch.fie_date, fieldsearch.fie_group ";
        $SQL .= " ORDER BY fieldsearch.fie_date DESC ";

        /* SQL of Pagination */
        $SQL   .= (!is_null($limit) && $limit) ? " LIMIT {$limit[0]}, {$limit[1]} " : "";
        $query = $this->db->query($SQL);
        if (is_null($limit))
        {
            return $query->num_rows();
        }
        else
        {
            $return = array();
            foreach ($query->result() as $id => $value)
            {
                $foreigners  = explode(',', $value->fie_foreigners);
                $return[$id] = $value;
                foreach ($foreigners as $foreigner)
                {
                    $visit  = $this->mfieldsearch->browseVisits($foreigner, $value->fie_date);
                    $assign = $this->mfieldsearch->browseAssign($foreigner);
                    $today  = new DateTime();
                    $viday  = new DateTime($value->fie_date);
                    $asday  = new DateTime($assign);
                    $color  = "yellow";
                    if ($today > $viday && $visit == FALSE)
                    {
                        if ($asday > $viday)
                        {
                            $color = "blue";
                        }
                        else
                        {
                            $color = "red";
                        }
                    }
                    if ($today > $viday && $visit == TRUE)
                    {
                        $color = "green";
                    }
                    $return[$id]->fie_foreigners_[$foreigner] = array(
                        $foreigner, $color
                    );
                }
            }
            return $return;
        }
    }

    function browseAssign($foreigner)
    {
        $SQL    = "   SELECT fie_date                        "
                . "     FROM fieldsearch                 "
                . "    WHERE fie_foreigner = {$foreigner} "
                . " ORDER BY fie_date DESC                "
                . "    LIMIT 0, 1                         ";
        $result = $this->db->query($SQL)->result();
        $return = NULL;
        foreach ($result as $value)
        {
            $return = $value->fie_date;
        }
        return $return;
    }

    function browseVisits($foreigner, $date)
    {
        $SQL = "   SELECT COUNT(*) AS COUNT                                 "
                . "     FROM log                                            "
                . "    WHERE log_type = 'foreigner'                         "
                . "      AND DATE_ADD(log_date, INTERVAL 1 DAY) > '{$date}' "
                . "      AND log_effect = '{$foreigner}'                    "
                . " ORDER BY log_id DESC                                    ";

        $result = $this->db->query($SQL)->result();

        if ($result[0]->COUNT == "0")
        {
            $SQL_ = " SELECT COUNT(*) AS COUNT_                               "
                    . "  FROM visits                                          "
                    . " WHERE vis_foreigner = '{$foreigner}'                  "
                    . "   AND DATE_ADD(vis_date, INTERVAL 1 DAY) > '{$date}'  ";

            $result_ = $this->db->query($SQL_)->result();

            if ($result_[0]->COUNT_ == "0")
            {
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
        else
        {
            return TRUE;
        }
    }

    function browseForeigners($foreigner)
    {
        $SQL = " SELECT fie_id, fie_foreigner, fie_group,    "
                . "       fie_date, fie_conductor            "
                . "  FROM fieldsearch                        "
                . " WHERE fie_foreigner = {$foreigner}       ";

        $result = $this->db->query($SQL)->result();

        $return = array();

        foreach ($result as $key => $value)
        {
            $value->fie_datef   = date('d/m/Y', strtotime($value->fie_date));
            $value->fie_display = TRUE;
            if (new DateTime() > new DateTime($value->fie_date))
            {
                $value->fie_display = FALSE;
            }
            $return[$key] = $value;
        }

        return $return;
    }

    function setShortURL($for_id, $link)
    {
        $this->db->where('for_id', $for_id);
        $this->db->update('foreigner', array('for_bitly' => $link));
    }

    function printer($fie_timestamp, $fie_group)
    {
        $SQL = "     SELECT DATE_FORMAT(fie_date, '%d/%c/%Y') AS `date`,      "
                . "            COUNT(vis_id) AS visits, fie_foreigner, for_bitly,"
                . "            fie_conductor, for_id, for_name, for_route,       "
                . "            country.name, for_street_number, cat_name,        "
                . "            for_sublocality, for_complement, sta_name,        "
                . "            for_telephone, for_locality, for_location         "
                . "       FROM fieldsearch                                       "
                . " INNER JOIN foreigner                                         "
                . "         ON fieldsearch.fie_foreigner = foreigner.for_id      "
                . " INNER JOIN category                                          "
                . "         ON category.cat_id = foreigner.cat_id                "
                . " INNER JOIN status                                            "
                . "         ON status.sta_id = foreigner.sta_id                  "
                . "  LEFT JOIN country                                           "
                . "         ON country.id = foreigner.for_nationality            "
                . "  LEFT JOIN visits                                            "
                . "         ON visits.vis_foreigner = fieldsearch.fie_foreigner  "
                . "      WHERE UNIX_TIMESTAMP(fie_date) = '{$fie_timestamp}'     "
                . "        AND fie_group = '{$fie_group}'                        "
                . "   GROUP BY for_id;                                           ";

        $query = $this->db->query($SQL);

        $data = array();

        $basepath = BASEPATH . "../";

        $ciqrcode = new Ciqrcode();

        foreach ($query->result() as $row)
        {
            $data[] = $row;

            $public_access = base_url() . "mobile?contact={$row->fie_foreigner}";

            /*
             * Bit.ly generation
             */
            if (is_null($row->for_bitly))
            {
                $bitly = Bitly::withGenericAccessToken($this->config->item('bitly'));

                $result = $bitly->shortenUrl($public_access);

                $this->setShortURL($row->for_id, $result);

                $row->for_bitly = $result;
            }

            /*
             * QRCode generation
             */
            $qrcode['data']     = $row->for_bitly;
            $qrcode['level']    = 'H';
            $qrcode['size']     = 2;
            $qrcode['savename'] = $basepath . "assets/img/qrcode/{$row->fie_foreigner}.png";

            $ciqrcode->generate($qrcode);
        }

        return $data;
    }

    function readUnlisted()
    {
        $SQL = "     SELECT foreigner.for_id                            "
                . "      FROM foreigner                                    "
                . " LEFT JOIN fieldsearch                                  "
                . "        ON fieldsearch.fie_foreigner = foreigner.for_id "
                . "     WHERE foreigner.sta_id = 3                         "
                . "       AND fieldsearch.fie_id IS NULL                   "
                . "  GROUP BY foreigner.for_id                             ";

        $query = $this->db->query($SQL);

        $data = array();

        foreach ($query->result() as $row)
        {
            $data[] = $row->for_id;
        }

        return $data;
    }

    function add($fie_foreigner, $fie_date, $fie_conductor, $fie_group)
    {
        $strptime = new Strptime();

        $date                  = $strptime->getStrptime($fie_date, '%d/%m/%Y');
        $stmp                  = mktime(0, 0, 0, $date['tm_mon'] + 1, $date['tm_mday'], 1900 + $date['tm_year']);
        $data['fie_id']        = null;
        $data['fie_foreigner'] = $fie_foreigner;
        $data['fie_date']      = date('Y-m-d', $stmp);
        $data['fie_conductor'] = $fie_conductor;
        $data['fie_group']     = $fie_group;

        $this->db->insert('fieldsearch', $data);
    }

    function delete($id)
    {
        $this->db->where('fie_id', $id);
        $this->db->delete('fieldsearch');
    }

}
