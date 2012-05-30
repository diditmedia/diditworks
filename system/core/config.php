<?php

/**
 * Gets config keys
 *
 * @author Paul Mulgrew
 */
class config
{

        function key($key)
        {
                return get_config($key);
        }

}

?>
