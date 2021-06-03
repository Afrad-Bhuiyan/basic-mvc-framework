<?php 

class database
{

    //intially connection with the database will be `false`
    private $conn=false;
    
    //store the mysqli's class instance
    private $mysqli="";

    //use the function to establish connection to the database
    protected function db_connect()
    {
        if(!$this->conn){

            $this->mysqli=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            
            if($this->mysqli->connect_error){

                echo "Database connection failed";
                die();
            }

            $this->conn = true;
        }
    }

    //use the function to disconnect with the database
    protected function db_disconnect()
    {
        if($this->conn){

            if($this->mysqli->close()){
                
                $this->conn=false;

            }else{

                return false;
            }
        }
    }

    //use the function to select records from a table
    protected function select(array $params = array(), string $table = "")
    {
        //store all the outputs
        $output=array();

        //store the model's table name if user did not passed any table name
        $table = (empty($table)) ? $this->table : $table; 

        if($this->if_table_exist($table)){

            //append `COLUMNS`  in sql 
            $columns = (isset($params["columns"])) ? $params["columns"] : "*";
            
            //appedend `WHERE` clause in sql
            $where = (isset($params["where"])) ? "WHERE {$params["where"]}" : "";
            
            //appedend `ORDER BY` clause in sql
            $order = (isset($params["order"])) ? "ORDER BY {$params["order"]["column"]} {$params["order"]["type"]}" : "";
            
            //appedend `LIMIT` clause in sql
            $limit = (isset($params["limit"])) ? "LIMIT {$params['limit']}" : "";

            //append all the tables which have/has to be joined
            $join = "";
            
            if(isset($params["join"])){

                //Run the loop for each table
                foreach($params["join"] as $join_table=>$point){
                    
                    //concate with the $join variable
                    $join .= " INNER JOIN {$join_table} ON {$point} ";    
                }
            }

            //finaly create the sql query to execute
            $sql = "SELECT {$columns} FROM {$table} {$join} {$where} {$order} {$limit}";
            
            //excute the sql query
            $excute=$this->mysqli->query($sql);

            if($excute){
                
                //store all the fetched information
                $output = array(
                    "error_status"=>0,
                    "num_rows"=>$excute->num_rows,
                    "fetch_all"=>$excute->fetch_all(MYSQLI_ASSOC)
                );
                
            }else{
                
               //store an error messag in the output
                $output = array(
                    "error_status"=>1,
                    "errors"=>"Query faild to execute",
                    "sql"=>$sql
                );
            }

        }else{
            
            $output = array(
                "error_status"=>1,
                "errors"=>"Table `{$table}` doesn't exist"
            );
        }

        
        return $output;
    }

    //use the function to insert record into a table
    protected function insert(array $params, string $table = "")
    {
        //store all the outputs
        $output=array();

        //store the model's table name if user did not passed any table name
        $table = (empty($table)) ? $this->table : $table; 

        if($this->if_table_exist($table)){

            //store all the columns name $params
            $columns = array_keys($params);
            
            //convert the columns array into a string and spreated by `,`
            $columns = implode(", ", $columns);
            
            //store all values for the columns
            $values = implode('", "',$params);
            
            //finaly create the sql query to execute
            $sql = "INSERT INTO {$table} ($columns) VALUES (\"$values\")";
        
             //excute the sql query
            $excute=$this->mysqli->query($sql);

            if($excute){
                
                //store all the fetched information
                $output = array(
                    "error_status"=>0,
                    "insert_id"=>$this->mysqli->insert_id
                );
                
            }else{
                
               //store an error messag in the output
                $output = array(
                    "error_status"=>1,
                    "errors"=>"Query faild to execute",
                    "sql"=>$sql
                );
            }

        }else{

            $output = array(
                "error_status"=>1,
                "errors"=>"Table `{$table}` doesn't exist"
            );
        }
        
        return $output;
    }

    //use the function to update a single record in a table
    protected function update(array $params, string $table = "")
    {
        //store all the outputs
        $output=array();

        //store the model's table name if user did not passed any table name
        $table = (empty($table)) ? $this->table : $table; 

        if($this->if_table_exist($table)){

            //store the columns and values
            $columns = array(); 

            foreach($params["columns"] as $column=>$value){

                //push the columns and value to $columns variable
                $columns[] = "{$column} = \"{$value}\"";
            }
            
            //conver the columns and value into a string spreated by `,`
            $columns = implode(", ", $columns);

            //appedend `WHERE` clause in sql
            $where = (isset($params["where"])) ? "WHERE {$params["where"]}" : "";
            
            //finaly create the sql query to execute
            $sql ="UPDATE {$table} SET {$columns} {$where}";

            //excute the sql query
            $excute=$this->mysqli->query($sql);

            if($excute){
                
                //store all the fetched information
                $output = array(
                    "error_status"=>0,
                    "affected_rows"=>$this->mysqli->affected_rows
                );
                
            }else{
                
               //store an error messag in the output
                $output = array(
                    "error_status"=>1,
                    "errors"=>"Query faild to execute",
                    "sql"=>$sql
                );
            }

        }else{
            
             $output = array(
                "error_status"=>1,
                "errors"=>"Table `{$table}` doesn't exist"
            );
        }

        return $output;
    }

    //use the function to delete a single or all record from a table
    protected function delete(array $params = array(), string $table = "")
    {
        //store all the outputs
        $output=array();

        //store the model's table name if user did not passed any table name
        $table = (empty($table)) ? $this->table : $table; 

        if($this->if_table_exist($table)){

            //appedend `WHERE` clause in sql
            $where = (isset($params["where"])) ? "WHERE {$params["where"]}" : "";

            //finaly create the sql query to execute
            $sql= "DELETE FROM {$table} {$where}";

            //excute the sql query
            $excute=$this->mysqli->query($sql);

            if($excute){
                
                //store all the fetched information
                $output = array(
                    "error_status"=>0,
                    "affected_rows"=>$this->mysqli->affected_rows
                );
                
            }else{
                
               //store an error messag in the output
                $output = array(
                    "error_status"=>1,
                    "errors"=>"Query faild to execute",
                    "sql"=>$sql
                );
            }

        }else{
            
             $output = array(
                "error_status"=>1,
                "errors"=>"Table `{$table}` doesn't exist"
            );
        }
        

        
        echo "<pre>";
        print_r($output);
        echo "</pre>";

    }

    //use the function to check if table does exist
    private function if_table_exist($table)
    {
        //create query to check table exist in a database
        $sql="SHOW TABLES FROM ". DB_NAME ." LIKE '{$table}';";

        //excute the sql query
        $excute=$this->mysqli->query($sql);
        
        if($excute && $excute->num_rows == 1){
            
            //table exists return true
            return true;
            
        }else{
            
            //table does not exist return true
            return false;   
        }
    }

}



?>