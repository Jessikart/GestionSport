<?php
	
/**
* Définition d'une classe permettant de gérer les equipes
*   en relation avec la base de données	
*/
class EquipesManager
    {
        private $_db; // Instance de PDO - objet de connexion au SGBD
        
		/**
		* Constructeur = initialisation de la connexion vers le SGBD
		*/
        public function __construct($db) {
            $this->_db=$db;
        }

        /**
		* ajout d'une equipe dans la BD
		* @param equipe à ajouter
		* @return  true si l'ajout a bien eu lieu, false sinon
		*/
        public function add(equipes $equipes) {
            // calcul d'un nouveau code equipe non déja utilisé = Maximum + 1
			$stmt = $this->_db->prepare("SELECT MAX(id_equipe) AS MAXIMUM FROM equipes");
			$stmt->execute();
            $equipes->setId_equipe($stmt->fetchColumn()+1);
            
            // requete d'ajout dans la BD
			$req = "INSERT INTO equipes (id_equipe,nom,date_de_creation,embleme,entraineur) VALUES (?,?,?,?,?)";
			$stmt = $this->_db->prepare($req);
			$res  = $stmt->execute(array($equipes->id_equipe(),$equipes->nom(),$equipes->date_de_creation(),$equipes->embleme(),$equipes->entraineur()));		
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
            return $res;
        }
        /**
		* nombre d'equipe dans la base de données
		* @return int le nb d'equipe
		*/
        public function count() {
            $stmt = $this->_db->prepare('SELECT COUNT(*) FROM equipes');
			$stmt->execute();
			return $stmt->fetchColumn();
        }
        /**
		* suppression d'une equipe dans la base de données
		* @param equipes 
		* @return boolean true si suppression, false sinon
		*/
        public function delete(equipes $equipes) : bool {
            $req = "DELETE FROM equipes WHERE id_equipe = ?";
			$stmt = $this->_db->prepare($req);
            return $stmt->execute(array($equipes->id_equipe()));
        }
	
        /**
		* recherche dans la BD d'une equipe à partir de son code
		* @param int $id_equipe
		* @return equipes 
		*/
		public function get($id_equipe) : Equipes {
            $req = 'SELECT id_equipe, nom, date_de_creation, embleme, entraineur FROM equipes WHERE id_equipe = ?';
			$stmt = $this->_db->prepare($req);
			$stmt->execute(array($id_equipe));
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
			$equipes = new equipes($stmt->fetch());
            return $equipes;
        }
        /**
		* retourne l'ensemble des equipes présents dans la BD 
		* @return equipe[]
		*/		
        public function getList() {
            $equipes = array();
			$req = "SELECT id_equipe, nom, date_de_creation, embleme, entraineur, victoires, defaites, ville FROM equipes";
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
			// récup des données
            while ($donnees = $stmt->fetch())
            {
                $equipes[] = new equipes($donnees);
            }
            return $equipes;
        }
        /**
		* méthode de recherche d'equipe dans la BD à partir des critères passés en paramètre
		* @param string $nom
		* @param string $entraineur
		* @return equipes[]
		*/
	
	public function search(string $nom, string $victoiresMin):array {
			$req = "SELECT id_equipe,nom,date_de_creation,embleme,entraineur,victoires,defaites,ville FROM equipes";
			$cond = '';

			if ($nom<>"") 
			{ 	
				if ($cond<>"") { 
					$cond .= " AND ";
				}
				$cond = $cond . " nom like '%". $nom ."%'";
			}
			if ($victoiresMin<>"") 
			{ 	if ($cond<>"") $cond .= " AND victoires >= " . $victoiresMin;
			}
			if ($cond <>"")
			{ 	$req .= " WHERE " . $cond;
			}

            // execution de la requete				
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
			$equipes = array();
			while ($donnees = $stmt->fetch())
            {
                $equipes[] = new equipes($donnees);
            }
            return $equipes;
		} 

        /**
		* modification d'une equipe dans la BD
		* @param equipes
		* @return boolean 
		*/
        public function update(equipes $equipes) : bool
        {
            $req = "UPDATE equipes SET nom = :nom, "
					. "date_de_creation = :date_de_creation, "
					. "embleme = :embleme, "
					. "entraineur  = :entraineur"
					. " WHERE id_equipe = :id_equipe";
		//var_dump($equipes);

		$stmt = $this->_db->prepare($req);
		$stmt->execute(array(":nom" => $equipes->nom(),
								":date_de_creation" => $equipes->date_de_creation(),
								":embleme" => $equipes->embleme(),
								":entraineur" => $equipes->entraineur(),
							 	":id_equipe" => $equipes->id_equipe()));
	// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}					 
		return $stmt->rowCount() > 0;
	}
}

?>
