<?php 
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    http_response_code(403);
    header("location:../auth/accessDenied.php ");
    exit();
}
class database{
    private $servername='localhost';
    private $username='root';
    private $password='';
    private $dbname='DBVotCauLong';
    private $result=null;
    private $conn=null;
    public function __construct()
    {
        $this->connect();
    }
    private function connect()
    {
        $this->conn=new mysqli($this->servername,$this->username,$this->password,$this->dbname);
        if($this->conn->connect_error)
        {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8");
    }
    
    public function select($sql)
    {
        $this->result = $this->conn->query($sql);
        if(!$this->result)
        {
            die("Lỗi truy vấn: " . $this->conn->error);
        }
        return $this->result;
    }
    
    public function fetch()
    {
        if($this->result && $this->result->num_rows >0)
        {
            return $this->result->fetch_assoc();
        }
        return null;
    }
    public function numRows()
    {
        return $this->result->num_rows;
    }
    public function fetchAll()
    {
        if($this->result && $this->result->num_rows >0)
        {
            return $this->result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    public function insert($sql)
    {
        if($this->conn->query($sql)===true)
        {
            return $this->conn->insert_id;
        }
        else
        {
            die("Lỗi: ".$this->conn->error);
        }
    }
    public function delete($sql)
    {
        if($this->conn->query($sql)===true)
        {
            return $this->conn->affected_rows;
        }
        else
        {
            die("Lỗi: " . $this->conn->error);
        }
    }
    public function update($sql)
    {
       if($this->conn->query($sql)===true)
       {
            return $this->conn->affected_rows;
       }
       else
       {
            die("Lỗi: ".$this->conn->error);
       }
    }
    public function close()
    {
        if ($this->conn) 
        {
            $this->conn->close();
        }
    }
}


?>