<?php

class DirecteurModel {
    private $conn;

    // Connexion à la base de données
    private function connectDatabase() {
        $host = "localhost";
        $username = "root";
        $password = "";
        $this->conn = mysqli_connect($host, $username, $password);
        mysqli_select_db($this->conn, "L3S6_ProjetProgrammation_film");
        //return $conn;
    }

    // Fermeture de la connexion à la base de données
    private function closeDatabase() {
        mysqli_close($this->conn);
    }

    // Recherche d'un directeur
    function directeur_recherche() {
        if (isset($_SESSION['IdUser']) && isset($_SESSION['nomUser'])) {	
            $this->connectDatabase();

            // Obtention du terme de recherche
            if(isset($_GET['qsearch'])) {
                $searchTerm = $_GET['qsearch'];

                // Requête pour rechercher dans la table des directeurs
                $req = "SELECT IdDirecteur, nomDirecteur, prenomDirecteur FROM Directeur WHERE LOWER(nomDirecteur) = LOWER('$searchTerm');";
                $res = mysqli_query($this->conn, $req);
                
                // Affichage des informations des directeurs correspondants
                if ($row = mysqli_fetch_array($res)) {
                    echo '<div class="image-section">';
                    echo '<p><a href="directeur2.php?IdDirecteur=' . $row['IdDirecteur'] . '">' . $row['nomDirecteur'] . ' ' . $row['prenomDirecteur'] . '</a></p>';
                    echo '</div>';
                    
                } else {
                    echo "Nous n'avons pas trouvé l'directeur que vous recherchiez";
                }
            } 

            // Fermeture de la connexion à la base de données
           $this->closeDatabase();
            } else{
                echo "Veuillez vous connecter et refaire une recherche !";
            }
            echo '<p><a href="directeur1.php"> Retour à la page de l\'directeur </a></p>';
    }

    // Afficher tous les directeurs
   public  function all_directeur() {
        if (isset($_SESSION['IdUser']) && isset($_SESSION['nomUser'])) {
            $this->connectDatabase();

            $directeursPerPage = 6;// Nombre de directeurs affichés par page
            $reqTotalPage = "SELECT COUNT(*) AS totalDirecteur FROM Directeur;";// Requête pour obtenir le nombre total de directeurs
            $resTotalPage = mysqli_query($this->conn, $reqTotalPage);
            $rowTotalPage = mysqli_fetch_assoc($resTotalPage);
            $totalDirecteur = $rowTotalPage['totalDirecteur'];
            $totalPages_directeur = ceil($totalDirecteur / $directeursPerPage);// Calcul du nombre total de pages
            $page_directeur = isset($_GET['page']) ? intval($_GET['page']) : 1;// Obtention du numéro de page actuel, par défaut page 1
            $page_directeur = max(min($page_directeur, $totalPages_directeur), 1);// Assurer que le numéro de page est dans la plage valide
            $offset = ($page_directeur - 1) * $directeursPerPage;// Calcul de la valeur de décalage
    
            // Requête pour obtenir tous les directeurs avec pagination
            $req = "SELECT *
                    FROM Directeur LIMIT $directeursPerPage OFFSET $offset;";
            $res = mysqli_query($this->conn, $req);
    
            while ($row = mysqli_fetch_array($res)) {
                $nomDirecteur = $row['nomDirecteur'];
                $IdDirecteur = $row['IdDirecteur'];
                echo '<div class="image-section">';
                echo '<p><a href="directeur2.php?IdDirecteur='.$IdDirecteur.'">'.$nomDirecteur.'</a></p>';  
                echo '</div>';
            }
        }else{
            echo "Veuillez vous connecter pour voir les directeur.";
         }
    }

    // Méthode pour afficher cinq directeurs aléatoires
    function random_5_directeur() {
        if (isset($_SESSION['IdUser']) && isset($_SESSION['nomUser'])) {	
            $this->connectDatabase();

            // Requête pour obtenir cinq directeurs au hasard
            $req = "SELECT IdDirecteur, nomDirecteur, prenomDirecteur FROM Directeur ORDER BY RAND() LIMIT 5;";
            $res = mysqli_query($this->conn, $req);
            // Affichage des cinq directeurs aléatoires
            while ($row = mysqli_fetch_array($res)) {
                echo '<li><a href="directeur2.php?IdDirecteur=' . $row['IdDirecteur'] . '">' . $row['nomDirecteur'] . ' ' . $row['prenomDirecteur'] . '</a>';
                // Requête pour obtenir un film aléatoire associé à chaque directeur
                $req1 = "SELECT IdDirecteur, titreFilm FROM Film WHERE IdDirecteur =" . $row['IdDirecteur'] . " ORDER BY RAND() LIMIT 1;";
                $res1 = mysqli_query($this->conn, $req1);
        
                // Affichage du titre du film s'il y en a un associé à ce directeur
                if ($res1 && $row1 = mysqli_fetch_array($res1)) {
                    echo '<br/><span>' . $row1['titreFilm'] . '</span>';
                } else {
                    echo '<br/><span>Aucun Film pour l\'instant...</span>';
                }
        
                echo '</li>';
            }

            // Fermeture de la connexion à la base de données
           $this->closeDatabase();
            } else{
                echo "Veuillez vous connecter pour voir notre sélection.";
            }
    }
    
