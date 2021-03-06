<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        if ($this->config->item('maintenance_mode') == '1' && $this->m_data->isLogged() && $this->m_general->getPermissions($this->session->userdata('fx_sess_id')) != 1)
        {
            redirect(base_url('maintenance'),'refresh');
        }

        $this->load->model('home_model');
        $this->load->model('shop/shop_model');
        $this->load->model('news/news_model');
        $this->load->model('events/events_model');
    }

    public function index()
    {
        $this->load->view('home');
        $this->load->view('footer');
    }
}
