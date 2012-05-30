<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author Paul Mulgrew
 */
class home extends controller
{

        function __construct()
        {
                parent::__construct();
                $this->db =& load('db');
                $this->forms = & load('forms', 'libraries');
                $this->loader->helper('form_helper');
                $this->post_model = $this->loader->model('post_model');
                
                ini_set('include_path', APP_PATH.SEP.'classes');
                
                $this->user = & load('user', 'classes');
                
                
                
                

        }
        
        function index()
        {
                
                
                $this->loader->view('template/header');
                $view = $this->loader->view('home/hello');
                $this->loader->view('template/footer');
                $view->build_output();
                
               

                
        }

}

?>
