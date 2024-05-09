<?php 
  require 'controleur.php';  
  include 'directeur.entete.html' ;
 
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

                <h2><a href="directeur1.php">Les directeurs en vue</a></h2>

                <p class="post-info"><span>Vous cherchez un directeur...</span></p>

                <?php

                // Envoyer des données/opérations au contrôleur
                $directeurControleur = new DirecteurControleur();
                // Le contrôleur appelle les méthodes du modèle
                $directeurControleur->directeur_recherche();

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
