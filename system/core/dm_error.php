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
class dm_error
{


        /*
         * -----------------------------------------------
         * ERROR
         * -----------------------------------------------
         * 
         * This method wll be used to catch errors and log
         * as well as to display a message to the end user
         * 
         */

        static function display_error($err)
        {


                //generate a unique 9 digit id number

                for($i = 0; $i < 9; $i++)
                {
                        $id .= rand(0, 9);
                        if($i == 2 || $i == 5)
                        {
                                $id .= '-';
                        }
                }
                $error_id = $id;
                debug::log($err.' ERROR ID: '.$error_id, 1);
                ?>                       

                <style>
                        body {
                                font-family: arial, sans-serif;
                                font-size: 16px;
                                color: #333;
                                line-height: 1.5em;
                        }
                        .error {
                                width: 500px;
                                margin: 100px auto;
                                border: 1px solid #999;
                                padding: 40px;
                                -webkit-box-shadow: 2px 2px 3px rgba(0,0,0,0.35);
                                -moz-box-shadow: 2px 2px 3px rgba(0,0,0,0.35);
                                box-shadow: 2px 2px 3px rgba(0,0,0,0.35);

                                -webkit-border-radius: 20px;
                                -moz-border-radius: 20px;
                                border-radius: 20px;

                        }

                        .error-id {
                                font-size: 2em;
                                border: 3px double #900;
                                padding: 20px;
                                text-align: center;
                        }
                        
                        .debug {
                                font-style: italic;
                        }
                </style>

                <body>
                        <div class="error">
                                <h3>An Error as occured</h3>
                                <p>
                                        An error has occured that has stopped the application from running.

                                        if you wish to report this error please provide the following error ID
                                </p>

                                <p class="error-id">
                                        <?= $error_id ?>
                                </p>
                                
                                <?php if(ENV == 'DEV' || ENV == 'TEST'): ?>
                                <h4>Debug Message</h4>
                                <p class="debug">
                                        <?=$err?>
                                </p>
                                <?php endif; ?>
                        </div>

                        <?php
                        exit('');

                }



        }
        ?>
