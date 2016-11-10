<?php

class mmobile extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
        /* load log model */
        $this->load->model('log');
    }

    function login($username, $password)
    {
        $SQL = "    SELECT pus_iden, pus_mail, pus_name, pus_pass "
                . "   FROM personal_users                            "
                . "  WHERE pus_pass = MD5('{$password}')             "
                . "    AND pus_mail = '{$username}'                  ";

        $query = $this->db->query($SQL);

        if ($query->num_rows() == 1)
        {
            /* Get the User */
            $user = $query->result_array();
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function assign($userid)
    {
        /* verifica se usuario ja possui territorio designado que não foi dado feedback (descrição não existe ou nula) */
        $SQL = "SELECT pet_iden, pet_user, pet_fore, pet_desc     "
                . "  FROM personal_territories                       "
                . " WHERE pet_user = '{$userid}'                     "
                . "   AND pet_desc IS NULL OR pet_desc = ''          ";

        $query = $this->db->query($SQL);

        if ($query->num_rows() == 1)
        {
            /* se possir, retorna os dados do contato para preenchimento do feedback */
            $contact = $query->result_array()[0];

            /* usa o ID do contato para puxar o resgistro que náo esta completo */
            $SQL_W = "foreigner.for_id = \"{$contact['pet_fore']}\" AND pet_iden IS NOT NULL";
        }
        else
        {
            /* é necessario realizar uma nova designação */
            $SQL_W = "pet_iden IS NULL OR pet_rnew = 'Yes'";
        }

        $SQL_ = "    SELECT foreigner.for_id, foreigner.for_name,                             \n"
                . "           foreigner.for_telephone, personal_territories.*                    \n"
                . "      FROM foreigner                                                          \n"
                . " LEFT JOIN personal_territories                                               \n"
                . "        ON personal_territories.pet_fore = foreigner.for_id                   \n"
                . "     WHERE foreigner.sta_id = '20' AND ({$SQL_W})                             \n"
                . "  GROUP BY foreigner.for_id                                                   \n"
                . "  ORDER BY pet_rnew DESC LIMIT 0, 1                                           \n";


        foreach ($this->db->query($SQL_)->result() as $row_)
        {
            $foreigner = $row_;
        }

        /* se não possir, pegar informações de um contato com status phonecall sem visita e designar */
        if (!isset($contact))
        {
            /* atualiza status se for um contato renovado */
            $where = array('pet_fore ' => $foreigner->for_id, 'pet_rnew ' => 'Yes');
            $this->db->where($where);
            $this->db->update('personal_territories', array('pet_rnew' => 'Ok'));

            $data             = array();
            $data['pet_user'] = $userid;
            $data['pet_fore'] = $foreigner->for_id;

            $this->db->insert('personal_territories', $data);

            $data['pet_iden'] = $this->db->insert_id();

            $contact = $data;
        }

        /* retornar os dados do contato para preenchimento do feedback */
        $return = array_merge($contact, (array) $foreigner);

        return $return;
    }

    function update($ide, $msg)
    {
        $this->db->where('pet_iden', $ide);
        $this->db->update('personal_territories', array('pet_desc' => $msg));
    }

    function dashboard($userid)
    {
        $SQL   = "        SELECT foreigner.for_name, pet_date                     "
                . "       FROM personal_territories                             "
                . " INNER JOIN foreigner                                        "
                . "         ON foreigner.for_id = personal_territories.pet_fore "
                . "      WHERE pet_user = {$userid}                             "
                . "   ORDER BY pet_iden DESC                                    ";
        $query = $this->db->query($SQL);
        return $query->result();
    }

}
