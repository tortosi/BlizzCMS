<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        if ($this->m_modules->getStatusStore() != '1')
            redirect(base_url(),'refresh');

        if ($this->config->item('maintenance_mode') == '1' && $this->m_data->isLogged() && $this->m_general->getPermissions($this->session->userdata('fx_sess_id')) != 1)
        {
            redirect(base_url('maintenance'),'refresh');
        }

        $this->load->model('shop_model');
    }

    public function index()
    {
        $this->load->view('index');
        $this->load->view('footer');
    }

    public function order($id)
    {
        if (!$this->m_data->isLogged())
            redirect(base_url('login'),'refresh');

        $data['idlink'] = $id;

        $this->load->view('order', $data);
        $this->load->view('footer');
    }

    public function cart($id)
    {
        if (!$this->m_data->isLogged())
            redirect(base_url('login'),'refresh');

        if ($this->shop_model->getExistItem($id) < 1)
            redirect(base_url('store'),'refresh');

        $data['idlink'] = $id;

        if (isset($_GET['tp']))
        {
            $mode = $_GET['tp'];

            if ($mode != 'vp' && $mode != 'dp')
                redirect(base_url('store'),'refresh');

            if ($mode == "vp")
                $this->shop_model->getVPTrue($id);
            if ($mode == "dp")
                $this->shop_model->getDPTrue($id);

            $data['idlink'] = $id;
            $this->load->view('cart', $data);
        }
        else
            redirect(base_url('store'),'refresh');

        $this->load->view('footer');
    }
}
