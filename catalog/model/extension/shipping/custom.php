<?php

class ModelExtensionShippingCustom extends Model {

    function getQuote($address) {
        $this->load->language('extension/shipping/custom');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $this->config->get('custom_geo_zone_id') . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

        if (!$this->config->get('custom_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        if ($this->cart->getSubTotal() > $this->config->get('custom_total')) {
            $cost = $this->config->get('custom_cost');
            $tax_class_id = $this->config->get('custom_tax_class_id');
            $text = $this->currency->format($this->tax->calculate($this->config->get('custom_cost'), $this->config->get('custom_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency']);
        } else {
            $cost = 0.00;
            $tax_class_id = 0;
            $text = $this->currency->format(0.00, $this->session->data['currency']);
        }

        $method_data = array();

        if ($status) {
            $quote_data = array();

            $quote_data['custom'] = array(
                'code' => 'custom.custom',
                'title' => $this->language->get('text_description'),
                'cost' => $cost,
                'tax_class_id' => $tax_class_id,
                'text' => $text
            );

            $method_data = array(
                'code' => 'custom',
                'title' => $this->language->get('text_title'),
                'quote' => $quote_data,
                'sort_order' => $this->config->get('custom_sort_order'),
                'error' => false
            );
        }

        return $method_data;
    }

}
