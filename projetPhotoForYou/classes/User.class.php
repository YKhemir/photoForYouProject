<?php 
class User {
    // Attributs 
    private $_id;
    private $_nom;
    private $_prenom;
    private $_type;
    private $_mail;
    private $_mdp;
    private $_credit;

    // hydratation 
    public function __construct(array $donnees){
        $this -> hydrate ($donnees);
    }

    public function hydrate (array $donnees){

        foreach($donnees as $key => $value){
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
			{
				$this->$method($value);
			}

        }

    }
    // Getters 
    public function getId (){
        return $this -> _id;
    }
    public function getNom (){
        return $this -> _nom;
    }
    public function getPrenom(){
        return $this -> _prenom;
    }
    public function getType(){
        return $this -> _type;
    }
    public function getMail(){
        return $this -> _mail;
    }
    public function getMdp(){
        return $this -> _mdp;
    }
    public function getCredit(){
        return $this -> _credit;
    }

    //Setters 
    public function setId($id){
       $id = (int) $id;
       if ($id > 0){
        return $this -> _id = $id;
       }
    }

    public function setNom($nom){
        if (is_string($nom)){
            return $this -> _nom = $nom;
        }
    }

    public function setPrenom($prenom){
        if(is_string($prenom)){
            return $this -> _prenom = $prenom;
        }
    }
    public function setType($type){
        if (is_string($type)){
            return $this -> _type = $type;
        }
    }

    public function setMail($mail){
        return $this ->  _mail = $mail;
    }

    public function setMdp ($mdp){
        return $this -> _mdp = $mdp;
    }
    public function setCredit($credit){
        $credit =(int) $credit;
        $this -> _credit = $credit;

    }

}

?>