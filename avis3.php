<?php 
	require 'controleur.php';
	include('avis.entete.html')
?>

<!--/header-->
</header></div>
	
<!-- content-wrap -->
<div id="content-wrap">

    <!-- content -->
    <div id="content" class="clearfix">

   	    <!-- main -->
        <div id="main">

            <div class="main-content">

      	    <h2><a href="avis2.php">Partagez votre avis</a></h2>
			  <p class="post-info"><span>Quand on aime, on partage</span></p>
              <a id="returnLink" href="avis1.php">Retour à la page Avis</a>

              <div class="post-bottom-section">


                <h4>Dites-nous ce que vous en pensez</h4>

                <div class="primary">

                    <form action="avis3.php" method="post" id="commentform">

                        <ul>
						 <?php
                         // Envoyer des données/opérations au contrôleur
                        $avisControleur = new AvisControleur();
                        // Le contrôleur appelle les méthodes du modèle
                        $avisControleur->laisser_mon_avis($IdUser,$nomUser);
                   		 ?>
                        </ul>
                                                          
                </form>

                </div>

         </div>
        <!-- /main -->
        </div>

    <!-- content -->
	</div>

<!-- /content-out -->
</div>
		
</body>
</html>
