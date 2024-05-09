<?php 
    require 'controleur.php';
	session_start() ;
    $IdUser = $_SESSION['IdUser'];
    include 'type.entete.html';

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

                    <!-- Afficher les Films de cet type -->
                    
					 <?php		

					// Envoyer des données/opérations au contrôleur
                    $FilmControleur = new typeControleur();
                    // Le contrôleur appelle les méthodes du modèle
                    $FilmControleur->afficher_Film_de_type();

					?>
					
                    <a href="type1.php">Retour à voir tous les types</a>
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

				<h3>Mes films</h3>
				<ul>
                    <?php
                    // Envoyer des données/opérations au contrôleur
                    $FilmControleur = new MesInfoModel();
                    // Le contrôleur appelle les méthodes du modèle
                    $FilmControleur->mes_empruts($IdUser);
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
