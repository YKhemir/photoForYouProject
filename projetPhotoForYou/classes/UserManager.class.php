<?php 
Class UserManager{
    private $_db;
    public function __construct($db){
        $this->setDb($db);
	}
       
    
    // CRUD 
    public function add(User $user){
        $q = $this -> _db -> prepare('INSERT INTO users (Nom,Prenom
                        ,Type,Mail,Mdp,Credit)VALUES(
                        :Nom,:Prenom,:Type,:Mail,:Mdp
                        ,:Credit)');
        $q -> BindValue(':Nom', $user -> getNom());
        $q -> BindValue(':Prenom',$user -> getPrenom());
        $q -> BindValue(':Type', $user -> getType());
        $q -> BindValue(':Mail', $user -> getMail());
        $q -> bindValue(':Mdp', md5($user -> getMdp()));
         //$q -> bindValue(':Credit', $user -> getCredit());
        $q->bindValue(':Credit', $user->getCredit() ?? 0);
        $q -> execute();

        $user->hydrate([
			'Id' => $this->_db->lastInsertId(),
			'Credit' => 0]);
    }
    public function delete(User $user){}
    public function update(){
    }
    public function getUser($sonMail){
        $q = $this -> _db -> query('SELECT id , Nom, Prenom, Mail, Mdp, Type FROM users WHERE Mail = "'. $sonMail .'"');
        $userInfo = $q-> fetch(PDO::FETCH_ASSOC);
        if($userInfo){
            return new User($userInfo);
        } else {
            return $userInfo;
        }
    }

    public function getTypeUser()
    {
    // Assurez-vous que $_SESSION['user_id'] est défini
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        $q = $this->_db->prepare('SELECT id Type FROM users WHERE id = :id_user');
        $q->bindParam(':id_user', $userId, PDO::PARAM_INT);
        $q->execute();

        $userInfo = $q->fetch(PDO::FETCH_ASSOC);

        if ($userInfo) {
            return $userInfo['Type'];
        }
    }

    }

    function getUserId()
    {
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        }
    }
    
    public function emailExists($email)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM users WHERE mail = :mail');
        $q->execute([':mail' => $email]);
        return (bool) $q->fetchColumn();
    }

    public function exists($mailUser, $mdpUser)
	{
		$q= $this->_db->prepare('SELECT COUNT(*) FROM users WHERE mail = :mail AND mdp = :mdp');
		$q->execute([':mail'=> $mailUser, ':mdp'=> md5($mdpUser)]);
		return (bool) $q->fetchColumn();
	}
    
    public function setDb(PDO $db){
        $this -> _db = $db;
    }
}
