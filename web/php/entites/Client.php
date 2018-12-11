<?php 
include_once("modele.php");
class Client extends Modele
{
    private $nomprenom, $telephone, $datereservation, $civilite;
    
    function __construct($nomprenom="",$telephone="",$datereservation="",$civilite="") {

    parent::__construct();
        $this->nomprenom = $nomprenom;
        $this->telephone = $telephone;
        $this->datereservation = $datereservation;
        $this->civilite = $civilite;
    }

    function insert($nomprenom,$phone,$listeplats){
        $query="insert into commandes (nomprenom,telephone)values (?, ?, ?, ?)";
        $res=$this->pdo->prepare($query);
        return $res->execute(array($nomprenom,$phone,$listeplats));


        }
//
//        function delete($idClient) {
//            $query = "delete from Client where idClient=?";
//            $res=$this->pdo->prepare($query);
//            return $res->execute(array($idClient));
//        }


        function liste(){
            $res=$this->pdo->query('SELECT * FROM commandes');
            $posts=$res->fetchAll(PDO::FETCH_OBJ);
            return $posts;
    
        }


    }