    // Méthode pour afficher cinq types aléatoires
    function random_5_type(){
        if (isset($_SESSION['IdUser']) && isset($_SESSION['nomUser'])) {	
			$this->connectDatabase();

			// Requête pour obtenir cinq types de films au hasard
			$req = "SELECT IdType, nomType FROM Type ORDER BY RAND() LIMIT 5;";
			$res = mysqli_query($this->conn, $req);
			// Affichage des cinq types aléatoires
			while ($row = mysqli_fetch_array($res)) {
			
				echo '<li><a href="type2.php?IdType=' . $row['IdType'] . '">' . $row['nomType'] . '</a>';
				
				// Requête pour obtenir deux films aléatoires associés à chaque type
				$req1 = "SELECT IdType, titreFilm FROM Film WHERE IdType =" . $row['IdType'] . " ORDER BY RAND() LIMIT 2;";
				$res1 = mysqli_query($this->conn, $req1);

				// Affichage des titres des films s'il y en a associés à ce type
				if($res1){
					while ($row1 = mysqli_fetch_array($res1)) {
						echo '<br/><span>' . $row1['titreFilm'] . '</span>';
					} 
				} else {
					echo '<br/><span>Aucun Film pour l\'instant...</span>';
				}
				echo '</li>';
			}

			// Fermeture de la connexion à la base de données
			$this->closeDatabase();

			} else{
				echo "Veuillez vous connecter pour voir notre sélection.";
			}
    }

    // Recherche d'informations sur un directeur spécifique
    function cherche_nom_directeur() {
        if (isset($_SESSION['IdUser']) && isset($_SESSION['nomUser'])) {
            $this->connectDatabase();

            // Obtention de l'ID du directeur depuis directeur1.php
            if(isset($_GET['IdDirecteur'])) {
                $IdDirecteur = $_GET['IdDirecteur'];

                // Requête pour obtenir les informations sur le directeur spécifié
                $req = "SELECT * FROM Directeur WHERE IdDirecteur = $IdDirecteur;";
                $res = mysqli_query($this->conn, $req);

                // Affichage des informations sur le directeur
                while ($row = mysqli_fetch_array($res)) {
                    echo '<div class="author-info">';
                    echo '<p><h2>'. $row['nomDirecteur'] . ' ' . $row['prenomDirecteur'] .'</h2></p>';
                    echo '<p><h5>'. $row['introDirecteur'] .'</h5></p>';
                    echo '</div>';
                }
            } 

            // Fermeture de la connexion à la base de données
           $this->closeDatabase();
        } else{
            echo "Veuillez vous connecter avant de visualiser les informations sur l'directeur";
        }
    }

    // Afficher les films d'un directeur spécifique
    function cherche_Film_directeur() {
        $this->connectDatabase();

        if(isset($_GET['IdDirecteur'])) {
            $IdDirecteur = $_GET['IdDirecteur'];
        
            // Tri par défaut par titre de film
            $orderBy = "titreFilm";
        
            // Vérifier si le bouton de tri par année a été déclenché
            if(isset($_GET['sort']) && $_GET['sort'] === 'annee') {
                if($_GET['sort'] === 'annee'){
                    $orderBy = "anneePubli";
                } else if($_GET['sort'] === 'titre'){
                    $orderBy = "titreFilm";
                }
                
            }
        
            // Requête pour obtenir les films associés à un directeur spécifique, triés selon l'ordre spécifié
            $req = "SELECT IdDirecteur,IdFilm, titreFilm, anneePubli FROM Film WHERE IdDirecteur = $IdDirecteur ORDER BY $orderBy;";
            $res = mysqli_query($this->conn, $req);
        
            // Début du tableau
            echo '<table>';
            echo '<tr><th>Titre Film<a href="directeur2.php?IdDirecteur=' . $IdDirecteur . '&sort=titre" style="color: gray;"></br>Classer par titre</a></th>
                        <th>Année de Publication <a href="directeur2.php?IdDirecteur=' . $IdDirecteur . '&sort=annee" style="color: gray;"></br>Classer par année</a></th></tr>';
        
            // Affichage des informations sur les films
            while ($row = mysqli_fetch_array($res)) {
                echo '<tr>';
                echo '<td>' . $row['titreFilm'] . '</td>';
                echo '<td>' . $row['anneePubli'] . '</td>';
                // Vérifier si l'utilisateur a déjà emprunté ce film
                $reqCheck = 'SELECT * FROM DejaVu WHERE IdUser = '.$_SESSION['IdUser'].' AND IdFilm = ' . $row['IdFilm'] . ';';
                $resCheck = mysqli_query($this->conn, $reqCheck);
                $isBorrowed = mysqli_num_rows($resCheck);

                if ($isBorrowed == 1 ) {
                    echo '<td><a href="retour.php?IdFilm=' . $row['IdFilm'] . '&titreFilm=' . $row['titreFilm'] . '&IdDirecteur=' . $row['IdDirecteur'] . '">Retour</a></td>';
                }else if($isBorrowed == 0) {
                    echo '<td><a href="dejaVu.php?IdFilm=' . $row['IdFilm'] . '&titreFilm=' . $row['titreFilm'] . '&IdDirecteur=' . $row['IdDirecteur'] . '">Emprunter</a></td>';
                }
                echo '</tr>';
            }
        
            // Fin du tableau
            echo '</table>';
        }

        // Fermeture de la connexion à la base de données
       $this->closeDatabase();
    }  
}

class MesInfoModel {

    private $conn;

    // Connexion à la base de données
    private function connectDatabase() {
        $host = "localhost";
        $username = "root";
        $password = "";
        $this->conn = mysqli_connect($host, $username, $password);
        mysqli_select_db($this->conn, "L3S6_ProjetProgrammation_film");
        //return $conn;
    }

    // Fermeture de la connexion à la base de données
    private function closeDatabase() {
        mysqli_close($this->conn);
    }

    // Informations sur les DVD empruntés par les utilisateurs
    function mes_empruts($IdUser) {
        if (isset($_SESSION['IdUser']) && isset($_SESSION['nomUser'])) {
            // Connexion à la base de données
            $this->connectDatabase();

            // Requête pour obtenir les films empruntés par l'utilisateur
            $req = "SELECT Film.titreFilm, Film.anneePubli, Film.IdFilm, Film.IdDirecteur
                    FROM Film
                    INNER JOIN DejaVu ON Film.IdFilm = DejaVu.IdFilm
                    WHERE DejaVu.IdUser = $IdUser ;";
            $res = mysqli_query($this->conn, $req);

            // Affichage des films empruntés par l'utilisateur
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    echo '<li>' . $row['titreFilm'] . ' (' . $row['anneePubli'] . ')';
                    echo '</br><a href="retour.php?IdFilm=' . $row['IdFilm'] . '&titreFilm=' . $row['titreFilm'] . '&IdDirecteur=' . $row['IdDirecteur'] . '">Retour</a></li>';
                }
            } else {
                echo "Vous n'avez pas emprunté de Films.";
            }

