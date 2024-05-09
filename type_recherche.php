<?php 
    require 'controleur.php';
	session_start() ;
  include 'type.entete.html';
?>

<!--/header-->
</header></div>
	
<!-- content-wrap -->
<div id="content-wrap">
    <!-- content -->
    <div id="content" class="clearfix">
   	    <!-- main -->
        <div id="main">

      	    <article class="post">

              <div class="primary">

                <h2><a href="directeur1.php">Quel type recherchez-vous?</a></h2>

                <p class="post-info"><span>Des Films pour tous les goûts</span></p>

                <?php
                // Envoyer des données/opérations au contrôleur
                $typControleur = new typeControleur();
                // Le contrôleur appelle les méthodes du modèle
                $typControleur->cherche_type_Film();
                ?>
                
                <!-- /primary -->
              </div>

            <?php
            include('info.perso.html')
            ?>
                
		    </article>           
        <!-- /main -->
        </div>

        
    <!-- content -->
	</div>
<!-- /content-out -->
</div>

</body>
</html>
