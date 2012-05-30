<?php

/*
 * -----------------------------------------------------------
 * FORM HELPER
 * -----------------------------------------------------------
 * 
 * The purpose of this file is to interact with the form class
 * so that we can create forms without the need to initialize 
 * the form object from the view
 * 
 * 
 * @package diditworks
 * @author Paul Mulgrew
 */


function form($action = NULL, $method = NULL, $params = NULL)
{
        $form =& get_instance();
        echo $form->forms->form($action, $method, $params);

}

function input($type = NULL, $name = NULL, $params = NULL)
{
        $form =& get_instance();
        echo $form->forms->input($type, $name, $params);
}



?>
