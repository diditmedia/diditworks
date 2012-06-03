<?php
debug::log('Home controller loaded', 4);
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
        }
        
        function index()
        {
                debug::log('Home controller index method loaded', 4);
                
                $view = $this->loader->view('template/header');
                $view = $this->loader->view('home/hello');
                $view = $this->loader->view('template/footer');
                $view->build_output();
                
               

                
        }

}

?>