            // Fermeture de la connexion à la base de données
           $this->closeDatabase();
        } else {
            echo "Veuillez vous connecter pour voir vos emprunts.";
        }
    }

    // Informations personnelles
    function info_perso() {
        if (isset($_SESSION['IdUser']) && isset($_SESSION['nomUser'])) {
            echo '<li class="Utilisateur"><a href="#">' . $_SESSION['nomUser'] . '</a></li>';
            echo '<li class="permalink"><a href="#">' . $_SESSION['IdUser'] . '</a></li>';
        } else {
            echo " Vous n'êtes pas connecté";
        }
    }
}


class AvisModel {

    private $conn;

    // Connexion à la base de données
    private function connectDatabase() {
        $host = "localhost";
        $username = "root";
        $password = "";
        $this->conn = mysqli_connect($host, $username, $password);
        mysqli_select_db($this->conn, "L3S6_ProjetProgrammation_film");
        //return $conn;
    }

    // Fermeture de la connexion à la base de données
    private function closeDatabase() {
        mysqli_close($this->conn);
    }

    // Supprimer les avis
    function supprimer_avis($IdUser) {
        if (isset($_GET['IdFilm'])) {
            $IdFilm = $_GET['IdFilm'];
        
            
            $this->connectDatabase();
        
            // Supprimer le commentaire
            $req = "DELETE FROM Avis WHERE IdFilm = $IdFilm AND IdUser = $IdUser";
            $res = mysqli_query($this->conn, $req);
        
            if ($res) {
                echo "Votre avis a été supprimé avec succès";
            } else {
                echo "Erreur lors de la suppression de votre avis :" . mysqli_error($this->conn);
            }
        
            // Fermer la connexion à la BD
            $this->closeDatabase();
        }
    }
    
    // Afficher les commentaires précédents des utilisateurs connectés
    function precedents_commentaires($IdUser){
        if (isset($_SESSION['IdUser']) && isset($_SESSION['nomUser'])) {
            // Connexion à la base de données
            $this->connectDatabase();
    
            // Requête pour obtenir les avis laissés par l'utilisateur
            $req = "SELECT Avis.IdUser, Avis.noteAvis, Avis.IdFilm, Film.titreFilm
                    FROM Avis
                    INNER JOIN Film ON Avis.IdFilm = Film.IdFilm
                    WHERE Avis.IdUser = $IdUser ;";
            $res = mysqli_query($this->conn, $req);
    
            // Afficher les avis laissés par l'utilisateur
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    $_SESSION['$IdFilm'] = $row['IdFilm'];
                    echo '<li>'."ID Film: " .$row['IdFilm']."</br>". $row['titreFilm'] ."</br>". ' ( note: ' . $row['noteAvis'] . ')';
                    echo '</br><a href="avis4.php?IdFilm=' . $row['IdFilm'] . '&titreFilm=' . $row['titreFilm'] . '">Voir </a> | <a href="avis_supprimer.php?IdFilm=' . $row['IdFilm'] . '">Supprimer</a></li>';
                }
            } else {
                echo "Vous n'avez pas encore donné votre avis sur le Film.";
            }
    
