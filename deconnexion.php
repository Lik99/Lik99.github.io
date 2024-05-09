<?php 
	require 'controleur.php';
    include 'connexion.entete.html'
	// session_start() ;
    // $_SESSION['IdUser'];
    // $_SESSION['nomUser'];
?>

                    <h2>Page de déconnexion</h2>
                    <p class="post-info"><span>Nous attendons la prochaine rencontre avec vous !</span></p>

                    <?php
                    // Envoyer des données/opérations au contrôleur
                    $deconnexionControleur = new FunctionBaseControleur();
                    // Le contrôleur appelle les méthodes du modèle
                    $deconnexionControleur->deconnexion();
                    ?>

               	    <div>
                       Vous avez bien été déconnecté.e.
                        <br/>
                        <br/>
                       <a href="index.php">Retour à la page d'accueil</a>
         	        </div>
   
                </div>

                <aside>
            	    
                </aside>
		    </article>           
        <!-- /main -->
        </div>
    <!-- content -->
	</div>
<!-- /content-out -->
</div>

</body>
</html>
