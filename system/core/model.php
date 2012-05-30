<?php

/**
 * Description of model
 *
 * @author Paul Mulgrew
 */

//base model class
class model
{

        //user get magic method to get access to classes loaded in the controller
        function __get($name)
        {
                $c =& controller::getInstance();
                return $c->$name;

        }

}

//end model

?>
