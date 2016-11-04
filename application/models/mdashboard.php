<?php

class mDashBoard extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();

        /* load log model */
        $this->load->model('log');
    }

    function browseUpdate($makeFill = false)
    {
        $interval = ($makeFill) ? 3 : 12;

        $SQL = "      SELECT SUM(if(log_action = 'UPDATE', 1, 0)) AS updates,       "
                . "          SUM(if(log_action = 'INSERT', 1, 0)) AS inserts,       "
                . "          DATE_FORMAT(log_date, '%d/%m/%Y') AS date              "
                . "     FROM log                                                    "
                . "    WHERE log_action <> 'SELECT'                                 "
                . "      AND log_date > DATE_SUB(NOW(), INTERVAL {$interval} MONTH) "
                . " GROUP BY date                                                   "
                . " ORDER BY log_id ASC                                             ";

        $result = $this->db->query($SQL)->result();

        $return = array();

        if ($makeFill)
        {
            $format = "d/m/Y";
            $start  = date($format, strtotime("-3 months"));
            $end    = date($format);

            $range = new DatePeriod(DateTime::createFromFormat($format, $start), new DateInterval('P1D'), DateTime::createFromFormat($format, $end));

            $filler = array();

            foreach ($range as $date)
            {
                array_push($filler, $date->format($format));
            }

            $filler_ = array_flip($filler);

            foreach ($result as $value)
            {
                $filler_[$value->date] = $value;
            }

            $return = $filler_;
        }
        else
        {
            foreach ($result as $value)
            {
                $return[$value->date] = $value;
            }
        }

        return $return;
    }

}
