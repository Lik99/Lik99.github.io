<?php 
    require 'controleur.php'; 
	session_start() ;
    $IdUser = $_SESSION['IdUser'];
    include 'directeur.entete.html';
 ?>

<!--/header-->
</header></div>
	
<!-- content-wrap -->
<div Id="content-wrap">
    <!-- content -->
    <div Id="content" class="clearfix">
   	    <!-- main -->
        <div Id="main">

      	    <article class="post">

      		    <div class="primary">

                  <!-- Afficher le nom de l'directeur     -->
                  <?php
                    // Envoyer des données/opérations au contrôleur
                    $directeurControleur = new DirecteurControleur();
                    // Le contrôleur appelle les méthodes du modèle
                    $directeurControleur->cherche_nom_directeur();
                    ?>

                    <!-- Afficher les Films de cet directeur -->
                    
					 <?php			
					// Envoyer des données/opérations au contrôleur
                    $directeurControleur = new DirecteurControleur();
                    // Le contrôleur appelle les méthodes du modèle
                    $directeurControleur->cherche_Film_directeur();
					?>
					
                    <a href="directeur1.php">Retour à voir tous les directeurs</a>
                </div>

                

                <?php
				include('info.perso.html')
				?>
                
		    </article>  
                     
        <!-- /main -->
        </div>
        <!-- sidebar -->
		<div Id="sidebar">
			<div class="sidemenu">

				<h3>Mes emprunts</h3>
				<ul>
                    <?php
                    // Envoyer des données/opérations au contrôleur
                    $emprutsControleur = new MesInfoControleur();
                    // Le contrôleur appelle les méthodes du modèle
                    $emprutsControleur->mes_empruts($IdUser);
                    ?>
				</ul>
			</div>
        <!-- /sidebar -->
		</div>

        
    <!-- content -->
	</div>
<!-- /content-out -->
</div>

</body>
</html>