            // Fermer la connexion à la BD
           $this->closeDatabase();
        } else {
            echo "Veuillez vous connecter pour voir vos emprunts.";
        }
    }
    
    
    // Afficher tous les avis
    function all_avis(){
        $conn = mysqli_connect("localhost", "root", "");
        mysqli_select_db($conn, "L3S6_ProjetProgrammation_film");
        
        $commentsPerPage = 6;// Nombre de commentaires affichés par page
        $reqTotalPage = "SELECT COUNT(*) AS totalComments FROM Avis;";// Requête pour obtenir le nombre total de commentaires dans la base de données
        $resTotalPage = mysqli_query($conn, $reqTotalPage);
        $rowTotalPage = mysqli_fetch_assoc($resTotalPage);
        $totalComments = $rowTotalPage['totalComments'];
        $totalPages = ceil($totalComments / $commentsPerPage);// Calcul du nombre total de pages
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;// Obtention du numéro de page actuel, par défaut à la première page
        $page = max(min($page, $totalPages), 1);// Assurer que le numéro de page est dans la plage valide
        $offset = ($page - 1) * $commentsPerPage;// Calcul du décalage
        
        // Requête pour obtenir les avis avec la pagination
        $req = "SELECT Film.titreFilm, Film.IdFilm, Film.IdDirecteur, 
                        Avis.noteAvis, Avis.commentaireAvis, 
                        Utilisateur.nomUser, Utilisateur.prenomUser, 
                        Directeur.nomDirecteur, Directeur.prenomDirecteur
                FROM Film, Utilisateur, Avis, Directeur
                WHERE Utilisateur.IdUser = Avis.IdUser AND Avis.IdFilm = Film.idFilm AND Film.IdDirecteur = Directeur.IdDirecteur
                LIMIT $commentsPerPage OFFSET $offset;";
        $res = mysqli_query($conn, $req);

        while ($row = mysqli_fetch_array($res)) {
            $IdFilm  = $row['IdFilm'];
            //$_SESSION['IdFilm'] = $IdFilm;
            echo '<li>
                    <div class="post-title"><a href="avis4.php?IdFilm='.$IdFilm.'">'.$row['commentaireAvis'].'</a></div>
                    <div class="post-details" methode = "GET">Titre de Film: <a href="#">'.$row['titreFilm'].'</a> <span>|</span> Directeur: <a href="directeur2.php?IdDirecteur='.$row['IdDirecteur'].'">'.$row['nomDirecteur']." ".$row['prenomDirecteur'].'</a></div>
                </li>';	
            //echo $_SESSION['IdFilm'];			
        }
}
    
    // Montrer des films pouvant être commentés
    function dites_nous_vous_en_pensez($IdUser,$nomUser) {
        if (isset($_SESSION['IdUser']) && isset($_SESSION['nomUser'])) {
            echo '<div><label for="name">Votre nom:</br>' .$nomUser. '<span></span></label></div>';
              echo'<div><label for="id">Votre ID:</br>'.$IdUser. '<span></span></label></div>';
            
            // Connexion à la base de données
            $this->connectDatabase();
            
            // Requête pour obtenir les films empruntés par l'utilisateur
            $req = "SELECT Film.titreFilm, Film.anneePubli, Film.IdFilm, Film.IdDirecteur
                    FROM Film
                    INNER JOIN DejaVu ON Film.IdFilm = DejaVu.IdFilm
                    WHERE DejaVu.IdUser = $IdUser ;";
            $res = mysqli_query($this->conn, $req);
            
            // Afficher les films empruntés par l'utilisateur et en sélectionner un
            if (mysqli_num_rows($res) > 0) {
    
                // Liste déroulante pour les films sur lesquels l'utilisateur n'a pas encore donné d'avis
                echo '<div>
                <label for="titreFilm">Sélectionner un Film </br>(Afficher uniquement ceux que vous n\'avez pas commentés.)</label>
                <select id="titreFilm" name="titreFilm" tabindex="2">';
                
                 // Requête pour obtenir les films déjà commentés par l'utilisateur
                $FilmDejaAvis = [];
                $Film_checkQuery = "SELECT IdFilm FROM Avis WHERE IdUser = $IdUser";
                $Film_checkResult = mysqli_query($this->conn, $Film_checkQuery);
    
                if(mysqli_num_rows($Film_checkResult) > 0) {
                    while ($row = mysqli_fetch_assoc($Film_checkResult)) {
                        $FilmDejaAvis[] = $row['IdFilm'];
                    }
                }
    
                // Interroger les titres de films dans l'ensemble de résultats et les afficher sous forme d'options déroulantes.
                while ($row = mysqli_fetch_array($res)) {
                    $titreFilm = $row['titreFilm'];
                    $IdFilm = $row['IdFilm'];
                    // Vérifier si le film a déjà été commenté, sinon l'ajouter à la liste déroulante
                    if (!in_array($row['IdFilm'], $FilmDejaAvis)) {
                        echo '<option value="' . $titreFilm . '">' . $IdFilm.": ".$titreFilm . '</option>';
                    }
                }
                echo '</select>
                    </div>';
            } else {
                echo "<div><label>Vous n'avez pas emprunté de Films.</label></div>";
            }
           $this->closeDatabase();
            // Note sur 10
            echo '<div>
              <label for="Note">Note sur 10</label>
              <input id="Note" name="noteAvis" type="text" tabindex="3" />
            </div>';
            // Commentaire
            echo '<div>
                <label for="message">Votre commentaire <span></span></label>
                <textarea id="message" name="commentaireAvis" rows="10" cols="18" tabindex="4"></textarea>
            </div>';
            // Image du commentaire
            echo '<input type="hidden" name="MAX_FILE_SIZE" value=100000>';
            echo '<div>
                <label for="commentImage">Image de commentaire</label>
                <input type="file" id="commentImage" name="imageAvis" accept="image/*" tabindex="6">
            </div>';
            echo '<div class="no-border">
                <input class="button" type="submit" value="Envoyer" tabindex="5" />
            </div>';
        } else{
            echo" Vous n'êtes pas connecté ";
        }
    }
    
    // Laisser un commentaire
    function laisser_mon_avis($IdUser,$nomUser) {
        // 1. Vérifier si la soumission a été reçue
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // 2. Vérifier le titre du film, la note et le commentaire
            if (isset($_POST['titreFilm'])&& isset($_POST['noteAvis']) && isset($_POST['commentaireAvis'])) {
                // 3. Vérifier si la note est comprise entre 0 et 10
                if(($_POST['noteAvis'] <= 10) && ($_POST['noteAvis'] >= 0) ){
                    // 4. Vérifier les téléchargements d'images
                    if (isset($_FILES['imageAvis']) && $_FILES['imageAvis']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = 'imageAvis/'; // Répertoire de destination pour l'image
                        $tmpFilePath = $_FILES['imageAvis']['tmp_name'];
                        $fileName = $_FILES['imageAvis']['name'];
                        $filePath = $uploadDir . uniqid() . '_' . $fileName;
                
                        // Déplacer les fichiers temporaires vers le chemin de destination
                        if (move_uploaded_file($tmpFilePath, $filePath)) {
                            // Téléchargement réussi, afficher un message de succès
                            echo "L'image a été téléchargée avec succès.</br></br>";
                            // Obtenir les données envoyées via la méthode POST
                            $titreFilm = $_POST['titreFilm'];
                            $noteAvis = $_POST['noteAvis'];
                            $commentaireAvis = $_POST['commentaireAvis'];
                            
                            $this->connectDatabase();
                            
                            // Requête pour obtenir les films empruntés par l'utilisateur
                            $req = "SELECT * FROM Film WHERE titreFilm LIKE '%" . $titreFilm . "%';";
                            // Exécution de la requête
                            $res = mysqli_query($this->conn, $req);
                            $row = mysqli_fetch_array($res);
                            $IdFilm = $row['IdFilm'];
                    
                            echo "Votre ID: ".$IdUser. "<br>";
                            echo "Votre nom: ".$nomUser. "<br>";
                            echo "ID du Film: " . $IdFilm . "<br>";
                            echo "Titre du Film: " . $titreFilm . "<br>";
                            echo "Note: " . $noteAvis . "<br>";
                            echo "Message: " . $commentaireAvis . "<br>";
                            // Insérer les données du commentaire dans la table Avis
                            // echo 'filePath: '.$filePath;
                            $insertQuery = "INSERT INTO Avis (imageAvis, commentaireAvis, noteAvis, IdUser, IdFilm) 
                            VALUES ('$filePath', '$commentaireAvis', '$noteAvis', '$IdUser', '$IdFilm');";

                            // Exécution de l'insertion
                            if (mysqli_query($this->conn, $insertQuery)) {
                                echo "</br></br><p>Votre avis a été enregistré avec succès.";
                            } else {
                                echo "</br></br><p>Erreur lors de l'enregistrement de votre avis. ". mysqli_error($this->conn);
                            }

                            // Fermer la connexion à la BD
                            $this->closeDatabase();
    
                        } else {
                            // Échec du téléchargement, afficher un message d'erreur
                            echo "Erreur lors du téléchargement de l'image,
                            Assurez-vous que le dossier que vous choisissez pour enregistrer vos images 
                            a des droits d'accès suffisants pour permettre aux scripts PHP d'y écrire.</p></br>";
                            echo "move " . (move_uploaded_file($tmpFilePath, $filePath) ? 'success' : 'failed');
                        }
                    } else {
                        echo 'Vous devez déposer une photo du commentaire';
                    }
                } else {
                    echo "La note doit être comprise entre 0 et 10";
                }
            } else {
                echo "Certaines données sont manquantes.";
            }
        } else {
            echo "Aucune donnée n'a été soumise.";
        }
    }
    
    // Afficher un commentaire spécifique
    function afficher_info_avis(){
        if (isset($_GET['IdFilm'])) {
            $IdFilm = $_GET['IdFilm'];
            
            $this->connectDatabase();
    
            // Requête pour obtenir les avis sur un film spécifique
            $req = "SELECT Avis.*, Utilisateur.nomUser, Utilisateur.prenomUser
                    FROM Avis, Utilisateur
                    WHERE Avis.IdFilm = $IdFilm AND Avis.IdUser = Utilisateur.IdUser ;";
            $res = mysqli_query($this->conn, $req);
            $row = mysqli_fetch_array($res);
    
            echo '</br>ID du Film: ' . $IdFilm .'';
    
            $reqFilm = "SELECT * FROM Film WHERE IdFilm = $IdFilm;";
            $resFilm = mysqli_query($this->conn, $reqFilm);
    
            if ($rowFilm = mysqli_fetch_array($resFilm)) {
                echo '</br>Titre du Film: ' . $rowFilm['titreFilm'] . '';
                echo '</br>La note: ' . $row['noteAvis'] .'';
                echo '</br>Qui a laissé le commentaire: ' . $row['prenomUser']." ".$row['nomUser'] .'';
                //echo $row['imageAvis'];
                echo '</br>Images commentées: <img src="' . $row['imageAvis'] . '" alt="Avis Image" width="300" height="300">';
                echo '</br>Commentaires: ' . $row['commentaireAvis'] .'';
            }
            
        } else {
            echo "Erreur dans la méthode GET";
        }
    }
    
    
}


