<?php
// utilisation des sessions
session_start();
// si la variable de session n'existe pas, on la crée
if (!isset($_SESSION['acces'])) {
  $_SESSION['acces']=FALSE;
	$_SESSION['id']=0;
}
//var_dump($_SESSION['acces']);

// connexion à la BD
include("connect.php");
// moteur de templates Twig
include ('moteurtemplate.php');
// le controller
include('Controllers/equipesController.php');
$equipesController = new EquipesController($bdd,$twig);
include('Controllers/matchsController.php');
$matchsController = new MatchsController($bdd,$twig);
include('Controllers/membreController.php');
$membreController = new MembreController($bdd,$twig);
/*include('Controllers/commentairesController.php');
$commentairesController = new CommentairesController($bdd,$twig);*/


//// la classe equipes
include_once('Entities/equipes.php');
include_once('Entities/matchs.php');
include_once('Entities/membre.php');
include_once('Entities/commentaire.php');

// le manager (lien avec la BD)
include_once('Models/equipesManager.php');
include_once('Models/matchsManager.php');
include_once('Models/membreManager.php');
include_once('Models/commentairesManager.php');

// manager de gestion des equipes
$managerEquipe = new equipesManager($bdd);
$managerMatchs = new matchsManager($bdd);
$managerMembre = new membreManager($bdd);
$managerCommentaires = new commentairesManager($bdd);

// --- router
if (isset($_GET["action"])) {
  $action = $_GET["action"]; 
  switch ($action) {
	case "accueil" :
		$matchsController->index();
		break;
	case "liste_equipe" :
		$equipesController->listeEquipe();
		break;	
	case "liste_equipes" :
		$equipesController->listeEquipes();
		break;
	case "recher_equipe" :
			$equipesController->formRechercheEquipes();
			break;	
	case "valider_recher_equipe" :
			$equipesController->rechercheEquipes();
			break;
	case "ajout_equipe" :
		$equipesController->formAjoutEquipes();
		break;	
	case "valider_ajout_equipe" :
		$equipesController->ajoutEquipes();
		break;
	case "choix_supp_equipe" :
		$equipesController->choixSuppEquipe();
		break;
	case "valider_choixsupp_equipe" :
		$equipesController->suppEquipe();
		break;
	case "choix_mod_equipe" :
		$equipesController->choixModEquipes();
		break;
	case "mod_equipe" :
		$equipesController->saisieModEquipe();
		break;
	case "valider_mod_equipe" :
		$equipesController->modEquipe();
		break;
	case "liste_match" :
		$matchsController->afficherMatchs();
		break;
	case "ajout_matchs" :
		$matchsController->formAjoutMatchs();
		break;	
	case "valider_ajout_matchs" :
			$matchsController->ajoutMatchs();
			break;
	case "choixsupp_matchs" :
			$matchsController->choixSuppMatchs();
			break;
	case "valider_choixsupp_matchs" :
			$matchsController->suppMatchs();
			break;
	case "choix_mod_matchs" :
			$matchsController->choixModMatchs();
			break;
	case "mod_matchs" :
			$matchsController->saisieModMatchs();
			break;
	case "valider_mod_matchs" :
			$matchsController->modMatchs();
			break;
	case "liste_matchs" :
			$matchsController->listeMatchs();
			break;
	case "valider_commentaire" :
		  	$matchsController->ajoutCom();
			break;
	case "recher_matchs" :
		$matchsController->formRechercheMatchs();
		break;	
	case "valider_recher_matchs" :
		$matchsController->rechercheMatchs();
		break;
	case "logout" :
		$membreController->membreDeconnexion();
		break;
	case "inscription" :
		$membreController->membreFormIns();
		break;
	case "valider_inscription" :
		$membreController->membreInscription();
		break;
	case "login" :
		$membreController->membreFormulaire();
		break;
	case "valide_login" :
		$membreController->membreConnexion($_POST);
		break;	  
	default;
  }
}
else {
	echo $twig->render('index.html.twig',array('acces' =>$_SESSION['acces']));  // page par défaut
	}
?>