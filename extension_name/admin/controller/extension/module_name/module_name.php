<?php

class ControllerExtensionModuleName extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('extension/module_name/moduel_name');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module_name/moduel_name', $data));
    }

}
