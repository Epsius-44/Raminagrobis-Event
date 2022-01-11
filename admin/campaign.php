<?php
$title = "Nouveau formulaire";
include "../source/php/layout/header.php";
?>

<main>
    <section id="home-hero">
        <div class="container">
            <div class="container-form">
                <form action="?" id="register" method="POST" enctype="multipart/form-data">
                    <label for="event_name"></label>
                    <input type="text"
                           class="form-control"
                           id="event_name"
                           name="event_name"
                           value=""
                           maxlength="255"
                           required>
                    <label for="description"></label>
                    <input type="text"
                           class="form-control"
                           id="description"
                           name="description"
                           value=""
                           maxlength="65535"
                           required>
                    <label for="add_file"></label>
                    <input type="file"
                           class="form-control"
                           id="add_file"
                           name="add_file"
                           accept="image/png, image/jpeg"
                           required>
                    <label for="color_primary">Couleur primaire</label>
                    <input type="color"
                    class="form-control"
                    id="color_primary"
                    name="color_primary">
                    <label for="color_secondary">Couleur secondaire</label>
                    <input type="color"
                           class="form-control"
                           id="color_secondary"
                           name="color_secondary">
                    <label for="sector">Secteur d'activité de l'entreprise</label>
                    <select name="sector" id="sector" required>
                        <option value="" selected disabled>--Sélectionner une catégorie--</option>
                        <!--TODO Connexion à la base de donnée pour ajouter les catégories-->
                    </select>
                    <input type="submit" value="OK">
                </form>
            </div>
        </div>
    </section>
</main>
<?php
include "../source/php/layout/footer.php";
?>