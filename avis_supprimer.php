<?php 
    require 'controleur.php';
    include('avis.entete.html')
?>
  
</header></div>
	
<!-- content-wrap -->
<div id="content-wrap">

    <!-- content -->
    <div id="content" class="clearfix">

   	    <!-- main -->
        <div id="main">

            <div class="main-content">

      	    <h2><a href="avis2.php">Supprimer votre avis</a></h2>
			  <p class="post-info"><span>Nous nous félicitons de recevoir à nouveau votre avis !</span></p>
              <a id="returnLink" href="#">Retour à la page précédente</a>
                <script>
                document.getElementById('returnLink').addEventListener('click', function(event) {
                event.preventDefault();
                window.history.back();
                });
                </script>

              <div class="post-bottom-section">

                <div class="primary">

                    <form action="#" method="GET" id="commentform">

                        <ul>
						 <?php

                        // Envoyer des données/opérations au contrôleur
                        $avisControleur = new AvisControleur();
                        // Le contrôleur appelle les méthodes du modèle
                        $avisControleur->supprimer_avis($IdUser);
     
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
