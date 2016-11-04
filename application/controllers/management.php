<?php

class Management extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('pagination');

        $this->load->model('foreigner');
        $this->load->model('country');
        $this->load->model('status');
        $this->load->model('category');
        $this->load->model('visits');
        $this->load->model('backup');
    }

    public function backup()
    {
        $config['base_url']             = base_url('management/backup?');
        $config['page_query_string']    = TRUE;
        $config['query_string_segment'] = 'p';
        $config["total_rows"]           = $this->backup->record_count();
        $config["per_page"]             = 20;
        $config["uri_segment"]          = 4;
        $config['prev_link']            = 'Previous';
        $config['next_link']            = 'Next';
        $config['full_tag_open']        = '<ul>';
        $config['full_tag_close']       = '</ul>';
        $config['first_tag_open']       = '<li class="first">';
        $config['first_tag_close']      = '</li>';
        $config['last_tag_open']        = '<li class="last">';
        $config['last_tag_close']       = '</li>';
        $config['cur_tag_open']         = '<li class="current">';
        $config['cur_tag_close']        = '</li>';
        $config['next_tag_open']        = '<li class="next">';
        $config['next_tag_close']       = '</li>';
        $config['prev_tag_open']        = '<li class="prev">';
        $config['prev_tag_close']       = '</li>';
        $config['num_tag_open']         = '<li>';
        $config['num_tag_close']        = '</li>';

        $this->pagination->initialize($config);

        if (!$this->session->userdata('logged_in'))
        {
            redirect('login', 'refresh');
        }

        $page = $this->input->get('p') ? $this->input->get('p') : 0;

        foreach ($this->backup->get($config["per_page"], $page) as $value)
        {
            $data['backup'][$value->bac_id] = date('F jS Y H\:i\:s', strtotime($value->bac_date));
        }

        $data["links"]   = $this->pagination->create_links();
        $data["showing"] = $this->pagination->cur_page * $this->pagination->per_page;
        $data["total"]   = $this->pagination->total_rows;

        $this->load->view('management/backup', $data);
    }

    /** @TODO Correct statements and return the menu to the original place */
    public function doBackup()
    {

        /* loop foreigner information */
        foreach ($this->foreigner->get() as $key => $row)
        {

            $pais     = $this->country->get($row->for_nationality);
            $status   = $this->status->get($row->sta_id);
            $category = $this->category->get($row->cat_id);

            $row->for_nationality = (empty($pais)) ? "Uninformed" : $pais[0]->name;
            $row->sta_id          = (empty($status)) ? "Uninformed" : $status[0]->sta_name;
            $row->cat_id          = (empty($category)) ? "Uninformed" : $category[0]->cat_name;

            $foreigners[$key] = $row;
        }

        /* loop visits information */
        foreach ($this->visits->get() as $key => $row)
        {
            $visits[$key] = (array) $row;
        }

        /* Make the Excel Backup */
        $excelBackup = new PHPExcel();

        $excelBackup->getProperties()->setCreator("Belo Horizonte")
                ->setLastModifiedBy("Belo Horizonte")
                ->setTitle("Belo Horizonte")
                ->setSubject("Belo Horizonte")
                ->setDescription("Belo Horizonte");

        /* backup foreigners */

        $excelBackup->setActiveSheetIndex(0);

        foreach ($foreigners as $row => $rows)
        {
            $columns = 0;
            foreach ((array) $rows as $column => $data)
            {
                $excelBackup->getActiveSheet()->setCellValueByColumnAndRow($columns, $row + 1, html_entity_decode($data));
                /* next column */
                $columns = $columns + 1;
            }
        }

        $excelBackup->getActiveSheet()->setTitle('Foreigners');

        $excelBackup->createSheet();

        $excelBackup->setActiveSheetIndex(1);

        foreach ($visits as $row => $rows)
        {
            $columns = 0;
            foreach ((array) $rows as $column => $data)
            {
                $excelBackup->getActiveSheet()->setCellValueByColumnAndRow($columns, $row + 1, html_entity_decode($data));
                /* next column */
                $columns = $columns + 1;
            }
        }

        $excelBackup->getActiveSheet()->setTitle('Visits');

        $bac_id = $this->backup->set(date("Y-m-d H:i:s"));

        $objWriter = PHPExcel_IOFactory::createWriter($excelBackup, 'Excel2007');

        $objWriter->save(dirname(BASEPATH) . "/assets/backup/excel/" . md5($bac_id) . ".xlsx");
    }

}
