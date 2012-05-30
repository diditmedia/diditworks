<?php

/**
 * Description of view
 *
 * @author Paul Mulgrew
 */
class view
{
        

        public function __construct()
        {
                $this->config = & load('config');

        }

        public function add_output($view, $data = NULL)
        {
                $loc = APP_PATH .SEP. $this->config->key('views');
                $file = $loc . SEP.$view.EXT;
                
                if(is_dir($loc))
                {
                        if(file_exists($file))
                        {
                                ob_start();
                                
                                if(!is_null($data))
                                {
                                        extract($data);
                                }
                                
                                require $file;
                                
                        }
                }

        }
        
        function build_output()
        {
                
                ob_end_flush();
                      
        }

}

?>
