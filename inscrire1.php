<?php 
	require 'controleur.php';
	session_start() ;
    include 'inscrire.entete.html';
?>

                    <h2>Formulaire d'inscription</h2>
                    <p class="post-info"><span>Créer votre compte et profitez bien de votre lecture</span></p>

                    <?php
                        if (isset($_SESSION['IdUser']) AND $_SESSION['IdUser'] != "") {
                            die('Vous êtes déjà connecté !! <a href="index.php">Retour à l\'accueil</a>');
                        }
                    ?>

               	    <div>
                       <form action="inscrire2.php" method="POST" ENCTYPE="multipart/form-data">
                        
                        Id Userdiant : <input type="text" size="15" name="IdUser"><br/><br/>
                        Nom : <input type="text" size="15" name="nomUser"><br/><br/>
                        Prenom : <input type="text" size="15" name="prenomUser"><br/><br/>
                        Mot de passe : <input type="password" size="10" name="pass1"><br/><br/>
                        Confirmation : <input type="password" size="10" name="pass2"><br/><br/>
                        <input type="hidden" name="MAX_FILE_SIZE" value=100000>
                        Avatar : <input type="file" name="nom_du_fichier"><br/><br/>
                        <input type="submit" value="S'inscrire">  <input type="reset" value="Effacer">

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
