<?php 
	require 'controleur.php';
    include 'dejaVu_retour.entete.html'
    
?>

                  <h3><p>Vous avez réussi à emprunter la film :</br></br><span style="color: red;"><?php echo $titreFilm; ?></span></p></h3>
                  <h3><p></br></br>Veuillez le rendre avant le :</br></br><span style="color: red;"><?php echo $dateRetour; ?></span></p></h3></br>

                        <!-- Les informations sur les films empruntés avec succès et les dates de retour sont affichées ici. -->
                        <?php
                        // Envoyer des données/opérations au contrôleur
                        $Film_emprunterControleur = new FunctionBaseControleur();
                        // Le contrôleur appelle les méthodes du modèle
                        $Film_emprunterControleur->Film_emprunter_emprunter($IdFilm);
                        ?>		

                            <a id="returnLink" href="#">Retour à la page précédente</a>

                            <script>
                            document.getElementById('returnLink').addEventListener('click', function(event) {
                            event.preventDefault();
                            window.history.back();
                            });
                            </script>
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
