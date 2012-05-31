<?php

/**
 * ----------------------------------------------------------------
 * DATABASE CLASS
 * ----------------------------------------------------------------
 * 
 * This class allows you to get data fomr a mysql database.
 * 
 * You can run queries directly through the query method or
 * build queries using various methods within this class.
 * Each query building method returns an instance of the db 
 * object so you can chain the methods together. 
 * 
 * ----------------------------------------------------------------
 * Example: 
 * 
 * $this->db->select('*')->from('mytable')->limit(1)->execute();
 * 
 * OR without chaining
 * 
 * $this->db->select('*');
 * $this->db->from('mytable');
 * $this->db->limit('1');
 * $this->db->execute();
 * 
 * This could also be done using the query method
 * 
 * $this->query('SELECT * FROM mytable LIMIT 1');
 * $this->execute();
 * ----------------------------------------------------------------
 * 
 * Note the execute method at the end. when chaining or building 
 * a query line by line you will need to run the execute method 
 * to return the results.
 * 
 * 
 * @package diditworks
 * @author Paul Mulgrew
 */

debug::log('database class file loaded', 4);
class db
{


        //holds an instance of itself
        private static $instance;
        //the property that will be the connection object
        public $_conn;
        //this will holde the stmobject
        public $_stm;
        //the select statement
        protected $_select = NULL;
        //table to pull from
        protected $_from = NULL;
        //table joins
        protected $_join = NULL;
        //where clause
        protected $_where = NULL;
        //order by
        protected $_order_by = NULL;
        //limit
        protected $_limit = NULL;
        //limit offset
        protected $_offset = NULL;
        //this will hold any bind params for prepared statements
        protected $_bind_params = NULL;
        //this will hold the final sql statement
        protected $_final_statement = NULL;

        public function __construct()
        {

                //set $instance to $this
                //we do this so we can return an instance of this object when using query building
                //methods. By doing this it will allow us to chain these methods
                self::$instance = $this;

                $this->config = & load('config');

                $dsn = $this->config->key('dsn');
                $passwd = $this->config->key('dbpass');
                $username = $this->config->key('dbuser');

                try
                {
                        $this->_conn = new PDO($dsn, $username, $passwd);
                } catch(PDOException $e)
                {
                        debug::log($e->getMessage(), 1);

                        exit('error connecting to database');
                }

        }


        /**
         * --------------------------------------------------------------------------------------
         * SQL QUERY
         * --------------------------------------------------------------------------------------
         * 
         * This method allows you to pass a sql statement as a string
         * 
         * 
         * @param string $sql           - the sql statement
         * @param array $bind           - an array of bind params    
         * @param boolean $return       - toogle returning of results or db object   
         * @return mixed                - returns either an array of results of the db object 
         */
        public function query($sql = NULL, $bind = NULL, $return = false)
        {
                //check if a statement was passed
                if(!is_null($sql))
                {
                        //assign it to the final statement property
                        $this->_final_statement = $sql;
                }

                //check if bind params where passed
                if(is_array($bind))
                {

                        $this->_bind_params = $bind;
                }

                //check if a result is ot be returned
                if($return === true)
                {
                        return $this->execute();
                }
                else
                {
                        return $this->getInstance();
                }

        }


        public function select($sql = NULL, $table = NULL, $return = FALSE)
        {
                /*
                 * -------------------------------------------------------
                 * BUILD SELECT STATEMENT
                 * -------------------------------------------------------
                 * 
                 * First we build the select statement
                 */
                if(!is_null($sql))
                {
                        if(is_array($sql))
                        {
                                //set the statement string as empty
                                $_statement = '';

                                //get the last key by counting how many keys total -1
                                $last = count($sql) - 1;

                                //loop through keys
                                foreach($sql as $key => $select)
                                {
                                        //if the key is not equal to last we add a comma 
                                        if($key != $last)
                                        {
                                                $_statement .= $select . ', ';
                                        }
                                        else
                                        {
                                                //we dont want a comma after the last item or it will cause
                                                //a sql error
                                                $_statement .= $select . ' ';
                                        }
                                }
                                //assign the statement to the _select property
                                $this->_select = $_statement;
                        }
                        else
                        {
                                $this->_select = $sql . ' ';
                        }
                }
                else
                {
                        exit('No columns passed in select method');
                }

                /*
                 * -------------------------------------------------
                 * SET TABLE
                 * -------------------------------------------------
                 * 
                 * If a table was passed set the from property
                 * 
                 */

                if(!is_null($table))
                {
                        $this->_from = $table;
                }

                /*
                 * ------------------------------------------------
                 * RETURN RESULT OR INSTANCE OF DB
                 * ------------------------------------------------
                 * 
                 * Now we check if a result was requested.
                 * if nto we return an instance of the object to allow for chaining
                 * 
                 */

                if($return === true)
                {
                        return $this->execute();
                }
                else
                {
                        return $this->getInstance();
                }

        }


