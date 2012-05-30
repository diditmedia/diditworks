<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of post_model
 *
 * @author Paul Mulgrew
 */
class post_model extends model
{
        
        function get_posts()
        {
                 $joins = array(
                    'posts' => array(
                        'posts' => 'post_id',
                        'post_comments' => 'post_id'
                    )
                );
                //$r = $this->db->select('*', 'posts', false)->order_by('post_title', 'DESC')->limit(3)->execute();
                 
//                 $this->db->insert(array(
//                     'post_title' => 'Insert Test',
//                     'post_content' => 'kjsakjhaskjhskjhs'
//                 ),
//                         'posts');
                 
                 $this->db->update(array(
                     'post_title' => 'Post 5 Updated',
                     'post_content' => 'POst 5 content'
                 ),
                         'posts',
                         array(
                             'post_id' => '30'
                         ));
                 
                // $r = $this->db->query('SELECT * FROM posts', NULL, TRUE);
                 
                 //$this->db->delete(array('post_id' => '31'), 'posts');
                
                return $r;

        }

        

}

?>
