<?php 
	require 'controleur.php';
  	include('avis.entete.html')
?>

</header></div>
	
<!-- content-wrap -->
<div id="content-wrap">
    <!-- content -->
    <div id="content" class="clearfix">
	<div Id="sidebar">
				<div class="sidemenu">
				<h3>Vos précédents commentaires</h3>
					<ul>
						<?php

						// Envoyer des données/opérations au contrôleur
                        $avisControleur = new AvisControleur();
                        // Le contrôleur appelle les méthodes du modèle
                        $avisControleur->precedents_commentaires($IdUser);
					
						?>
					</ul>
				</div>
			<!-- /sidebar -->
			</div>

   	    <!-- main -->
        <div id="main">

            <div class="main-content">

      	    <h2><a href="avis1.php">Partagez votre avis</a></h2>
			  <p class="post-info"><span>Quand on aime, on partage</span></p>

					<div class="navigation clearfix">
						<div><a href="avis2.php" >Laisser mon avis &raquo; </a></div>
					</div>

					<ul class="archive">

						<?php

						// Envoyer des données/opérations au contrôleur
                        $avisControleur = new AvisControleur();
                        // Le contrôleur appelle les méthodes du modèle
                        $avisControleur->all_avis();
						
						?>
						

					</ul>
					
					<?php

					// Envoyer des données/opérations au contrôleur
					$pageControleur = new FunctionBaseControleur();
					// Le contrôleur appelle les méthodes du modèle
					$pageControleur->change_page_avis($page_type, $totalPages_type);

					?>

        <!-- /main -->
        </div>
		

    <!-- content -->
	</div>

<!-- /content-out -->
</div>
		
</body>
</html>
