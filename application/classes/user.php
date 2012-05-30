<?php

/**
 * ------------------------------------------------------
 * USER OBJECT CLASS
 * ------------------------------------------------------
 * 
 * This class will be used to Create, retrieve, update 
 * and delete users from the system.
 *
 * @author Paul Mulgrew
 * @package diditworks
 * 
 */
class user
{


        public function __construct($userid = NULL, $params = NULL)
        {



                //check if a user id was passed
                if(!is_null($userid))
                {
                        //get the user passed by id
                        $this->get_user($userid);
                }
                else
                {

                        //if no id is passed then we create a new user
                        //1st we check if the params have been passed
                        if(!is_null($params) && is_array($params))
                        {
                                //now checkif the required data is set
                                if(isset($params['username']) && isset($params['email']))
                                {
                                        
                                }
                                else
                                {
                                        exit('User could not be created');
                                }
                        }
                        else
                        {
                                //if the params is not set return false
                                return false;
                        }
                }

        }


        protected function db()
        {
                $db = &load('db');

                return $db;

        }


        protected function get_user($userid)
        {
                //get the user info
                $userinfo = $this->db()->select('*')->from('users')->where(array( 'user_id' => $userid ))->execute();
                
                //check if any results cameback

                if(!empty($userinfo))
                {
                        foreach($userinfo[0] as $key => $value)
                        {
                                $this->$key = $value;
                        }
                } else {
                        $this->error = 'User does not exist';
                }
                //get the users posts
                $userposts = $this->db()->select('*')->from('posts')->where(array('user_id' => $userid))->execute();
                
                
                
                $this->post_count = count($userposts);

        }


}

?>
