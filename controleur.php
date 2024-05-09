<?php
include("model.php");
session_start() ;
 
$titreFilm = $_GET['titreFilm']; // 通过链接获取书籍标题
$IdDirecteur = $_GET['IdDirecteur']; // 通过链接获取作者ID
$IdFilm = $_GET['IdFilm']; // 通过链接获取书籍ID   

$dateEmprunt = date('Y-m-d'); // 当前日期, 计算归还日期（借阅当日往后推15天）
$dateRetour = date('Y-m-d', strtotime($dateEmprunt . ' + 15 days')); // 借阅当日往后推15天


$_SESSION['titreFilm'] = $titreFilm; // 存储到SESSION中
$_SESSION['IdDirecteur'] = $IdDirecteur;
$_SESSION['IdFilm'] = $IdFilm;
$_SESSION['dateEmprunt'] = $dateEmprunt;
$_SESSION['dateRetour'] = $dateRetour;

$IdUser = $_SESSION['IdUser'];
$nomUser = $_SESSION['nomUser'];
$IdFilm = $_SESSION['$IdFilm'];
   

class DirecteurControleur {
    
    private $directeurModel;

    public function __construct() {
        $this->directeurModel = new DirecteurModel();
    }

    // Recherche des réalisateurs
    public function directeur_recherche() {
        $this->directeurModel->directeur_recherche();
    }

    // Afficher tous les réalisateurs
    public function all_directeur() {
        $this->directeurModel->all_directeur();
    }

    // Afficher les informations de cinq réalisateurs aléatoires
    public function random_5_directeur() {
        $this->directeurModel->random_5_directeur();
    }

    // Afficher cinq types aléatoires
    public function random_5_type(){
        $this->directeurModel->random_5_type();
    }

    // Recherche des informations d'un réalisateur spécifique
    public function cherche_nom_directeur() {
        $this->directeurModel->cherche_nom_directeur();
    }

    // Afficher les films d'un réalisateur spécifique
    public function cherche_Film_directeur() {
        $this->directeurModel->cherche_Film_directeur();
    }
}


class MesInfoControleur {
    
    private $mesInfoModel;

    public function __construct() {
        $this->mesInfoModel = new MesInfoModel();
    }

    // Informations de location de DVD pour un utilisateur donné
    public function mes_empruts($IdUser) {
        $this->mesInfoModel->mes_empruts($IdUser);
    }

    // Charger les informations personnelles
    public function info_perso() {
        $this->mesInfoModel->info_perso();
    }
}


class AvisControleur {

    private $avisModel;

    public function __construct() {
        $this->avisModel = new AvisModel();
    }

    // Supprimer un commentaire
    public function supprimer_avis($IdUser) {
        $this->avisModel->supprimer_avis($IdUser);
    }

    // Afficher les commentaires précédents
    public function precedents_commentaires($IdUser) {
        $this->avisModel->precedents_commentaires($IdUser);
    }

    // Afficher tous les commentaires
    public function all_avis() {
        $this->avisModel->all_avis();
    }

    // Afficher les livres disponibles pour un commentaire
    public function dites_nous_vous_en_pensez($IdUser, $nomUser) {
        $this->avisModel->dites_nous_vous_en_pensez($IdUser, $nomUser);
    }

    // Laisser un commentaire
    public function laisser_mon_avis($IdUser, $nomUser) {
        $this->avisModel->laisser_mon_avis($IdUser, $nomUser);
    }

    // Afficher les détails d'un commentaire spécifique
    public function afficher_info_avis() {
        $this->avisModel->afficher_info_avis();
    }

}


class TypeControleur {
    
    private $typeModel;
    
    public function __construct() {
        $this->typeModel = new TypeModel();
    }
    
    // Trouver des films d'un certain type
    public function cherche_type_Film() {
        $this->typeModel->cherche_type_Film();
    }


    // Afficher tous les types de films
    public function afficher_all_type() {
        $this->typeModel->afficher_all_type();
    }

    // Afficher les films d'un certain type
    public function afficher_Film_de_type() {
        $this->typeModel->afficher_Film_de_type();
    }
}


class FunctionBaseControleur {
    
    private $functionBaseModel;
    
    public function __construct() {
        $this->functionBaseModel = new FunctionBaseModel();
    }
    
    // Vérifier si l'utilisateur est connecté
    public function verifier_statue_connexion() {
        $this->functionBaseModel->verifier_statue_connexion();
    }

    // Afficher les informations personnelles après la connexion
    public function validation_connexion() {
        $this->functionBaseModel->validation_connexion();
    }

    // Déconnexion
    public function deconnexion() {
        $this->functionBaseModel->deconnexion();
    }

    // 点击“Retour”之后，会从数据库中删除借阅的信息
    public function Film_emprunter_retour($IdFilm) {
        $this->functionBaseModel->Film_emprunter_retour($IdFilm);
    }

    public function Film_emprunter_emprunter($IdFilm) {
        $this->functionBaseModel->Film_emprunter_emprunter($IdFilm);
    }

    // Afficher un film au hasard
    public function Film_aleatoire() {
        $this->functionBaseModel->Film_aleatoire();
    }

    // Inscription
    public function inscription() {
        $this->functionBaseModel->inscription();
    }

    // Afficher la navigation de pagination - avis
    public function change_page_avis($page, $totalPages) {
        $this->functionBaseModel->change_page_avis($page, $totalPages);
    }

    // Afficher la navigation de pagination - type
    public function change_page_type($page, $totalPages) {
        $this->functionBaseModel->change_page_type($page, $totalPages);
    }

    // Afficher la navigation de pagination - directeur
    public function change_page_dire($page_directeur, $totalPages_directeur) {
        $this->functionBaseModel->change_page_dire($page_directeur, $totalPages_directeur);
    }
}

?>
