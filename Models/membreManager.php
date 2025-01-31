<?php

/**
* Définition d'une classe permettant de gérer les membres 
* en relation avec la base de données
*
*/

class MembreManager
    {
        private $_db; // Instance de PDO - objet de connexion au SGBD
        
		/** 
		* Constructeur = initialisation de la connexion vers le SGBD
		*/
        public function __construct($db) {
            $this->_db=$db;
        }
		
		/**
		* verification de l'identité d'un membre (Login/password)
		* @param string $login
		* @param string $password
		* @return membre si authentification ok, false sinon
		*/
		public function verif_identification($login, $password) {
			$req = "SELECT idmembre, EMAIL, PASSWORD FROM membre WHERE EMAIL LIKE ? AND PASSWORD LIKE ?;";
			$stmt = $this->_db->prepare($req);
			$stmt->execute(array($login,$password));
			if ($data=$stmt->fetch()) { 
				$membre = new Membre($data);
				$_SESSION['id']=$membre->idMembre();
				return $membre;
				}
			else return false;
		}
	
	/**
		* ajout d'un membre dans la BD
		* @param membre à ajouter
		* @return  true si l'ajout a bien eu lieu, false sinon
		*/
	public function add(membre $membre) {
            // calcul d'un nouveau code membre non déja utilisé = Maximum + 1
			$stmt = $this->_db->prepare("SELECT MAX(idmembre) AS MAXIMUM FROM membre");
			$stmt->execute();
            $membre->setIdmembre($stmt->fetchColumn()+1);
		// requete d'ajout dans la BD
			$req = "INSERT INTO membre (idmembre,nom,prenom,email,password,anneenaissance,sexe,telportable) VALUES (?,?,?,?,?,?,?,?)";
			$stmt = $this->_db->prepare($req);
			$res  = $stmt->execute(array($membre->idmembre(),$membre->nom(),$membre->prenom(),$membre->email(),$membre->password(),$membre->anneenaissance(),$membre->sexe(),$membre->telportable()));		
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
            return $res;
        } 
	

    }
?>