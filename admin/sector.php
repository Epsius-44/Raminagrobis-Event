<?php
include_once "../src/actions/security_token.php";
$title = "Modification des catégories";
include "../src/layout/headerAdmin.php";
include_once "../src/config.php";
include_once "../src/actions/database-connection.php";
include_once "../src/actions/function.php";

// Listing des secteurs déjà enregistrés dans la base de donnée
$search = filter_input(INPUT_GET, 'search');

if (isset($search)) {
    $lines = sqlCommand("SELECT * FROM sector  WHERE name LIKE :search ORDER BY name", [":search" => "%" . $search . "%"], $conn);
} else {
    $lines = sqlCommand("SELECT * FROM sector ORDER BY name", [], $conn);
}
?>
    <section>
        <?php if (isset($_SESSION["error_sector"])) {
            if ($_SESSION["error_sector"]) {
                echo "<div class='alert alert-danger'>";
            } else {
                echo "<div class='alert alert-success'>";
            }
            echo $_SESSION["status_sector"] . "</div>";
            unset($_SESSION["error_sector"]);
            unset($_SESSION["status_sector"]);
        } ?>
        <div class="container mt-5">
            <h1>Gestion des secteurs</h1>
            <?php if (isset($search) and $search != "") {
                echo "<h2>Résultat de la recherche '" . DataBDSafe($search) . "'</h2>";
            } ?>
            <form action="./sector.php" method="get">
                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" placeholder="recherche un formulaire"
                               name="search" id="search" value="<?= DataBDSafe($search) ?>">
                        <label for="search">Rechercher un secteur</label>
                    </div>
                    <button class="btn btn-outline-secondary fs-5" type="submit"><span
                                class="fad fa-search"></span></button>
                    <?php if (isset($search) and $search != "") {
                        echo "<a href='sector.php' class='btn btn-outline-danger text-center fs-4'><span class='fad fa-times-circle text-center'></span></a>";
                    }?>
                </div>
            </form>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>Nom</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $nbr_line = 1;
                // création du tableau en fonction du nombre de secteurs enregistrés dans la base de donnée
                if (count($lines)==0){
                    echo "<tr><th class='text-center py-3' colspan='3'>Aucune donnée</th></tr>";
                }else{
                    foreach ($lines as $l) {
                        ?>
                        <tr>
                            <th><?= $nbr_line ?></th>
                            <td> <!-- affichage du nom du secteur -->
                                <?= DataBDSafe($l["name"]) ?>
                            </td>
                            <td> <!-- option applicable au secteur enregistré dans la base de donnée-->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#modalRenameSector<?= $l["id"] ?>">
                                        <span class="fas fa-edit"></span>
                                    </button> <!-- Bouton modifier le nom du secteur -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#modalDeleteSector<?= $l["id"] ?>">
                                        <span class="fas fa-trash"></span>
                                    </button> <!-- Bouton modifier le nom du secteur -->
                                </div>

                                <div class="modal fade" id="modalRenameSector<?= $l["id"] ?>" data-bs-backdrop="static"
                                     data-bs-keyboard="false" tabindex="-1">
                                    <!-- création d'une popup avec un input text pour modifier le nom du secteur -->
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="../src/actions/modify_name_sector.php"
                                                  class="needs-validation"
                                                  method="post" novalidate>
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Modifier le nom du
                                                        secteur
                                                        "<?= DataBDSafe($l["name"]) ?>"</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="Nom du secteur" name="new_name"
                                                               id="sector_<?= $l["id"] ?>" class="form-control"
                                                               maxlength="255" required>
                                                        <label for="sector_<?= $l["id"] ?>">Nouveau nom</label>
                                                    </div>
                                                    <input type="hidden" name="token" value="<?= $token ?>">
                                                    <input type="hidden" name="id" value="<?= $l["id"] ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Annuler
                                                    </button>
                                                    <button type="submit" class="btn btn-success">Modifier</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modalDeleteSector<?= $l["id"] ?>" data-bs-backdrop="static"
                                     data-bs-keyboard="false" tabindex="-1">
                                    <!-- création d'une popup pour valider la suppression d'un secteur -->
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="../src/actions/delete_sector.php" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Suppression le
                                                        secteur
                                                        "<?= DataBDSafe($l["name"]) ?>"</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-floating">
                                                        <p class="text-danger">Souhaitez-vous vraiment supprimer le
                                                            secteur <?= DataBDSafe($l["name"]) ?>
                                                            ?<br><br>
                                                            <span class="far fa-exclamation-triangle"></span> La
                                                            suppression échouera si celui-ci a été sélectionné comme
                                                            l'un des secteurs d'activité d'un formulaire <span
                                                                    class="far fa-exclamation-triangle"></span></p>
                                                    </div>
                                                    <input type="hidden" name="token" value="<?= $token ?>">
                                                    <input type="hidden" name="id" value="<?= $l["id"] ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Annuler
                                                    </button>
                                                    <button type="submit" class="btn btn-success">Supprimer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $nbr_line++;
                    }}
                ?>
                </tbody>
            </table>
            <hr>
            <div> <!-- création d'un nouveau secteur dans la base de donnée-->
                <h2 class="mt-5">Ajouter un secteur</h2>
                <form action="../src/actions/insert_sector.php" method="POST" class="mt-3 needs-validation" novalidate>
                    <div class="input-group mb-3">
                        <div class="form-floating">
                            <input type="text" name="name" placeholder="Secteur" id="add_sector" class="form-control" maxlength="255" required> <!-- nommage du secteur -->
                            <label for="add_sector">Nom du secteur</label>
                        </div>
                        <input type="hidden" name="token" value="<?= $token ?>">
                        <button type="submit" class="btn btn-success"><span class="fad fa-plus-circle"></span></button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        <!-- apparition et disparition -->
        (function () {
            'use strict'

            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
<?php
include "../src/layout/footer.php";
?>