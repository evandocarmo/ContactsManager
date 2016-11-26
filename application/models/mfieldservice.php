<?php

use GabrielKaputa\Bitly\Bitly;

class mfieldservice extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function browse()
    {
        $SQL = " SELECT fis_iden, fis_name "
                . "   FROM fieldservice;      ";

        $query = $this->db->query($SQL);

        $data = array();

        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }

        return $data;
    }

    function getUnlisted()
    {
        $SQL = "    SELECT for_id                                                  "
                . "      FROM foreigner                                               "
                . " LEFT JOIN fieldservice_foreigner                                  "
                . "        ON fieldservice_foreigner.fif_foreigner = foreigner.for_id "
                . "     WHERE fif_iden IS NULL                                        "
                . "       AND sta_id = 1                                              ";

        $query = $this->db->query($SQL);

        $data = array();

        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }

        return $data;
    }

    function getFieldserviceByForeiger($fif_foreigner)
    {
        $SQL = " SELECT fif_fieldservice                 "
                . "   FROM fieldservice_foreigner           "
                . "  WHERE fif_foreigner = {$fif_foreigner} ";

        $query = $this->db->query($SQL);

        if ($query->num_rows() > 0)
        {
            $row = $query->row();
        }

        return isset($row) ? $row->fif_fieldservice : null;
    }

    function browseAssign($foreigner)
    {
        $SQL = "   SELECT fia_date                                "
                . "     FROM fieldservice_assignments                   "
                . "    WHERE find_in_set('{$foreigner}', fia_fore) <> 0 "
                . " ORDER BY fia_date DESC                "
                . "    LIMIT 0, 1                         ";

        $result = $this->db->query($SQL)->result();
        $return = NULL;
        foreach ($result as $value)
        {
            $return = $value->fia_date;
        }
        return $return;
    }

    function browseVisits($foreigner, $date)
    {
        $SQL    = "   SELECT COUNT(*) AS COUNT                                 "
                . "     FROM log                                            "
                . "    WHERE log_type = 'foreigner'                         "
                . "      AND DATE_ADD(log_date, INTERVAL 1 DAY) > '{$date}' "
                . "      AND log_effect = '{$foreigner}'                    "
                . " ORDER BY log_id DESC                                    ";
        $result = $this->db->query($SQL)->result();
        if ($result[0]->COUNT == "0")
        {
            $SQL_    = " SELECT COUNT(*) AS COUNT_                               "
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

    function browseLists($limit = null)
    {
        $SQL = "        SELECT fia_iden, fis_iden, fia_date, fia_cond,                                        \n"
                . "               GROUP_CONCAT(DISTINCT CONCAT(visits.vis_foreigner, ' ', visits.vis_date)       \n"
                . "                            ORDER BY visits.vis_foreigner ASC, visits.vis_date ASC            \n"
                . "                           SEPARATOR ';') AS vis_,                                            \n"
                . "               GROUP_CONCAT(DISTINCT CONCAT(log.log_effect, ' ', log.log_date)                \n"
                . "                            ORDER BY log.log_effect ASC, log.log_date ASC                     \n"
                . "                           SEPARATOR ';') AS log_                                             \n"
                . "          FROM fieldservice_assignments                                                       \n"
                . "    INNER JOIN visits ON FIND_IN_SET(visits.vis_foreigner, fieldservice_assignments.fia_fore) \n"
                . "    INNER JOIN log ON FIND_IN_SET(log.log_effect, fieldservice_assignments.fia_fore)          \n"
                . "         WHERE log_type = 'foreigner'                                                         \n"
                . "      GROUP BY fieldservice_assignments.fia_iden                                              \n"
                . "      ORDER BY fieldservice_assignments.fia_iden DESC                                         \n";

        /* pagination QUERY setup */
        $SQL .= (!is_null($limit) && $limit) ? " LIMIT {$limit[0]}, {$limit[1]} " : "";

        $query = $this->db->query($SQL);

        if (is_null($limit))
        {
            return $query->num_rows();
        }
        else
        {
            $return = array();

            foreach ($query->result() as $key => $value)
            {

                $return[$key]         = $value;
                $return[$key]->visits = array();

                $visists = explode(';', $value->vis_);

                foreach ($visists as $visit)
                {
                    $vis_ = explode(' ', $visit);

                    $return[$key]->visits[$vis_[0]]['vis_'] = $vis_[1];
                }

                $logs = explode(';', $value->log_);

                foreach ($logs as $log)
                {
                    $log_ = explode(' ', $log);

                    $return[$key]->visits[$log_[0]]['log_'] = $log_[1];
                }

                foreach ($return[$key]->visits as $for_ => $dates)
                {
                    $log_ = isset($dates['log_']) && !empty($dates['log_']) ? $dates['log_'] : '2013-01-01';
                    $vis_ = isset($dates['vis_']) && !empty($dates['vis_']) ? $dates['vis_'] : $log_;

                    $today = new DateTime();
                    $viday = (new DateTime($vis_) > new DateTime($log_)) ? new DateTime($vis_) : new DateTime($log_);
                    $asday = new DateTime($value->fia_date);

                    $color = ($today > $asday) ? ($viday > $asday) ? "green" : "red" : "yellow";

                    $return[$key]->visits[$for_]['col_'] = $color;
                }
            }

            return $return;
        }
    }

    function getListByFieldservice($fif_fieldservice)
    {
        $SQL = " SELECT fia_iden, fis_iden, fia_date, "
                . "       fia_cond, fia_fore             "
                . "  FROM fieldservice_assignments       "
                . " WHERE fis_iden = {$fif_fieldservice} ";

        $query = $this->db->query($SQL);

        $data = array();

        foreach ($query->result() as $id => $row)
        {
            $data[$id] = $row;

            $foreigners = explode(',', $row->fia_fore);

            foreach ($foreigners as $foreigner)
            {
                $this->load->model('mfieldsearch');

                $visit  = $this->mfieldservice->browseVisits($foreigner, $row->fia_date);
                $assign = $this->mfieldservice->browseAssign($foreigner);
                $today  = new DateTime();
                $viday  = new DateTime($row->fia_date);
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
                $data[$id]->fie_foreigners_[$foreigner] = array(
                    $foreigner, $color
                );
            }

            $data[$id]->fia_show = TRUE;

            if (new DateTime() >= new DateTime($row->fia_date))
            {
                $data[$id]->fia_show = FALSE;
            }
        }



        return $data;
    }

    function getForeigersByFieldservice($fif_fieldservice)
    {
        $SQL = "    SELECT fieldservice_foreigner.fif_foreigner,                           "
                . "            MAX(visits.vis_date) AS vis_date                            "
                . "       FROM fieldservice_foreigner                                      "
                . "  LEFT JOIN visits                                                      "
                . "         ON visits.vis_foreigner = fieldservice_foreigner.fif_foreigner "
                . " INNER JOIN foreigner                                                   "
                . "         ON foreigner.for_id = fieldservice_foreigner.fif_foreigner     "
                . "      WHERE fif_fieldservice = {$fif_fieldservice}                      "
                . "        AND foreigner.sta_id = 1                                        "
                . "   GROUP BY fif_foreigner                                               "
                . "   ORDER BY vis_date IS NULL DESC, vis_date ASC                         ";

        $query = $this->db->query($SQL);

        $data = array();

        foreach ($query->result() as $id => $row)
        {
            $data[$id] = $row;

            $data[$id]->color = 'green';

            if (empty($row->vis_date))
            {
                $data[$id]->color = 'orange';
            }
            elseif (strtotime($row->vis_date) > strtotime('-1 month'))
            {
                $data[$id]->color = 'green';
            }
            elseif (strtotime($row->vis_date) > strtotime('-2 months'))
            {
                $data[$id]->color = 'blue';
            }
            elseif (strtotime($row->vis_date) > strtotime('-3 months'))
            {
                $data[$id]->color = 'yellow';
            }
            elseif (strtotime($row->vis_date) < strtotime('-3 months'))
            {
                $data[$id]->color = 'red';
            }
        }

        return $data;
    }

    function add($fif_foreigner, $fif_fieldservice)
    {
        $this->db->where('fif_foreigner', $fif_foreigner);
        $this->db->delete('fieldservice_foreigner');

        $data['fif_foreigner']    = $fif_foreigner;
        $data['fif_fieldservice'] = $fif_fieldservice;

        $this->db->insert('fieldservice_foreigner', $data);
    }

    function addWork($fia_date, $fia_cond, $fia_fore, $fis_iden)
    {
        $d = explode("/", $fia_date);

        $data['fia_date'] = "{$d[2]}-{$d[1]}-{$d[0]}";
        $data['fia_cond'] = $fia_cond;
        $data['fia_fore'] = $fia_fore;
        $data['fis_iden'] = $fis_iden;

        $this->db->insert('fieldservice_assignments', $data);
    }

    function insert($fis_name)
    {
        $data['fis_name'] = $fis_name;

        $this->db->insert('fieldservice', $data);
    }

    function delete($fis_iden)
    {
        $this->db->where('fis_iden', $fis_iden);
        $this->db->delete('fieldservice');
    }

    function setShortURL($for_id, $link)
    {
        $this->db->where('for_id', $for_id);
        $this->db->update('foreigner', array('for_bitly' => $link));
    }

    function printer($fieldservice)
    {
        $SQL = "     SELECT COUNT(visits.vis_id) AS visits, foreigner.for_id,                    "
                . "            MAX(visits.vis_date) AS vis_date, foreigner.for_name,                "
                . "            foreigner.for_route, foreigner.for_telephone, foreigner.for_bitly,   "
                . "            foreigner.for_locality, foreigner.for_location,                      "
                . "            foreigner.for_sublocality, foreigner.for_complement,                 "
                . "            foreigner.for_street_number, country.name, category.cat_name,        "
                . "            status.sta_name, fieldservice_assignments.fia_date,                  "
                . "            fieldservice_assignments.fia_cond, fieldservice.fis_iden,            "
                . "            fieldservice.fis_name  "
                . "       FROM foreigner                                                            "
                . " INNER JOIN fieldservice_foreigner                                               "
                . "         ON fieldservice_foreigner.fif_foreigner = foreigner.for_id              "
                . " INNER JOIN fieldservice                                                         "
                . "         ON fieldservice.fis_iden = fieldservice_foreigner.fif_fieldservice      "
                . " INNER JOIN fieldservice_assignments                                             "
                . "         ON fieldservice_assignments.fis_iden = fieldservice.fis_iden            "
                . "  LEFT JOIN category                                                             "
                . "         ON category.cat_id = foreigner.cat_id                                   "
                . "  LEFT JOIN status                                                               "
                . "         ON status.sta_id = foreigner.sta_id                                     "
                . "  LEFT JOIN country                                                              "
                . "         ON country.id = foreigner.for_nationality                               "
                . "  LEFT JOIN visits                                                               "
                . "         ON visits.vis_foreigner = foreigner.for_id                              "
                . "      WHERE fieldservice_assignments.fia_iden = {$fieldservice}                  "
                . "        AND foreigner.sta_id = 1                                                 "
                . "   GROUP BY foreigner.for_id                                                     "
                . "   ORDER BY vis_date ASC                                                         ";

        $query = $this->db->query($SQL);

        $data = array();

        $basepath = BASEPATH . "../";
        
        $ciqrcode = new Ciqrcode();

        foreach ($query->result() as $id => $row)
        {
            $data[$id] = $row;

            if (empty($row->vis_date))
            {
                $data[$id]->message = 'This contact was <strong>never visited before</strong>, please make this visit as <strong>soon as possible</strong>.';
            }
            elseif (strtotime($row->vis_date) > strtotime('-1 month'))
            {
                $data[$id]->message = 'This contact was <strong>visited</strong> in less than a month.';
            }
            elseif (strtotime($row->vis_date) > strtotime('-2 months'))
            {
                $data[$id]->message = 'This contact was visited <strong>over a month ago</strong>, please make it as a <strong>priority</strong>.';
            }
            elseif (strtotime($row->vis_date) > strtotime('-3 months'))
            {
                $data[$id]->message = 'This contact was visited <strong>over two months ago</strong>, please make it as a <strong>high priority</strong>.';
            }
            elseif (strtotime($row->vis_date) < strtotime('-3 months'))
            {
                $data[$id]->message = 'This contact was visited <strong>over three months ago</strong>, please make it as a <strong>very high priority</strong>.';
            }

            $contact = urlencode(base64_encode($row->for_id));

            /* $contact = $row->for_id; */

            $public_access = base_url() . "mobile?contact={$contact}";

            /* print "{$public_access}<br />"; */

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
            $qrcode['savename'] = $basepath . "assets/img/qrcode/{$row->for_id}.png";

            $ciqrcode->generate($qrcode);
        }

        return $data;
    }

}