class typeModel{

    private $conn;

    // Se connecter à la base de données
    private function connectDatabase() {
        $host = "localhost";
        $username = "root";
        $password = "";
        $this->conn = mysqli_connect($host, $username, $password);
        mysqli_select_db($this->conn, "L3S6_ProjetProgrammation_film");
        //return $conn;
    }

    // Fermer la connexion à la base de données
    private function closeDatabase() {
        mysqli_close($this->conn);
    }

    // Rechercher un type de film spécifique dans la case de recherche
    function cherche_type_Film(){
        if (isset($_SESSION['IdUser']) && isset($_SESSION['nomUser'])) {	
            // Se connecter à la base de données
            $this->connectDatabase();
            // Obtenir les paramètres de recherche
            if(isset($_GET['qsearch'])) {
                $searchTerm = $_GET['qsearch'];

                // Requête pour rechercher le type de film spécifique
                $req = "SELECT IdType, nomType FROM Type WHERE LOWER(nomType) = LOWER('$searchTerm');";
                $res = mysqli_query($this->conn, $req);

                // Afficher les informations de type de film correspondantes
                if ($row = mysqli_fetch_array($res)) {
                    echo '<div class="image-section">';
                    echo '<p><a href="type2.php?IdType=' . $row['IdType'] . '">' . $row['nomType'] . ' </a></p>';
                    echo '</div>';                       
                }else {
                    echo "Nous n'avons pas trouvé le type que vous recherchiez";
                }
            } 

            // Fermer la connexion à la base de données
           $this->closeDatabase();
            } else{
                echo "Veuillez vous connecter et refaire une recherche !";
            }
            echo '<p><a href="type1.php"> Retour à la page du type </a></p>';
    }

    // Afficher tous les types de films
    function afficher_all_type(){
        if (isset($_SESSION['IdUser']) && isset($_SESSION['nomUser'])) {
            
            $this->connectDatabase();
            
            $typesPerPage = 6;// Nombre de types de films à afficher par page
            $reqTotalPage = "SELECT COUNT(*) AS totalType FROM Type;";// Requête pour obtenir le nombre total de types de films
            $resTotalPage = mysqli_query($this->conn, $reqTotalPage);
            $rowTotalPage = mysqli_fetch_assoc($resTotalPage);
            $totalType = $rowTotalPage['totalType'];
            $totalPages = ceil($totalType / $typesPerPage);// Calculer le nombre total de pages
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;// Obtenir le numéro de page actuel, par défaut à la première page
            $page = max(min($page, $totalPages), 1);// Assurer que le numéro de page est dans la plage valide
            $offset = ($page - 1) * $typesPerPage;// Calculer la valeur de décalage

            // Requête pour obtenir tous les types de films avec pagination
            $req = "SELECT *
                    FROM Type LIMIT $typesPerPage OFFSET $offset;";
            $res = mysqli_query($this->conn, $req);

            while ($row = mysqli_fetch_array($res)) {
                $nomType = $row['nomType'];
                $IdType = $row['IdType'];
                //$_SESSION['IdType'] = $IdType;
                echo '<div class="image-section">';
                echo '<p><a href="type2.php?IdType='.$IdType.'">'.$nomType.'</a></p>';	
                echo '</div>';
                //echo $_SESSION['IdType'];			
            }
        }else{
            echo "Veuillez vous connecter pour voir les types.";
        }
    }

