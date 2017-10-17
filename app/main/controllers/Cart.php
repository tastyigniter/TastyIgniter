<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Cart extends Main_Controller {

    public function index() {
        $this->lang->load('cart');

        $this->load->module('cart_module');
        $data['cart'] = $this->cart_module->getCart(array(), array(), TRUE);

        $this->template->setTitle($this->lang->line('text_heading'));
        $this->template->setStyleTag(extension_url('cart_module/views/stylesheet.css'), 'cart-module-css', '144000');

        $this->template->render('cart', $data);
    }
}