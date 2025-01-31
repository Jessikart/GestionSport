<?php
include "Entities/membre.php";
include "Models/membreManager.php";
/**
* Définition d'une classe permettant de gérer les membres 
*   en relation avec la base de données	
*/	
class MembreController {
    private $membreManager; // instance du manager
	private $twig; 

	/**
	* Constructeur = initialisation de la connexion vers le SGBD
	*/
	public function __construct($db,$twig) {
		$this->membreManager = new MembreManager($db);
		$this->twig = $twig;
	}
        
	/**
	* connexion
	* @param aucun
	* @return rien
	*/
	function membreConnexion($data) {
		
		if ($this->membreManager->verif_identification($_POST['Email'], $_POST['passwd'])) { // acces autorisé : variable de session acces = oui
			$_SESSION['acces']=TRUE;
			var_dump($_SESSION['id']);
			$message = "Bonjour !";
			echo $this->twig->render('index.html.twig',array('acces' =>$_SESSION['acces'])); 
			return $message; 
		} else { // acces non autorisé : variable de session acces = non

			$message = "identification incorrecte";
			echo $message;
			echo $this->twig->render('index.html.twig',array('acces' =>$_SESSION['acces'])); 
			return $message; 
    	} 
	}

	/**
	* deconnexion
	* @param aucun
	* @return rien
	*/
	function membreDeconnexion() {
		$_SESSION['acces']=FALSE;
		$_SESSION['id']=0;
		$message = "vous êtes déconnecté";
		echo $this->twig->render('index.html.twig',array('acces' =>$_SESSION['acces'])); 
		return $message;
	}

	/**
	* formulaire de connexion
	* @param aucun
	* @return rien
	*/
	function membreFormulaire() {
        echo $this->twig->render('connexion.html.twig',array('acces' =>$_SESSION['acces'])); // viewer
	}
	function membreFormIns() {
        echo $this->twig->render('inscription.html.twig',array('acces' =>$_SESSION['acces'])); // viewer
	}
	/**
	* ajout dans la BD d'un membre à partir du form
	* @param aucun
	* @return rien
	*/
	public function membreInscription() {
		// création d'un nouveau match
		$membre = new membre ($_POST);
		// ajout du match dans la base de données
		$ok = $this->membreManager->add($membre);
		// le message d'état 
		if ($ok) { $message = "Inscription réussi"; }
		else { $message = "pb lors de l'inscription"; }
		// affichage du message
		echo $this->twig->render('index.html.twig',array('acces' =>$_SESSION['acces'],'message' => $message));
	}
	
	
}