        /**
         * ------------------------------------------------------------------------------
         * FROM METHOD
         * ------------------------------------------------------------------------------
         * 
         * This method sets the form section of the query
         * 
         * @param string $table         - the name of the table used in the FROM
         * @return object               - returns the db object so query methods can be chained
         */
        public function from($table = NULL)
        {
                if(!is_null($table))
                {
                        $this->_from = $table;
                        return $this->getInstance();
                }
                else
                {
                        exit('No table passed to from method');
                }

        }


        /**
         * -----------------------------------------------------------------------------
         * WHERE CLAUSE
         * -----------------------------------------------------------------------------
         * 
         * Creates the where clause of the query
         * 
         * @param array $clause         - an array containing column and value pairs
         * @param boolean $bind         - should the where statement use bind params default true
         * @return object               - returns an instance of the db object to allow chaining
         */
        public function where($clause, $bind = true)
        {
                //start the statement as blank
                $_statement = '';

                //set last as count - 1
                $last = count($clause) - 1;

                if(is_array($clause))
                {
                        //check if we should use bind params
                        if($bind === TRUE)
                        {

                                //start the count at 0
                                $x = 0;

                                //loop through array
                                foreach($clause as $column => $value)
                                {


                                        if($x == $last)
                                        {
                                                $_statement .= $column . ' = :' . $column . ' ';
                                        }
                                        else
                                        {
                                                $_statement .= $column . ' = :' . $column . ' AND ';
                                        }
                                        $x++;
                                }

                                $this->_bind_params = $clause;
                        }
                        else
                        {
                                //start the count at 0
                                $x = 0;

                                //loops through array
                                foreach($clause as $column => $value)
                                {



                                        if($x == $last)
                                        {
                                                $_statement .= $column . ' = ' . $value . ' ';
                                        }
                                        else
                                        {
                                                $_statement .= $column . ' = ' . $value . ' AND ';
                                        }
                                        $x++;
                                }
                        }

                        $this->_where = $_statement;

                        return $this->getInstance();
                }
                else
                {
                        exit('Where clause is not formatted correctly');
                }

        }


        /**
         * -----------------------------------------------------------------------------------------------
         * JOINS
         * -----------------------------------------------------------------------------------------------
         * 
         * This method will add any joins to the query.
         * 
         * -----------------------------------------------------------------------------------------------
         * EXAMPLE JOIN ARRAY
         * 
         * $joins = array(
         *           'posts' => array(
         *                      'posts' => 'post_id',
         *                      'post_comments' => 'post_id'
         *              )
         *      );
         * 
         * -----------------------------------------------------------------------------------------------
         * 
         * @param array $joins          - accepts an array
         * @return object               - returns an instance of the db object to allow for chaining
         */
        public function join($joins)
        {

                //start the statement of with a blank string
                $_statement = '';

                //make sure an array was passed
                if(is_array($joins))
                {

                        //start the join loop
                        foreach($joins as $table => $join)
                        {

                                $_statement .= ' JOIN ' . $table . ' ON ';

                                //start count form zero
                                $x = 0;

                                //loop through the join conditions
                                foreach($join as $table => $column)
                                {
                                        if($x == 0)
                                        {
                                                $_statement .= $table . '.' . $column . ' = ';
                                        }
                                        else
                                        {
                                                $_statement .= $table . '.' . $column . ' ';
                                        }
                                        $x++;
                                }
                        }
                }

                $this->_join = $_statement;

                return $this->getInstance();

        }


        /**
         * ------------------------------------------------------------------------------
         * LIMIT
         * ------------------------------------------------------------------------------
         * 
         * sets the limits and offsets for our query
         * 
         * @param int $start            - set the start row
         * @param int $offset           - set the end row
         * @return object               - returns an instance of the db object to allow chaining
         */
        public function limit($start = NULL, $offset = NULL)
        {
                if(!is_null($start))
                {
                        $this->_limit = $start;
                }

                if(!is_null($offset))
                {
                        $this->_offset = $offset;
                }

                return $this->getInstance();

        }


