<?php
class Connection
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $db;

    public function __construct()
    {
        $this->host = 'np16029-001.privatesql:35815';
        $this->dbname = 'licence17';
        $this->username = 'licence17';
        $this->password = 'ef7Fbd14c6';
        
        try {
            
            $this->db = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8", $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch (PDOException $e) {
            
            echo 'Erreur de connexion : ' . $e->getMessage();
            exit; 
        }
    }

    public function getDb()
    {
        return $this->db;
    }
}
?>
