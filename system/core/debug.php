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
                if(is_writable(APP_PATH))
                {
                        if($level <= LOG && LOG != 0)
                        {
                                //define the path for the logs to be stored
                                $logpath = APP_PATH . SEP . 'logs';

                                //chefk if the log directory exists and if it doesnt create it
                                if(!is_dir($logpath))
                                {
                                        mkdir($logpath, 0755);
                                }

                                //create a directory for the current month/year
                                if(!is_dir($logpath . SEP . date('M-Y')))
                                {
                                        mkdir($logpath . SEP . date('M-Y'), 0755);
                                }

                                $logpath = $logpath . SEP . date('M-Y');

                                //define the log file
                                $file = $logpath . '/' . date('D-j') . '.txt';

                                //open the file for appending
                                $w = fopen($file, 'a');

                                //write the message to the file 
                                fwrite($w, date('d.m.y h:i:s') . ' ' . $message . PHP_EOL);

                                //close the file
                                fclose($w);
                        }
                }

        }


}

?>
