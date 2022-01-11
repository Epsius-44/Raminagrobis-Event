<?php
$title = "Modification des catégories";
include "../source/php/layout/header.php";
include "../source/php/actions/database-connection.php";
?>

<main>
    <section>
        <div class="container">
            <h1>Gestion des secteurs</h1>
            <?php
            //connexion à la base de donnée
            $requete=$conn->prepare("SELECT * FROM sector");//creation de la requete
            $requete->execute();//executer la requete
            $lignes=$requete->fetchAll();//réccupérer le résultat sous forme d'un tableau
            ?>

            <!-- Listing des secteurs déjà enregistrés dans la base de donnée -->
            <table class="table table-striped">
                <tr> <!-- nom des colonnes -->
                    <th>
                        Nom
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
                <?php
                // création du tableau en fonction du nombre de secteurs enregistrés dans la base de donnée
                foreach($lignes as $l){
                    ?>
                    <tr>
                        <td> <!-- affichage du nom du secteur -->
                            <?php echo $l["name"] ?>
                        </td>
                        <td> <!-- option applicable au secteur enregistrés dans la base de donnée-->
                            <div class="modify">
                                <span class="fas fa-edit"></span> <!-- apparition et disparition au clic ddu formulaire-->
                                <form action="../source/php/actions/modify_name_sector.php">
                                    <input type="text" placeholder="<?php echo $l["name"] ?>" autofocus required/>
                                    <input type="submit" value="Modifier"/>
                                </form>
                            </div>
                            <div class="delete">
                                <span class="fas fa-trash"></span><!-- apparition au clic de la poubelle-->
                                <form action="../source/php/actions/delete_sector.php">
                                    <input type="submit" value="Confirme"/>
                                </form>
                                <button>
                                    Annule <!-- disparition du "confirme/annule -->
                                </button>
                            </div>
                        </td>
                    </tr>

                    <?php
                }
                ?>

            </table>
            <div class="insert"> <!-- création d'un nouveau secteur dans la base de donnée-->
                <span>
                    Ajouter
                </span>
                <form action="">
                    <input type="text" placeholder="Secteur"/> <!-- nommage du secteur -->
                    <input type="submit" value="Créer"/>
                </form>
            </div>
        </div>
    </section>
</main>
<script>
    <!-- apparition et disparition -->
</script>
<?php
include "../source/php/layout/footer.php";
?>