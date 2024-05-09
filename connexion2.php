<?php 
	require 'controleur.php';
	session_start() ;
    $_SESSION['IdUser'];
    $_SESSION['nomUser'];
?>

<?php
include 'connexion.entete.html'
?>

                    <h2>Validation de la connexion</h2>
                    <p class="post-info"><span>C'est presque fini, attendez un peu...</span></p>

               	    <div>
                       <?php
                       
                        // Envoyer des données/opérations au contrôleur
                        $avisModel = new FunctionBaseModel();
                        // Le contrôleur appelle les méthodes du modèle
                        $avisModel->validation_connexion();

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
