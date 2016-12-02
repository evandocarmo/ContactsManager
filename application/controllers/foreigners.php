<?php

class Foreigners extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in'))
        {
            redirect('login', 'refresh');
        }
        $this->load->library('fpde');
        $this->load->library("pagination");
        $this->load->model('visits');
        $this->load->model('foreigner');
        $this->load->model('country');
        $this->load->model('status');
        $this->load->model('category');
        $this->load->model('search');
        $this->load->model('qrhash');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    public function index()
    {
        redirect('foreigners/contacts', 'refresh');
    }

    public function contacts()
    {
        /* query string for search engineq */
        $query_string = explode('&p=', $this->input->server("REQUEST_URI"));

        /* if GET isset, flag the search engine configuration */
        $search = ($this->input->get()) ? $this->input->get() : NULL;

        /* get page number */
        $page     = $this->input->get('p') ? $this->input->get('p') : 0;
        $per_page = 20;

        /* initilize pagination params */
        $config = array(
            'base_url'             => ($this->input->get()) ? $query_string[0] : base_url('foreigners/contacts?'),
            'page_query_string'    => TRUE,
            'query_string_segment' => 'p',
            'total_rows'           => $this->search->recordCount(null, $per_page, $page, $search),
            'per_page'             => $per_page,
            'uri_segment'          => 4,
            'prev_link'            => 'Previous',
            'next_link'            => 'Next',
            'full_tag_open'        => '<ul>',
            'full_tag_close'       => '</ul>',
            'first_tag_open'       => '<li class="first">',
            'first_tag_close'      => '</li>',
            'last_tag_open'        => '<li class="last">',
            'last_tag_close'       => '</li>',
            'cur_tag_open'         => '<li class="current">',
            'cur_tag_close'        => '</li>',
            'next_tag_open'        => '<li class="next">',
            'next_tag_close'       => '</li>',
            'prev_tag_open'        => '<li class="prev">',
            'prev_tag_close'       => '</li>',
            'num_tag_open'         => '<li>',
            'num_tag_close'        => '</li>'
        );
        $this->pagination->initialize($config);

        /* loop foreiners */
        foreach ($this->foreigner->get(null, $config["per_page"], $page, $search) as $key => $row)
        {
            $pais                = $this->country->get($row->for_nationality);
            $visits              = $this->visits->get($row->for_id);
            $status              = $this->status->get($row->sta_id);
            $category            = $this->category->get($row->cat_id);
            $row->for_country    = (empty($pais)) ? "Uninformed" : $pais[0]->name;
            $row->for_status     = (empty($status)) ? "Uninformed" : $status[0]->sta_name;
            $row->for_category   = (empty($category)) ? "Uninformed" : $category[0]->cat_name;
            $row->for_visits     = $row->vis_amount;
            $data['table'][$key] = $row;
        }
        $data['country']  = $this->country->get(NULL, TRUE);
        $data['status']   = $this->status->get();
        $data['category'] = $this->category->get();
        $data["links"]    = $this->pagination->create_links();
        $data["showing"]  = $this->pagination->cur_page * $this->pagination->per_page;
        $data["total"]    = $this->pagination->total_rows;
        $this->load->view('foreigners/contacts', $data);
    }

    public function contact($id = NULL)
    {
        if ($this->input->post())
        {
            $this->foreigner->edit($this->input->post());
            redirect("/foreigners/contacts", 'refresh');
        }
        $data['contato']  = (isset($id)) ? $this->foreigner->get($id) : array();
        $data['country']  = $this->country->get();
        $data['status']   = $this->status->get();
        $data['category'] = $this->category->get();
        $this->load->view('foreigners/contact', $data);
    }

    public function printer($id)
    {
        /* set the base path */
        $basepath = BASEPATH . "../";

        /* get user info */
        $user  = array_shift($this->foreigner->get($id));
        $visit = end($this->visits->get($id));

        /* QRCode generation */
        $qrcode['data']     = base_url() . "mobile?contact={$user->for_id}";
        $qrcode['level']    = 'H';
        $qrcode['size']     = 2;
        $qrcode['savename'] = "{$basepath}/assets/img/qrcode/{$user->for_id}.png";

        $ciqrcode = new Ciqrcode();

        $ciqrcode->generate($qrcode);

        /* download the $url image and save on $file path */
        $file = "{$basepath}/assets/img/maps/{$user->for_id}";
        $url  = "http://maps.google.com/maps/api/staticmap?center={$user->for_location}&format=png32&zoom=16&size=640x273&maptype=roadmap&markers=color:blue|label:S|{$user->for_location}";

        file_put_contents($file . ".png", file_get_contents($url));

        /* user FPDF and FPDI to generate PDF file */
        $pdf = new FPDE('P', 'mm', array(145, 190));

        /* set source file of the base template */
        $pdf->setSourceFile("{$basepath}/assets/img/maps/template.pdf");

        /* add one page to fit the template */
        $pdf->addPage();

        /* config of template */
        $pdf->useTemplate($pdf->importPage(1, '/MediaBox'), 0, 0, 145);

        /* QRCode on PDF */
        $pdf->Image($qrcode['savename'], 2.08, 101.25, 0, 0);
        $pdf->Image($file . ".png", 0.3, 31.1, 144.4, 61.5);
        $pdf->AddFont('helvetica');
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetFont('helvetica', '', 9);
        $category = $this->category->get($user->cat_id);

        $pdf->TextWithDirection(139, 5.8, html_entity_decode($category[0]->cat_name, ENT_QUOTES, 'ISO-8859-1'), 'D');

        /* ID */
        $pdf->SetFont('helvetica', '', 8);
        $pdf->TextWithDirection(134, 5.8, html_entity_decode("N&ordm; " . sprintf("%03d", $user->for_id), ENT_QUOTES, 'ISO-8859-1'), 'D');
        $pdf->SetFont('helvetica', '', 12);

        /* Nome */
        $pdf->SetXY(17.6, 7.1);
        $pdf->Write(0.5, html_entity_decode($user->for_name, ENT_QUOTES, 'ISO-8859-1'));

        /* Endereço */
        $complemento = ($user->for_complement == "Uninformed") ? "" : " / " . $user->for_complement;
        $pdf->SetXY(21, 13.9);
        $pdf->Write(0.5, html_entity_decode($user->for_route . ", " . $user->for_street_number . " - " . $user->for_sublocality . $complemento, ENT_QUOTES, 'ISO-8859-1'));

        /* Telefone */
        $pdf->SetXY(18.3, 20.8);
        $pdf->Write(0.5, html_entity_decode($user->for_telephone, ENT_QUOTES, 'ISO-8859-1'));

        /* Nacionalidade */
        $pais          = $this->country->get($user->for_nationality);
        $nacionalidade = (empty($pais)) ? "Uninformed" : $pais[0]->name;
        $pdf->SetXY(80.2, 20.8);
        $pdf->Write(0.5, html_entity_decode($nacionalidade, ENT_QUOTES, 'ISO-8859-1'));

        if ($visit)
        {
            $pdf->SetFont('helvetica', '', 9);
            $pdf->TextWithRotation(141, 177.9, date("d/m/Y", strtotime($visit->vis_date)), 180);
            $pdf->TextWithRotation(121, 177.9, html_entity_decode($visit->vis_publisher, ENT_QUOTES, 'ISO-8859-1'), 180);
            $vis_description = str_split($visit->vis_description);
            $count           = 0;
            foreach ($vis_description as $value)
            {
                if ($value == "\n")
                {
                    $count    = 0;
                    $string[] = "\n";
                }
                else
                {
                    $count++;
                    if ($count == 70)
                    {
                        $count    = 0;
                        $string[] = "\n";
                    }
                    else
                    {
                        $string[] = $value;
                    }
                }
            }
            $descriptionArray = explode('<br />', nl2br(implode($string)));
            $height           = 177.7;
            foreach ($descriptionArray as $id => $row)
            {
                $pdf->TextWithRotation(96, $height, html_entity_decode(trim(preg_replace('/\s+/', ' ', $row)), ENT_QUOTES, 'ISO-8859-1'), 180);
                $height = $height - 5.7;
            }
        }
        /* ob_end_clean(); */
        $pdf->Output($user->for_id . '.pdf', 'D');
    }

}
