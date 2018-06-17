<?php
require APPPATH . "third_party/MX/Loader.php";
class MY_Loader extends MX_Loader
{

    /**
     * List of loaded views
     *
     * @return array
     */
    protected $_ci_views = array();

    /**
     * List of loaded helpers
     *
     * @return array
     */
    public function get_helpers()
    {
        return $this->_ci_helpers;
    }

    /**
     * List of loaded views
     *
     * @return array
     */
    public function get_views()
    {
        return $this->_ci_views;
    }

    /**
     * List of loaded models
     *
     * @return mixed
     */
    public function get_models(){
        return $this->_ci_models;
    }
}