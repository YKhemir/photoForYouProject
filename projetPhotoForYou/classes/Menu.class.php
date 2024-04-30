<?php 
Class Menu{
    // attributs 
    private $_idMenu;
    private $_nomMenu;
    private $_lien;
    private $_habilisation;

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
// getters
public function getidMenu (){
    return $this -> _idMenu;
}
public function getnomMenu(){
    return $this -> _nomMenu;
}
public function getlien(){
    return $this -> _lien;
}
public function gethabilisation(){
    return $this -> _habilisation;
}
//seterrs 
public function setidMenu (){
    return $this -> _idMenu;
}
public function setnomMenu(){
    return $this -> _nomMenu;
}
public function setlien(){
    return $this -> _lien;
}
public function sethabilisation(){
    return $this -> _habilisation;
}
}
?>