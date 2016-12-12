<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Shopping Cart Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Shopping Cart
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/cart.html
 * @deprecated	3.0.0	This class is too specific for CI.
 */

class MY_Cart extends CI_Cart {

    public function __construct($params = array()) {
        parent::__construct($params);
        $this->product_name_rules = '\d\D';
    }

}