        /**
         * ------------------------------------------------------------------------------
         * ORDER BY
         * ------------------------------------------------------------------------------
         * 
         * sets the query order by
         * 
         * @param string $column         - set the column to order by
         * @param string $dir            - set the direction ASC or DESC
         * @return object                - returns an instance of the db object to allow chaining
         */
        public function order_by($column = NULL, $dir = 'ASC')
        {
                $_statement = '';
                if(!is_null($column))
                {
                        $_statement .= $column;

                        if(!is_null($dir))
                        {
                                $_statement .= ' ' . strtoupper($dir);
                        }
                }

                $this->_order_by = $_statement;

                return $this->getInstance();

        }


        /**
         * ------------------------------------------------------------------
         * DELETE
         * ------------------------------------------------------------------
         * 
         * This method will delete a row fro the database
         * 
         * @param array $where          - an array containing column and value pair
         * @param string $table         - a string containing the table name
         * @param boolean $autorun      - toogle if the delete query should auto run default: true
         * @return object               - returns an instance of the db object if autorun is false
         */
        public function delete($where, $table = NULL, $autorun = true)
        {
                //check if a table was passed
                if(!is_null($table))
                {
                        //start the query
                        $_statement = 'DELETE FROM ' . $table . ' WHERE ';

                        //check if the where clause is an array
                        if(is_array($where))
                        {
                                $this->where($where);

                                $_statement .= $this->_where;
                        }

                        //set the final statement
                        $this->_final_statement = $_statement;
                }
                else
                {
                        exit('No statement to execute');
                }


                //if autorun is true run the execute method
                if($autorun === true)
                {
                        $this->execute();
                }
                else
                {
                        return $this->getInstance();
                }

        }


        /**
         * --------------------------------------------------------------
         * INSERT STATEMENT
         * --------------------------------------------------------------
         * 
         * this method inserts data into the database
         * 
         * @param array $values         - an array of column value pairs
         * @param string $table         - the table to insert the data into 
         */
        public function insert($values, $table = NULL)
        {

                //check if values is an array
                if(is_array($values))
                {

                        /*
                         * ------------------------------------------
                         * BUILD COLUMN LIST
                         * ------------------------------------------
                         * 
                         * start by building the column list
                         * 
                         */

                        //start the columns list
                        $_columns = '(';

                        //set the last item in the array as count - 1
                        $last = count($values) - 1;

                        //start the count form 0
                        $x = 0;

                        //loop throw the array
                        foreach($values as $column => $value)
                        {
                                //check if last item
                                if($x != $last)
                                {
                                        $_columns .= $column . ', ';
                                }
                                else
                                {
                                        $_columns .= $column;
                                }

                                $x++;
                        }

                        //end the columns list
                        $_columns .= ')';

                        /*
                         * --------------------------------------------------
                         * BUILD VALUES LIST
                         * --------------------------------------------------
                         * 
                         * Build the list of values to be inserted
                         */

                        //reset x to 0
                        $x = 0;

                        //start the values list
                        $_values = '(';

                        foreach($values as $column => $value)
                        {
                                if($x != $last)
                                {
                                        $_values .= ":" . $column . ", ";
                                }
                                else
                                {
                                        $_values .= ":" . $column . "";
                                }

                                $x++;
                        }

                        $_values .= ')';

                        /*
                         * ----------------------------------------------
                         * BIULD FINAL INSERT STATEMENT
                         * ----------------------------------------------
                         * 
                         * Now we put all the parts together
                         */

                        if(!is_null($table))
                        {
                                $_statement = 'INSERT INTO ' . $table . $_columns . ' VALUES ' . $_values;

                                $this->_final_statement = $_statement;

                                $this->_bind_params = $values;


                                $this->execute();
                        }
                }
                else
                {
                        exit('Insert values must be passes as an array');
                }

        }


