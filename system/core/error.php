<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of error
 *
 * @author Paul Mulgrew
 */
class error
{


        public function __construct($errors = NULL)
        {
                if(!is_null($errors) && is_array($errors))
                {
                        foreach($errors as $error => $msg)
                        {
                                $this->$error = $msg;
                        }
                }
        }

}

?>
