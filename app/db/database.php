<?php 
namespace App\db;
use \PDO;
use \PDOException;
use App\classes\leemclasses;
use App\db\dbinfo;


class database{
    
    protected $host;
    protected $user;
    protected $pass;
    protected $name;
    

    /**
     * Tabela a ser manipulada
     * @var string
     */
    private $table ;


    /**
     * Instancia de conexão com o banco de dados
     * @var PDO
     */
    private $connection;

    /**
     * Define a tabela e instancia a conexão
     * @param string $table
     */
    public function __construct($table = null)
    {
    
     $this->table = $table; 
     $this->setConnection();  
    }

    private function getConectInfo(){
        $response = dbinfo::inite();
        $this->name = $response['name'];
        $this->host = $response['host'];
        $this->pass = $response['pass'];
        $this->user = $response['user'];
    }

    
    /**
     * Metodo responsavel por criar uma conexão com o banco de dados
     */
    private function setConnection(){

        try{
            $this->getConectInfo();
            $this->connection = new PDO("mysql:host=".$this->host.';dbname='.$this->name,$this->user,$this->pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
            leemclasses::newLog("PDO ERROR:". $e->getMessage());
            print "Data Base connection error!";
            $this->restart_install($e->getCode());
            die();
        }

    }

    /**
     * Metodo responsavel por executar querys dentro do banco de dados
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function execute($query,$params=[]){

        try{
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        }catch(PDOException $e){

           leemclasses::newLog("DB ERROR:". $e->getMessage()." [QUERY: $query]");
            return null;
        }
        
    }

    public function exec($query){

        try{
            $statement = $this->connection->exec($query);
            return $statement;
        }catch(PDOException $e){
            
            leemclasses::newLog("DB ERROR:". $e->getMessage()." [QUERY: $query]");
            return null;
        }
        
        

    }

    /**
     * Metodo responsavel por inserir dados no banco
     * @param array $values [field => value]
     * @return integer
     */
    public function insert($values){
        //DADOS DA QUERY
        $fields = array_keys($values);
        $binds = array_pad([],count($fields),'?');

        //MONTA A QUERY
        $query = "INSERT INTO $this->table (".implode(',',$fields).") VALUES (".implode(',',$binds).")";

        $this->execute($query,array_values($values));

        //RETORNAR O ID INSERIDO
        return $this->connection->lastInsertId();
        
    }

    /**
     * Metodo responsavel por actualizar os dados no banco
     * @param array $values [field => value]
     * @param string $where
     * @return integer
     */
    public function update($values,$where){
        //DADOS DA QUERY
        $fields = array_keys($values);
        $binds = array_pad([],count($fields),'?');
        $where = $where != null ? "WHERE $where":'';
        //MONTA A QUERY
        $query = "UPDATE $this->table SET ".implode('=?, ',$fields)."=? $where";

        
        //RETORNAR TRUE APÓS EXECUTAR FUNÇÃO
        if(!empty($this->execute($query,array_values($values)))){
            return true;
        }else{
            return false;
        }
        
        
        
    }

    /**
     * Metodo responsavel por consultar dados no banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param array $fields
     * 
     * @return PDOStatement
     */
    public function select($where=null,$order=null,$limit=null,$fields='*'){
        //DADOS DA QUERY
        $where = !empty($where) ? 'WHERE '.$where:'';
        $order = !empty($order) ? 'ORDER BY '.$order:'';
        $limit = !empty($limit) ? 'LIMIT '.$limit:'';

        

        //MONTA A QUERY
        $query = "SELECT $fields FROM $this->table $where $order $limit";
        return $this->execute($query);
    }

public function selectINNERJOIN($where=null,$innerjoin = null,$order=null,$limit=null,$fields='*'){
    //DADOS DA QUERY
    $where = !empty($where) ? 'WHERE '.$where:'';
    $order = !empty($order) ? 'ORDER BY '.$order:'';
    $limit = !empty($limit) ? 'LIMIT '.$limit:'';
    $innerjoin = !empty($innerjoin) ? ' INNER JOIN '.$innerjoin.' ':'';
    

    //MONTA A QUERY
    $query = "SELECT $fields FROM $this->table $innerjoin $where $order $limit";
    return $this->execute($query);
}

    /**
     * Metodo responsavel por deletar um dado do banco de dados
     * @param String $where
     * @return true quando a acção for executada.
     */


    public function delete($where){
        $where = !empty($where) ? 'WHERE '.$where:'';

        $query = "DELETE FROM $this->table $where";
       // $this->execute($query);
        
        return  $this->exec($query);
    }

   public function restart_install($code){
    $errosCode = [2002,1049,1045];

    if(in_array($code,array_values($errosCode))){
        $dir_inite_setup = SITE_ROOT.'/app/setup/inite.php';
    
        $f = fopen("$dir_inite_setup",'w+');
        fwrite($f,'<?php'."\n".'$install_ = false;');
        fclose($f);
        header("location:".URI_NAME);
    }
        
    }
}