    // Afficher les films d'un type spécifique
    function afficher_Film_de_type(){
        // Se connecter à la base de données
        $this->connectDatabase();

        //echo $_GET['IdType'];
        if(isset($_GET['IdType'])) {
            $IdType = $_GET['IdType'];
        
            // Tri par défaut par titre
            $orderBy = "titreFilm";
        
            // Vérifier si le bouton de tri par année a été déclenché
            if(isset($_GET['sort']) && $_GET['sort'] === 'annee') {
                if($_GET['sort'] === 'annee'){
                    $orderBy = "anneePubli";
                } else if($_GET['sort'] === 'titre'){
                    $orderBy = "titreFilm";
                }
                
            }
            // Requête pour obtenir les informations du type spécifique
            $req1 = "SELECT * FROM Type WHERE IdType = $IdType;";
            $res1 = mysqli_query($this->conn, $req1);

            // Afficher les informations du type
            while ($row = mysqli_fetch_array($res1)) {
                echo '<div class="author-info">';
                echo '<p><h2>'. $row['nomType'] . '</h2></p>';
                echo '</div>';
            }

        
            // Requête pour obtenir les films associés à ce type et les trier selon l'ordre spécifié
            $req = "SELECT IdDirecteur, IdType, IdFilm, titreFilm, anneePubli FROM Film WHERE IdType = $IdType ORDER BY $orderBy;";
            $res = mysqli_query($this->conn, $req);
        
            // Commencer la table
            echo '<table>';
            echo '<tr><th>Titre Film<a href="type2.php?IdType=' . $IdType . '&sort=titre" style="color: gray;"></br>Classer par titre</a></th>
                    <th>Année de Publication <a href="type2.php?IdType=' . $IdType . '&sort=annee" style="color: gray;"></br>Classer par année</a></th></tr>';
        
            // Afficher les informations des films
            while ($row = mysqli_fetch_array($res)) {
                echo '<tr>';
                echo '<td>' . $row['titreFilm'] . '</td>';
                echo '<td>' . $row['anneePubli'] . '</td>';
                // Vérifier si l'utilisateur actuel a déjà emprunté ce film
                $reqCheck = 'SELECT * FROM DejaVu WHERE IdUser = '.$_SESSION['IdUser'].' AND IdFilm = ' . $row['IdFilm'] . ' ';
                $resCheck = mysqli_query($this->conn, $reqCheck);
                $isBorrowed = mysqli_num_rows($resCheck);

                if ($isBorrowed == 1 ) {
                    echo '<td><a href="retour.php?IdFilm=' . $row['IdFilm'] . '&titreFilm=' . $row['titreFilm'] . '&IdDirecteur=' . $row['IdDirecteur'] . '">Retour</a></td>';
                }else if($isBorrowed == 0) {
                    echo '<td><a href="dejaVu.php?IdFilm=' . $row['IdFilm'] . '&titreFilm=' . $row['titreFilm'] . '&IdDirecteur=' . $row['IdDirecteur'] . '">Emprunter</a></td>';
                }
                echo '</tr>';
            }
        
            // Fin de la table
            echo '</table>';
        }

        // Fermer la connexion à la base de données
        $this->closeDatabase();

    }


}


class FunctionBaseModel {

    private $conn;

    // Se connecter à la base de données
    private function connectDatabase() {
        $host = "localhost";
        $username = "root";
        $password = "";
        $this->conn = mysqli_connect($host, $username, $password);
        mysqli_select_db($this->conn, "L3S6_ProjetProgrammation_film");
        //return $conn;
    }

    // Fermer la connexion à la base de données
    private function closeDatabase() {
        mysqli_close($this->conn);
    }

    // Vérifier le statut de connexion
    public static function verifier_statue_connexion() {
        if (isset($_SESSION['IdUser']) && $_SESSION['IdUser'] != "") {
            die('Vous êtes déjà connecté !! <a href="index.php">Retour à l\'accueil</a>');
        }
    }

    // Afficher les informations personnelles après la connexion
    public function validation_connexion() {
        
        if (!empty($_POST["IdUser"]) && !empty($_POST["passUser"])) {
            $IdUser = $_POST["IdUser"];
            $passUser = $_POST["passUser"];

            $this->connectDatabase();

            // Création de la requête
            $req = 'SELECT IdUser, passUser, nomUser FROM Utilisateur WHERE IdUser="' . $IdUser . '" AND passUser ="' . $passUser . '";';
            
            // Envoi de la requête et récupération du résultat dans $res
            $res = mysqli_query($this->conn, $req);

            // Comptage du nombre de résultats et test
            if (mysqli_num_rows($res) == 1) {
                // Tout va bien, l'utilisateur existe et le bon mot de passe correspondant a été fourni
                echo 'Vous êtes bien connecté.e';
                $_SESSION['IdUser'] = $IdUser;
                $enreg_User = mysqli_fetch_array($res); // Récupération des informations
                $_SESSION['nomUser'] = $enreg_User['nomUser'];
                $_SESSION['passUser'] = $enreg_User['passUser']; // Ajout de l'identifiant à la session

                echo "<br/>";
                echo "<br/>";
                echo 'Votre nom:  ' . $_SESSION['nomUser'];
                echo "<br/>";
                echo 'Votre id:  ' . $_SESSION['IdUser'] . "<br/>";
                echo "<br/>";
            } else {
                // Y'a une erreur
                echo '<br/><br/>Id Usertiant ou mot de passe incorrect!!!';
            }

            // Fermeture de la connexion
            mysqli_close($this->conn);
        } else {
            die("Vous devez indiquer un nom d'utilisateur et un mot de passe !");
        }
    }

    // Déconnexion
    public function deconnexion() {
        $_SESSION = array();
        session_destroy();
    }

