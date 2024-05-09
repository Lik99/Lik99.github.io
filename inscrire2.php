<?php 
	require 'controleur.php';
	session_start() ;
    $_SESSION['IdUser'];
	$_SESSION['nomUser'];
    include 'inscrire.entete.html';
?>

                    <h2>Validation de l'inscription</h2>
                    <p class="post-info"><span>C'est presque fini, attendez un peu...</span></p>

                    <?php
                        if (isset($_SESSION['IdUser']) AND $_SESSION['IdUser'] != "") {
                            die('Vous êtes déjà connecté !! <a href="index.php">Retour à l\'accueil</a>');
                            
                        }
                    ?>

               	    <div>
                       <?php
                        // Envoyer des données/opérations au contrôleur
                        $inscriptionControleur = new FunctionBaseControleur();
                        // Le contrôleur appelle les méthodes du modèle
                        $inscriptionControleur->inscription();
                        ?>
                        <a href="index.php">Retour à la page d'accueil</a>
         	        </div>
                </div>
		    </article>           
        <!-- /main -->
        </div>
    <!-- content -->
	</div>
<!-- /content-out -->
</div>
</body>
</html>
