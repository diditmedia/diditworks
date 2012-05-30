<?php

/**
 * -----------------------------------------------------------
 * DEBUG
 * -----------------------------------------------------------
 * 
 * The purpose of this file is to log errors.
 *
 * @author Paul Mulgrew
 * @package diditworks
 * @todo create this class
 */
class debug
{


        static function log($message, $level)
        {

                if($level <= LOG && LOG != 0)
                {
                        //define the path for the logs to be stored
                        $logpath = APP_PATH . SEP . 'logs';

                        //chefk if the log directory exists and if it doesnt create it
                        if(!is_dir($logpath))
                        {
                                mkdir($logpath, 0777);
                        }

                        //define the log file
                        $file = $logpath . '/log.txt';

                        //open the file for appending
                        $w = fopen($file, 'a');

                        //write the message to the file 
                        fwrite($w, date('d.m.y h:i:s') . ' ' . $message . ' ' . 'FILE: ' . __FILE__ . ' LINE: ' . __LINE__ . PHP_EOL);

                        //close the file
                        fclose($w);
                }

        }


}

?>
