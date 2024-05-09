<?php 
	require 'controleur.php';
	include 'directeur.entete.html'
?>

   <form Id="quick-search" method="get" action="directeur_recherche.php">
      <fieldset class="search">
         <label for="qsearch">Search:</label>
         <input class="tbox" Id="qsearch" type="text" name="qsearch" value="Recherche par nom d'directeur..." title="Start typing and hit ENTER" />
         <button class="btn" title="Submit Search">Search</button>
      </fieldset>
   </form>

   <script>
    document.addEventListener('DOMContentLoaded', function() {
        var input = document.getElementById('qsearch');
        input.addEventListener('focus', function() {
            if (this.value === "Recherche par nom d'directeur...") {
                this.value = "";
            }
        });
    });
   </script>

<!--/header-->
</header></div>
	
<!-- content-wrap -->
<div Id="content-wrap">

    <!-- content -->
    <div Id="content" class="clearfix">

   	    <!-- main -->
        <div Id="main">

            <!-- post -->
      	    <article class="post">

                <!-- primary -->
         	    <div class="primary">

            	    <h2><a href="directeur1.php">Les directeurs en vue</a></h2>

                    <p class="post-info"><span>Sur le devant de la scène</span></p>

					<form action="directeur2.php" method="GET">
					 <?php
					 // Envoyer des données/opérations au contrôleur
					 $directeurControleur = new DirecteurControleur();
					 // Le contrôleur appelle les méthodes du modèle
					 $directeurControleur->all_directeur();
					?>
					</form>

					<?php
					// Envoyer des données/opérations au contrôleur
                    $pageControleur = new FunctionBaseControleur();
                    // Le contrôleur appelle les méthodes du modèle
                    $pageControleur->change_page_dire($page_dire, $totalPages_dire);
					?>
	 

                </div>
				
				<?php
				include('info.perso.html')
				?>
			</article>

        <!-- /post -->
        </div>

        <!-- sidebar -->
		<div Id="sidebar">
			<div class="sidemenu">

				<h3>Notre sélection</h3>

                <ul>
					<?php
					// Envoyer des données/opérations au contrôleur
					$directeurControleur = new DirecteurControleur();
					// Le contrôleur appelle les méthodes du modèle
					$directeurControleur->random_5_directeur();
					?>
				</ul>

			</div>

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
