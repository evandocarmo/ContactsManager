<?php

class mpersonal extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
        /* load log model */
        $this->load->model('log');
    }

    function phonecalls_renew($phonerenew)
    {
        $this->db->where('pet_iden', $phonerenew);
        $this->db->update('personal_territories', array('pet_rnew' => 'Yes'));

        return true;
    }

    function phonecalls_browse($limit = null)
    {
        $SQL = "     SELECT for_id, for_name, pet_iden, pet_desc, pet_rnew,         \n"
                . "            pet_date, pus_name, MAX(log_date) AS log_date,          \n"
                . "            MAX(vis_date) AS vis_date, y.the_count                  \n"
                . "       FROM personal_territories                                    \n"
                . " INNER JOIN personal_users                                          \n"
                . "         ON personal_users.pus_iden = personal_territories.pet_user \n"
                . " INNER JOIN foreigner                                               \n"
                . "         ON foreigner.for_id = personal_territories.pet_fore        \n"
                . "  LEFT JOIN visits                                                  \n"
                . "         ON visits.vis_foreigner = personal_territories.pet_fore    \n"
                . "  LEFT JOIN log                                                     \n"
                . "         ON log.log_effect = foreigner.for_id                       \n"
                . " INNER JOIN (    SELECT pet_fore, COUNT(*) AS the_count             \n"
                . "                   FROM personal_territories                        \n"
                . "               GROUP BY pet_fore) AS y                              \n"
                . "         ON personal_territories.pet_fore = y.pet_fore              \n"
                . "   GROUP BY pet_iden, vis_foreigner                                 \n"
                . "   ORDER BY pet_desc IS NULL DESC, pet_date DESC                    \n";

        $SQL .= (!is_null($limit) && $limit) ? " LIMIT {$limit[0]}, {$limit[1]} " : "";

        $query = $this->db->query($SQL);

        if (is_null($limit))
        {
            return $query->num_rows();
        }
        else
        {
            $return = array();

            foreach ($query->result() as $id => $row)
            {
                $return[$id] = (array) $row;

                if ($row->pet_rnew == 'Yes')
                {
                    $return[$id]['color'] = "#ffd602";
                }
                else if ($row->pet_rnew == 'Ok')
                {
                    $return[$id]['color'] = "#82b5e0";
                }
                else
                {
                    if (strtotime($row->pet_date) > strtotime($row->log_date))
                    {
                        $return[$id]['color'] = "#e66665";
                    }
                    else
                    {
                        $return[$id]['color'] = "#4d9379";
                    }
                }
            }

            return $return;
        }
    }

}
