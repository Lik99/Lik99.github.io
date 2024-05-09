<?php 
    require 'controleur.php';
	session_start() ;
    include 'type.entete.html';
?>

   <form id="quick-search" method="get" action="type_recherche.php">
      <fieldset class="search">
         <label for="qsearch">Search:</label>
         <input class="tbox" id="qsearch" type="text" name="qsearch" value="Recherche par type..." title="Start typing and hit ENTER" />
         <button class="btn" title="Submit Search">Search</button>
      </fieldset>
   </form>
   <script>
    document.addEventListener('DOMContentLoaded', function() {
        var input = document.getElementById('qsearch');
        input.addEventListener('focus', function() {
            if (this.value === "Recherche par type...") {
                this.value = "";
            }
        });
    });
   </script>

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

                    <h2><a href="type1.html">Quel type recherchez-vous?</a></h2>

                    <p class="post-info"><span>Des livres pour tous les goûts</span></p>

					<form action="type2.php" method="GET">

					<?php
					// Envoyer des données/opérations au contrôleur
                    $Controleur = new typeControleur();
                    // Le contrôleur appelle les méthodes du modèle
                    $Controleur->afficher_all_type();
					?>
					</form>
					
                    
					<?php
					// Envoyer des données/opérations au contrôleur
                    $pageControleur = new FunctionBaseControleur();
                    // Le contrôleur appelle les méthodes du modèle
                    $pageControleur->change_page_type($page_type, $totalPages_type);
					?>
					

                </div>

                <?php
				include('info.perso.html')
				?>

		    </article>



        <!-- /main -->
        </div>

        <!-- sidebar -->
		<div id="sidebar">

		<div class="sidemenu">

		<h3>Notre sélection</h3>

		<ul>
			<?php
			// Envoyer des données/opérations au contrôleur
			$directeurControleur = new DirecteurControleur();
			// Le contrôleur appelle les méthodes du modèle
			$directeurControleur->random_5_type();
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
