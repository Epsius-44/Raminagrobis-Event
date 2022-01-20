<?php
$title = "Modification des catégories";
include "../src/layout/headerAdmin.php";
include_once "../src/config.php";
include_once "../src/actions/database-connection.php";
// Listing des secteurs déjà enregistrés dans la base de donnée
$lignes = sqlCommand("SELECT * FROM sector", [], $conn);
?>

<main>
    <section>
        <div class="container">
            <h1>Gestion des secteurs</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            Nom
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
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
                                <form action="../src/actions/modify_name_sector.php" method="POST">
                                    <input type="text" name="new_name" placeholder="<?php echo $l["name"] ?>" autofocus required/>
                                    <input type="text" name="previous_name" value="<?php echo $l["name"] ?>" hidden/>
                                    <input type="submit" value="Modifier"/>
                                </form>
                            </div>
                            <div class="delete">
                                <span class="fas fa-trash"></span><!-- apparition au clic de la poubelle-->
                                <form action="../src/actions/delete_sector.php" method="POST">
                                    <input type="text" name="name" value="<?php echo $l["name"] ?>" hidden/>
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
                </tbody>
            </table>
            <div class="insert"> <!-- création d'un nouveau secteur dans la base de donnée-->
                <span>
                    Ajouter
                </span>
                <form action="../src/actions/insert_sector.php" method="POST">
                    <input type="text" name="name" placeholder="Secteur"/> <!-- nommage du secteur -->
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
include "../src/layout/footer.php";
?>