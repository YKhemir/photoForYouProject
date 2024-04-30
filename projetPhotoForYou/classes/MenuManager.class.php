<?php 
Class MenuManager {
    // attributs 
    private $_db;
    public function __construct($db){
        $this->setDb($db);
	}
    public function getmenu($sonType){
        $q = $this -> _db -> prepare('SELECT nomMenu, Lien FROM menu WHERE Habilitation LIKE :sonType');
        $q->bindParam(':sonType', $sonType, PDO::PARAM_STR);
        $q->execute();
        $menuItems = $q -> fetchAll(PDO::FETCH_ASSOC);
        return $menuItems;
    }

    

    public function setDb(PDO $db){
        $this -> _db = $db;
    }

}
