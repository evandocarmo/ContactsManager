<?php

class Settings extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in'))
        {
            redirect('login', 'refresh');
        }
        $this->load->model('status');
        $this->load->model('category');
        $this->load->model('mpublishers');
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    public function status($id = NULL)
    {
        /* list recorded status */
        $data['status'] = $this->status->get();
        if ($this->input->post())
        {
            /* form validation */
            $this->form_validation->set_rules('sta_name', 'Name', 'trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('settings/status', $data);
            }
            else
            {
                /* store submitted data */
                $submit = $this->input->post();

                /* flag submmited data with update row ID */
                $submit['sta_id'] = (isset($id)) ? $id : NULL;

                /* insert or update registry */
                $this->status->edit($submit);

                /* if the data was updated, load the updated data */
                $data['edit'] = (isset($id)) ? $this->category->get($id) : NULL;

                /* if the data was update */
                if (isset($id))
                {
                    /* set return message */
                    $this->session->set_flashdata('message', "Update sucessfully executed");
                    /* redirect, so the page will be refreshed */
                    redirect(site_url("settings/status/{$id}"), 'refresh');
                }
                /* if the data was inserted */
                else
                {
                    /* set return message */
                    $this->session->set_flashdata('message', "Insert sucessfully executed");
                    /* redirect, so the page will be refreshed */
                    redirect(site_url("settings/status"), 'refresh');
                }
            }
        }
        else
        {
            /* load the requested status */
            if (isset($id))
            {
                /* list recorded status */
                $data['edit'] = $this->status->get($id);
            }
            /* load view and submit params */
            $this->load->view('settings/status', $data);
        }
    }

    public function category($id = NULL)
    {
        /* list recorded category */
        $data['category'] = $this->category->get();

        /* if isset POST */
        if ($this->input->post())
        {
            /* form validation */
            $this->form_validation->set_rules('cat_name', 'Name', 'trim|required');
            $this->form_validation->set_rules('cat_color', 'Color', 'trim|required');

            /* field validation failed. */
            if ($this->form_validation->run() == FALSE)
            {
                /* reload the login view */
                $this->load->view('settings/category', $data);
            }
            else
            {
                /* store submitted data */
                $submit = $this->input->post();

                /* flag submmited data with update row ID */
                $submit['cat_id'] = (isset($id)) ? $id : NULL;

                /* insert or update registry */
                $this->category->edit($submit);

                /* if the data was updated, load the updated data */
                $data['edit'] = (isset($id)) ? $this->category->get($id) : NULL;

                /* if the data was update */
                if (isset($id))
                {
                    /* set return message */
                    $this->session->set_flashdata('message', "Update sucessfully executed");
                    /* redirect, so the page will be refreshed */
                    redirect(site_url("settings/category/{$id}"), 'refresh');
                }
                /* if the data was inserted */
                else
                {
                    /* set return message */
                    $this->session->set_flashdata('message', "Insert sucessfully executed");
                    /* redirect, so the page will be refreshed */
                    redirect(site_url("settings/category"), 'refresh');
                }
            }
        }
        else
        {
            /* user is requesting the load of one category */
            if (isset($id))
            {
                /* flag the category to be load */
                $data['edit'] = $this->category->get($id);
            }
            /* load view and submit params */
            $this->load->view('settings/category', $data);
        }
    }

    public function publishers($id = NULL)
    {
        /* list recorded status */
        $data['publishers'] = $this->mpublishers->get();

        /* on post entry */
        if ($this->input->post())
        {
            /* form validation */
            $this->form_validation->set_rules('pus_name', 'Name', 'trim|required');
            $this->form_validation->set_rules('pus_mail', 'Email', 'trim|required|valid_email');
            /* validation proccess */
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('settings/publishers', $data);
            }
            else
            {
                /* store submitted data */
                $submit = $this->input->post();
                /* insert or update registry */
                $this->mpublishers->edit($submit);
                /* set return message */
                $this->session->set_flashdata('message', "Insert sucessfully executed");
                /* redirect, so the page will be refreshed */
                redirect(site_url("settings/publishers"), 'refresh');
            }
        }
        else
        {
            /* load view and submit params */
            $this->load->view('settings/publishers', $data);
        }
    }

}
