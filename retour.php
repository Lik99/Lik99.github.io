<?php 
    require 'controleur.php';
    include 'dejaVu_retour.entete.html';
    $IdFilm = $_GET['IdFilm']; // 通过链接获取书籍ID     

?>

                  <h3><p>Vous avez retourné le livre avec succès !</br></br></p></h3>
                  


                        <!-- Les informations sur les films empruntés avec succès et les dates de retour sont affichées ici. -->
                        <?php
                        // Envoyer des données/opérations au contrôleur
                        $livre_emprunterControleur = new FunctionBaseControleur();
                        // Le contrôleur appelle les méthodes du modèle
                        $livre_emprunterControleur->Film_emprunter_retour($IdFilm);
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