    // Après avoir cliqué sur « Retour », les informations correspondantes sur le prêt sont supprimées dans BD
    public function Film_emprunter_retour($IdFilm) { 
        $IdUser = $_SESSION['IdUser'];
        // echo 'id user: '.$IdUser;
        
        $this->connectDatabase();

        $req = "SELECT * 
                FROM Film 
                INNER JOIN Directeur ON Film.IdDirecteur = Directeur.IdDirecteur
                WHERE Film.IdFilm = $IdFilm;";
        $res = mysqli_query($this->conn, $req);

        if ($row = mysqli_fetch_array($res)) {
            echo '<p>Id Film: '.$IdFilm. '</p>';
            echo '<p>Film: '.$row['titreFilm']. '</p>';
            echo '<p>Date de publication: ' . $row['anneePubli'] . '</p>';
            echo '<p>Directeur du Film: ' . $row['prenomDirecteur'] .' '.$row['nomDirecteur']. '</p>';
        }

        $reqRetour = "DELETE FROM DejaVu WHERE IdUser = $IdUser AND IdFilm = $IdFilm ;";
        $reqRetour = mysqli_query($this->conn, $reqRetour);

       
        // echo 'id film: '.$IdFilm;


        
        // echo '$reqRetour is ok';
        // echo 'Number of rows deleted: ' . mysqli_affected_rows($this->conn);


        // if ($reqRetour = mysqli_fetch_array($reqRetour)) {
        //      echo '<h3><p>Vous avez retourné le livre avec succès !</br></br></p></h3>';
            
        //  }   

       $this->closeDatabase();
    }

    function Film_emprunter_emprunter($IdFilm) {
        $IdUser = $_SESSION['IdUser'];
        $IdFilm = $_GET['IdFilm'];

        // echo 'id user: '.$IdUser;
        // echo 'id film: '.$IdFilm;
        
        $this->connectDatabase();

        $dateEmprunt = date('Y-m-d'); // 当前日期, 计算归还日期（借阅当日往后推15天）
        $dateRetour = date('Y-m-d', strtotime($dateEmprunt . ' + 15 days')); // 借阅当日往后推15天

        $reqRetour = "INSERT INTO DejaVu(IdUser, IdFilm, dateEmprunt, dateRetour)
                      VALUES ('$IdUser', '$IdFilm', '$dateEmprunt', '$dateRetour')";
        $reqRetour = mysqli_query($this->conn, $reqRetour);

       // echo "reqRetour is ok" ;
    }

    // Afficher un film au hasard dans la page Index
    public function Film_aleatoire() {
        // Connecter à la BD
        $this->connectDatabase();

        // Sélectionner aléatoirement un film dans la base de données
        $req = "SELECT titreFilm FROM Film ORDER BY RAND() LIMIT 1;";
        //$req = "SELECT titreFilm FROM Film WHERE titreFilm = 'Le Dernier Jour d_un condamné';";
        $res = mysqli_query($this->conn, $req);
        // Gérer les erreurs
        if (!$res) {
            die('Erreur MySQL : ' . mysqli_error($this->conn));
        }
        $row = mysqli_fetch_array($res);
    
        $_SESSION['titreFilm'] = $row['titreFilm'];
    
        // Construire le chemin d'accès à l'image du film
        if ($_SESSION['titreFilm']) {
            $bookTitle = $_SESSION['titreFilm'];
            $filePath = "images_Films/" . $bookTitle . ".jpg"; // Construire le chemin d'accès

            // Vérifier si le fichier .jpg existe
            if (file_exists($filePath)) {
                echo '<div class="image-section">';
                echo '<img src="' . $filePath . '" alt="Avis Image" width="300" height="400"/>';
                echo '</div>';
            } else {
                // Si le fichier .jpg n'existe pas, essayer de charger le fichier .jpeg
                $filePath = "images_Films/" . $bookTitle . ".jpeg"; // Construire le chemin d'accès au fichier .jpeg

                if (file_exists($filePath)) {
                    echo '<div class="image-section">';
                    echo '<img src="' . $filePath . '" alt="Avis Image" width="300" height="400"/>';
                    echo '</div>';
                } else {
                    echo "Aucune image trouvée pour ce film, vous pouvez rafraîchir la page pour découvrir un autre film: </br>";
                }
            }
        } else {
            echo "Aucun titre de film n'a été trouvé dans la session.";
        }
        echo $_SESSION['titreFilm'];
    
        // Fermer la connexion à la BD
        $this->closeDatabase();
    }
    
    // Inscription
    public function inscription() {
        // Vérification que tous les champs sont remplis
        if (empty($_POST["IdUser"]) && empty($_POST["pass1"]) && empty($_POST["pass2"]) && empty($_POST["nomUser"]) && empty($_POST["prenomUser"])) {
            //echo "1";
            die("Vous devez remplir TOUS les champs !");
        } else {
            // Tous les champs sont remplis, je récupère les données
            $IdUser = $_POST["IdUser"];
            $pass1 = $_POST["pass1"];
            $pass2 = $_POST["pass2"];
            $nomUser = $_POST["nomUser"];
            $prenomUser = $_POST["prenomUser"];

            // Test de la cohérence des mots de passe
            if ($pass1 != $pass2) {
                die("Les deux mots de passe doivent être identiques !");
            } else {
                // Tout va bien

                // Vérification du transfert
                if ($_FILES['nom_du_fichier']['error']) {
                    die("Erreur lors du transfert de l'image !");
                }

                // Transfert de l'image dans le répertoire avatars
                if (isset($_FILES['nom_du_fichier']['name']) && ($_FILES['nom_du_fichier']['error'] == UPLOAD_ERR_OK)) {
                    $chemin_destination = 'avatars/';
                    move_uploaded_file($_FILES['nom_du_fichier']['tmp_name'], $chemin_destination . $_FILES['nom_du_fichier']['name']);
                }

                $this->connectDatabase();

                // Création de la requête
                // ATTENTION ! les chaînes de caractères (le pseudo, le mot de passe et le mail) doivent être entourées de  " " 
                // car c'est du texte, sinon l'ajout ne se fera pas du côté de la base de données (Possibilité de jouer sur les ' et ")
                $req = 'INSERT INTO Utilisateur (IdUser, nomUser, prenomUser, passUser, Avatar) VALUES ("' . $IdUser . '", "' . $nomUser . '", "' . $prenomUser . '","' . $pass1 . '", "' . $_FILES['nom_du_fichier']['name'] . '");';
                //echo $req; //à décommenter pour avoir l'affichage de la requête pour vérifier la syntaxe SQL dans PHPMyAdmin
                //Envoi de la requête 
                mysqli_query($this->conn, $req);
                // ici pas de stockage dans $res car il s'agit d'une requête insertion qui n'a pas de résultats a proprement parler      
                //Fermeture de la connexion
                mysqli_close($this->conn);
                //Affichage d'un message de confirmation et d'un lien de retour à l'accueil
                echo 'Vous avez bien été enregistré.e avec le ID ' . $IdUser . ' avec le nom ' . $nomUser . '.';
            }
        }
    }

