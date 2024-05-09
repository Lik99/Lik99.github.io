<?php 
	require 'controleur.php';
	session_start() ;
    $_SESSION['IdUser'];
    $_SESSION['nomUser'];
?>

<?php
include 'connexion.entete.html'
?>

                    <h2>Formulaire de connexion</h2>
                    <p class="post-info"><span>Dites-moi qui vous êtes!</span></p>

                    <?php
                        if (isset($_SESSION['IdUser']) AND $_SESSION['IdUser'] != "") {
                            die('Vous êtes déjà connecté !! <a href="index.php">Retour à l\'accueil</a>');
                        }
                    ?>

               	    <div>
                       <form action="connexion2.php" method="POST">
                        Id User : <input type="text" name="IdUser"><br/><br/>
                        Mot de passe : <input type="password" name="passUser"><br/><br/>
                        <input type="submit" value="connecter">  <input type="reset" value="Effacer">
                        </form>

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
