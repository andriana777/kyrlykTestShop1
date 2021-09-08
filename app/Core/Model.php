<?php
namespace Core;

/**
 * Class Model
 */
class Model implements DbModelInterface
{
    /**
     * @var
     */
    protected $table_name;
    /**
     * @var
     */
    protected $id_column;
    /**
     * @var array
     */
    protected $columns = [];
    /**
     * @var
     */
    protected $collection;
    /**
     * @var
     */
    protected $sql;
    /**
     * @var array
     */
    protected $params = [];
    
    
    /**
     * @return $this
     */
    public function initCollection()
    {
        $columns = implode(', ',$this->getColumns());
        $this->sql = "select $columns from " . $this->table_name ;
        return $this;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        $db = new DB();
        $sql = "show columns from  $this->table_name;";
        $results = $db->query($sql);
        foreach($results as $result) {
            array_push($this->columns,$result['Field']);
        }
        return $this->columns;
    }


    /**
     * @param $params
     * @return $this
     */
    public function sort($params)
    {   
                
    $sort1='';
    $this->sql .= " ORDER BY ";
     //$this->sql = "SELECT * FROM $this->table_name ORDER BY ";
     foreach ($params as $key=>$value) {
    $sort1 = "$key $value";
     $this->sql .= "$key $value, "; 
     } 
     $this->sql = rtrim(($this->sql), ', ');
      
        return $this;
    }

    /**
     * @param $params
     */
    public function filterPrice()
    {
        $parameters ='';
    // $key = array_keys($params)[0];
     if (!empty($_POST['from'])){
         $from = $_POST['from']; 
        // $from = filter_input(INPUT_POST, 'from');
     } else { 
         $from = 0;
       }
     If (!empty($_POST['to'])) {
         $to = $_POST['to'];
        // $to = filter_input(INPUT_POST, 'to');
     } else {
           $to = $this->getMaxPrice();
       }
       
       $this->sql .= " WHERE price BETWEEN $from AND $to ";
       //array_push($this->parameters, $from);
      // array_push($this->parameters, $to);
       return $this;
    
     
    }

   public function filter($params)
   {    
       //$this->sql = "SELECT * FROM customer WHERE ";
       $this->sql .= " WHERE ";
       foreach($params as $k=>$v) {
          $this->sql.= "{$k} = ? AND ";
          // $this->sql.= "$k = '$v' AND ";
       }
       $this->sql = mb_substr($this->sql,0, -4);
     
       $this->params = array_values($params);
       return $this;
   }
    
    public function getMaxPrice() 
    {
        $db = new DB();
        $sql = "SELECT MAX(price) FROM $this->table_name";
        $maxPrice = $db->query($sql);
        return $maxPrice[0]['MAX(price)'];

    }
    public function getCollection()
    {
        $db = new DB();
        $this->sql .= ";";
        $this->collection = $db->query($this->sql, $this->params);
        return $this;
    }

    /**
     * @return mixed
     */
    public function select()
    {
        return $this->collection;
    }

    /**
     * @return null
     */
    public function selectFirst()
    {
        return isset($this->collection[0]) ? $this->collection[0] : null;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getItem($id)
    {
        $sql = "select * from $this->table_name where $this->id_column = ?;";
        $db = new DB();
        $params = array($id);
        return $db->query($sql, $params)[0];
    }

    /**
     * @return array
     */
    public function getPostValues()
    {
        $values = [];
        $columns = $this->getColumns();
        foreach ($columns as $column) {
            
            if ( isset($_POST[$column]) && $column !== $this->id_column ) {
                $values[$column] = $_POST[$column];
            }
             
             
            $column_value = filter_input(INPUT_POST, $column);
            if ($column_value && $column !== $this->id_column ) {
                $values[$column] = $column_value;
            }

        }
        return $values;
    }

    public function getTableName(): string
    {
        return $this->table_name;
    }

    public function getPrimaryKeyName(): string
    {
        return $this->id_column;
    }

    public function getId()
    {
        return 1;
    }
  
    public function addItem($values)
    {
        $db = new DB;
        $cols = '';
        $val = '';
        //$values = $this->myValidator($values);
        foreach ($values as $k=>$v) {
            
            $cols .= "$k, ";
            $val .= "'$v', ";
        }
            $cols = rtrim($cols, ", ");
            $val = rtrim($val, ", ");
     
          $sql = "INSERT INTO $this->table_name ($cols) VALUES ($val)";
         
       $db->query($sql);
     //return $lastId= $pdo::lastInsertId();
       //$db->lastInsertId();
    
}
    public function saveItem($id, $values)
    {
        $db = new DB;
        $val = '';
        foreach ($values as $k=>$v) {
            
            $val .= "`$k`='$v', ";
        }
           //$id='';
            $val = rtrim($val, ", ");
       // $id = $_GET[id];
      //  $id = $this->getId();
         $sql = "UPDATE $this->table_name SET $val WHERE $this->id_column =$id";
         
       $db->query($sql);
          
    }
    
    
    public function deleteItem($id)
	{       
                $db = new DB();
               $ident = filter_input(INPUT_GET, 'id');
		$sql = "DELETE FROM $this->table_name WHERE id = $ident";
		
		return $db->query($sql);
	}

    
    
    public function myValidator($values)
    {
        $arg = array(
            'sku' => FILTER_SANITIZE_STRING,
            'name' => FILTER_SANITIZE_STRING,
            'price'=> FILTER_VALIDATE_FLOAT, 
            'qty'=> FILTER_VALIDATE_FLOAT, 
            'description'=> FILTER_SANITIZE_STRING,
        );
        $filtered= filter_var_array($values, $arg);
        foreach ($filtered as $key=>$text) {
            if ($key==='description') {
                $text = htmlspecialchars($text);
            }
        }
        return $filtered;
        
    }
    
   public function getLast() {
       $db = new DB();
       $result = $db->getConnection()->lastInsertId();
       return $result;
   }
    
     public function getProductId()
    {
        
        if (isset($_GET['id'])) {
         
            return $_GET['id'];
        } else {
            return NULL;
        }
        
        return filter_input(INPUT_GET, 'id');
    }
    
    public function addUser($values)
    {
        $db = new DB;
        $cols = '';
        $val = '';
        
        foreach ($values as $k=>$v) {
            
            $cols .= "$k, ";
            $val .= "'$v', ";
        }
            $cols = rtrim($cols, ", ");
            $val = rtrim($val, ", ");
     
          $sql = "INSERT INTO $this->table_name ($cols) VALUES ($val)";
         
       $db->query($sql);
     
}

public function regValidator($values) {
    $values['password1'] = filter_input(INPUT_POST, 'password1');
    foreach ($values as $k=>$v) {
        if (!empty($v)){
            trim($v);
            $v = filter_var($v, FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            echo "Заповніть усі поля, будь-ласка";
            exit();
        }
    }
            if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
              echo "Даний емейл не є валідним";
              exit();
            }
        if ($values['password'] === $values['password1']) {
           
            if (!preg_match('#^[a-zA-Z0-9]{8,}$#', $values['password'])) {
                echo "Даний пароль не може бути встановлено. "
                . "Пароль повинен містити лише латинські букви та цифри і мати не менше 8 знаків";
                exit();
              //  echo "Даний пароль не може бути встановлено";
            }   
        }else{
            echo "Паролі не співпадають";
            exit();
    } 
    $values['password'] = md5($values['password']);
    unset($values['password1']);
       return $values;
}
}
