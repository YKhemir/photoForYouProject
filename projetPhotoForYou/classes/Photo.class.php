<?php
class Photo {
    // attributs 
    private $_id_photo;
    private $_nom_photo;
    private $_taille_pixelle_x;
    private $_taille_pixelle_y;
    private $_poids;
    private $_nbredephoto;
    private $_prix_photo;
    private $_categorie_photo;


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
    public function getid_photo(){
        return $this -> _id_photo;
    }
    public function getnom_photo(){
        return $this -> _nom_photo;
    }
    public function gettaille_pixels_x(){
        return $this -> _taille_pixelle_x;
    }
    public function gettaille_pixels_y(){
        return $this -> _taille_pixelle_y;
    }
    public function getpoids(){
        return $this -> _poids;
    }
    public function getnbrdephoto(){
        return $this -> _nbredephoto;
    }

    public function getprixphoto(){
        return $this -> _prix_photo;
    }
    public function getcategoriephoto(){
        return $this -> _categorie_photo;
    }
    
    // setters 
    public function setid_photo($id){
        $id = (int) $id;
        if ($id > 0){
         return $this -> _id_photo = $id;
        }
    }
    public function setnom_photo($nomphoto){
        $this -> _nom_photo = $nomphoto;
    }

    public function settaille_pixels_x($taillepix){
        $this -> _taille_pixelle_x = $taillepix;
    }
    public function settaille_pixels_y($taillepixy){
        $this -> _taille_pixelle_y = $taillepixy;
    }
    public function setpoids($poids){
        $this -> _poids =$poids;
    }
    public function setnbrdephoto($nbre){
        if($nbre == 1){
            $this -> _nbredephoto = $nbre;
        }
        
    }
    public function setprixphoto($prix){
        if($nbre = 1){
            $this -> _prix_photo = $prix;
        }
        
    }
    public function setcategoriephoto($categorie){
        $this -> _categorie_photo = $categorie;
    }
    
}


?>