        public function update($values, $table = NULL, $where)
        {
                if(is_array($values))
                {
                        /*
                         * ---------------------------------------------------
                         * BUILD SET LIST
                         * ---------------------------------------------------
                         * 
                         * first we build the set list
                         * 
                         */

                        $_set = 'SET ';

                        $last = count($values) - 1;

                        $x = 0;

                        foreach($values as $column => $value)
                        {
                                if($x != $last)
                                {
                                        $_set .= $column . ' = :' . $column . ', ';
                                }
                                else
                                {
                                        $_set .= $column . ' = :' . $column;
                                }
                                $x++;
                        }

                        /*
                         * ---------------------------------------------------
                         * BUILD WHERE CLAUSE
                         * ---------------------------------------------------
                         * 
                         * Now build the where clause
                         * 
                         */

                        if(is_array($where))
                        {

                                $_where = '';

                                foreach($where as $column => $value)
                                {
                                        $_where .= $column . ' = :' . $column;
                                }
                        }

                        /*
                         * --------------------------------------------------
                         * BUILD FINAL UPDATE STATEMENT
                         * --------------------------------------------------
                         * 
                         * Now we put all the parts together
                         * 
                         */
                        if(!is_null($table))
                        {
                                $_statement = 'UPDATE ' . $table . ' ' . $_set . ' WHERE ' . $_where;
                        }

                        $this->_final_statement = $_statement;

                        $this->_bind_params = array_merge($values, $where);

                        $this->execute();
                }

        }


        /**
         * -------------------------------------------------------------------------------
         * BUILD QUERY
         * -------------------------------------------------------------------------------
         * 
         * puts all the pieces of the query together
         * 
         *  
         */
        protected function build_query()
        {


                //sStart the statment
                $_statement = 'SELECT ';

                //check select is set and add it to the statment
                if(!is_null($this->_select))
                {
                        $_statement .= $this->_select;
                }

                //check if from is set and add it to the statement
                if(!is_null($this->_from))
                {
                        $_statement .= 'FROM ' . $this->_from;
                }

                //add joins
                if(!is_null($this->_join))
                {
                        $_statement .= $this->_join;
                }

                //add where clause
                if(!is_null($this->_where))
                {
                        $_statement .= ' WHERE ' . $this->_where;
                }

                //add order by 
                if(!is_null($this->_order_by))
                {
                        $_statement .= ' ORDER BY ' . $this->_order_by;
                }

                //add limit
                if(!is_null($this->_limit))
                {
                        $_statement .= ' LIMIT ' . $this->_limit;

                        if(!is_null($this->_offset))
                        {
                                $_statement .= ', ' . $this->_offset;
                        }
                }



                $this->_final_statement = $_statement;



                //echo $this->_final_statement;

        }


        /**
         * -------------------------------------------------------------------------------
         * EXECUTE
         * -------------------------------------------------------------------------------
         * 
         * Runs the final query and returns the result
         * 
         * @return array        - returns results as an array (uses PDO::FETCH_ASSOC) 
         */
        public function execute()
        {
                //if the final statement has not been set run it
                if(is_null($this->_final_statement))
                {
                        $this->build_query();
                }


                //check if the final statement is still null
                if(!is_null($this->_final_statement))
                {
                        //prepare the statement
                        $this->_stm = $this->_conn->prepare($this->_final_statement);
                }
                else
                {
                        exit('No statement to execute');
                }

                //check there are any paramas to bind
                if(is_null($this->_bind_params))
                {
                        $this->_stm->execute();
                }
                else
                {
                        $this->_stm->execute($this->_bind_params);
                }

                debug::log($this->_final_statement, 2);

                $this->reset();

                return $this->_stm->fetchAll(PDO::FETCH_ASSOC);

        }


        /**
         * ----------------------------------------------------------
         * GET STATEMENT OBJECT
         * ----------------------------------------------------------
         * 
         * This method returns the _stm proprty. The _stm property holds the PDO::STATEMENT object
         * 
         * @return type 
         */
        public function get_statement()
        {
                if(!is_null($this->_stm))
                {
                        return $this->_stm;
                }
                else
                {
                        die('The statment is null');
                }

        }


        /**
         * ------------------------------------------------------------
         * RESET
         * ------------------------------------------------------------
         * 
         * Simply resets the parts of the statement so running a query from
         * an instanced returned form the singleton doesnt run the previous statement.
         * 
         * Note it does not reset the _conn or _stm so they still can be used after the
         * results are returned. the _conn and _stm properties get overwritten the next time
         * a query is run.
         *  
         */
        public function reset()
        {

                $this->_select = NULL;

                $this->_from = NULL;

                $this->_join = NULL;

                $this->_where = NULL;

                $this->_order_by = NULL;

                $this->_limit = NULL;

                $this->_offset = NULL;

                $this->_bind_params = NULL;

                $this->_final_statement = NULL;

        }


        //returns an instance of the db object to allow for chaining in query building methods
        protected function &getInstance()
        {
                return self::$instance;

        }


}

?>