    // Changer de page dans la page - avis
    function change_page_avis($page_avis, $totalPages_avis){
        $this->connectDatabase();
        
        $commentsPerPage = 6;// Nombre de commentaires par page
        $reqTotalPage = "SELECT COUNT(*) AS totalComments FROM Avis;";// Obtenir le nombre total de commentaires dans la base de données
        $resTotalPage = mysqli_query($this->conn, $reqTotalPage);
        $rowTotalPage = mysqli_fetch_assoc($resTotalPage);
        $totalComments = $rowTotalPage['totalComments'];
        $totalPages_avis = ceil($totalComments / $commentsPerPage);// Calculer le nombre total de pages
        $page_avis = isset($_GET['page']) ? intval($_GET['page']) : 1;// Obtenir le numéro de page actuel, par défaut la première page
        $page_avis = max(min($page_avis, $totalPages_avis), 1);// S'assurer que le numéro de page est dans la plage valide
        $offset = ($page_avis - 1) * $commentsPerPage;// Calculer la valeur OFFSET

        echo '<div class="navigation clear">';
        if ($page_avis < $totalPages_avis) { // Afficher le lien "Page suivante"
            echo 'Page '.$page_avis.' / '.$totalPages_avis.'<p><a href="avis1.php?page=' . ($page_avis + 1) . '">Page suivante &raquo;</a></p>';
        }
        if ($page_avis > 1) { // Afficher le lien "Page précédente"
            echo 'Page '.$page_avis.' / '.$totalPages_avis.'<p><div><a href="avis1.php?page=' . ($page_avis - 1) . '">&laquo; Page précédente</a></p>';
        }
        echo "</div>";
    }

    // Changer de page dans la page - type
    function change_page_type($page_type, $totalPages_type){
        
        $this->connectDatabase();
        
        $typesPerPage = 6;// Nombre de types par page
        $reqTotalPage = "SELECT COUNT(nomType) AS totalType FROM Type;";// Obtenir le nombre total de types dans la base de données
        $resTotalPage = mysqli_query($this->conn, $reqTotalPage);
        $rowTotalPage = mysqli_fetch_assoc($resTotalPage);
        $totalType = $rowTotalPage['totalType'];
        $totalPages_type = ceil($totalType / $typesPerPage);// Calculer le nombre total de pages
        $page_type = isset($_GET['page']) ? intval($_GET['page']) : 1;// Obtenir le numéro de page actuel, par défaut la première page
        $page_type = max(min($page_type, $totalPages_type), 1);// S'assurer que le numéro de page est dans la plage valide
        $offset = ($page_type - 1) * $typesPerPage;// Calculer la valeur OFFSET

        echo '<div class="navigation clear">';
        if ($page_type < $totalPages_type) { // Afficher le lien "Page suivante"
            echo 'Page '.$page_type.' / '.$totalPages_type.'<p><a class="more" href="type1.php?page=' . ($page_type + 1) . '">Page suivante &raquo;</a></p>';
        }
        if ($page_type > 1) { // Afficher le lien "Page précédente"
            echo 'Page '.$page_type.' / '.$totalPages_type.'<p><a class="more" href="type1.php?page=' . ($page_type - 1) . '">&laquo; Page précédente</a></p>';
        }
        echo "</div>";
    }

    // Changer de page dans la page - directeur
    function change_page_dire($page_directeur, $totalPages_directeur){
        $this->connectDatabase();
        
        $directeursPerPage = 6;// Nombre de directeurs par page
        $reqTotalPage = "SELECT COUNT(*) AS totalDirecteur FROM Directeur;";// Obtenir le nombre total de directeurs dans la base de données
        $resTotalPage = mysqli_query($this->conn, $reqTotalPage);
        $rowTotalPage = mysqli_fetch_assoc($resTotalPage);
        $totalDirecteur = $rowTotalPage['totalDirecteur'];
        $totalPages_directeur = ceil($totalDirecteur / $directeursPerPage);// Calculer le nombre total de pages
        $page_directeur = isset($_GET['page']) ? intval($_GET['page']) : 1;// Obtenir le numéro de page actuel, par défaut la première page
        $page_directeur = max(min($page_directeur, $totalPages_directeur), 1);// S'assurer que le numéro de page est dans la plage valide
        $offset = ($page_directeur - 1) * $directeursPerPage;// Calculer la valeur OFFSET

        echo '<div class="navigation clear">';
        if ($page_directeur < $totalPages_directeur) { // Afficher le lien "Page suivante"
            echo 'Page '.$page_directeur.' / '.$totalPages_directeur.'<p><a class="more" href="directeur1.php?page=' . ($page_directeur + 1) . '">Page suivante &raquo;</a></p>';
        }
        if ($page_directeur > 1) { // Afficher le lien "Page précédente"
            echo 'Page '.$page_directeur.' / '.$totalPages_directeur.'<p><a class="more" href="directeur1.php?page=' . ($page_directeur - 1) . '">&laquo; Page précédente</a></p>';
        }
        echo "</div>";
    }

}



?>
