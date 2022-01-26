<?php
$title = "Liste des campagnes";
include_once "../src/layout/headerAdmin.php";
include_once "../src/config.php";
include_once "../src/actions/database-connection.php";
include_once "../src/actions/function.php";

$modalPrint = false;
if (isset($_SESSION["error_campaign"])) {
    if ($_SESSION["error_campaign"]) { ?>
        <div class="alert alert-danger">
            <?= $_SESSION["status_campaign"] ?>
        </div>
    <?php } else {
        $modalPrint = true; ?>
        <div class="modal fade" id="modalCampaignSuccess" data-bs-keyboard="false" tabindex="-1">
            <!-- création d'une popup pour afficher le lien du formulaire qui vient d'être créer-->
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title" id="staticBackdropLabel"><?= $_SESSION["status_campaign"] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Le lien de la campagne "<?= dataBDSafe($_SESSION["title_campaign"]); ?>" (valide
                        du <?= date("d/m/Y", strtotime($_SESSION["start_campaign"])) ?> à 00h00
                        au <?= date("d/m/Y", strtotime($_SESSION["end_campaign"])) ?> est :
                        <input id="azerty" type="text" class="form-control" readonly
                               value="<?= url_campaign($_SESSION['id_campaign'], 2) ?>">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">Retour
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
        unset($_SESSION["id_campaign"]);
        unset($_SESSION["start_campaign"]);
        unset($_SESSION["end_campaign"]);
        unset($_SESSION["title_campaign"]);
    }
    unset($_SESSION["error_campaign"]);
    unset($_SESSION["status_campaign"]);
}


$search = filter_input(INPUT_GET, 'search');
if (isset($search)) {
    $campaigns_list = sqlCommand("SELECT id,title,description,start_date,end_date,organisation FROM form WHERE title LIKE :search OR description LIKE :search OR organisation LIKE :search", [":search" => "%" . $search . "%"], $conn);
} else {
    $campaigns_list = sqlCommand("SELECT id,title,description,start_date,end_date,organisation FROM form", [], $conn);
}
$today = date("Y-m-d");

?>

<div class="container-xxl mt-5 mb-3">
    <h1>Liste des campagnes</h1>
    <?php if (isset($search) and $search != "") {
        echo "<h2>Résultat de la recherche '" . DataBDSafe($search) . "'</h2>";
    } ?>


    <form action="./campaigns_list.php" method="get">
        <div class="input-group mb-3">
            <div class="form-floating">
                <input type="text" class="form-control" placeholder="recherche un formulaire" name="search" id="search"
                       >
                <label for="search">Rechercher un formulaire</label>
            </div>
            <button class="btn btn-outline-secondary fs-5" type="submit"><span class="fad fa-search"></span></button>
            <?php if (isset($search) and $search != "") {
                echo "<a href='campaigns_list.php' class='btn btn-outline-danger text-center fs-4'><span class='fad fa-times-circle text-center'></span></a>";
            } ?>
        </div>

    </form>
    <table class="table table-striped ">
        <thead>
        <tr class="text-center">
            <th scope="col">ID</th>
            <th scope="col">Nom</th>
            <th scope="col">Organisation</th>
            <th scope="col">Description</th>
            <th scope="col">Début</th>
            <th scope="col">Fin</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>

        </tr>
        </thead>
        <tbody>
        <?php if (count($campaigns_list) == 0) {
            ?>
            <tr>
                <th colspan="9" class="text-center">Aucune donnée</th>
            </tr>
            <?php
        } else {
            foreach ($campaigns_list as $data) {
                ?>
                <tr class="text-center">
                    <th scope="row"><?= dataBDSafe($data["id"]) ?></th>
                    <td class="table-list"><?= dataBDSafe($data["title"]) ?></td>
                    <td class="table-list"><?= dataBDSafe($data["organisation"]) ?></td>
                    <td class="table-list"><?= dataBDSafe($data["description"]) ?></td>
                    <td><?= dataBDSafe($data["start_date"]) ?></td>
                    <td><?= dataBDSafe($data["end_date"]) ?></td>
                    <td><?php if ($today >= $data['start_date'] and $today <= $data['end_date']) {
                            echo "<span class='text-success'>En cours</span>";
                        } else if ($today < $data['start_date']) {
                            echo "<span class='text-warning'>Commence dans " . nbDays($today, $data['start_date']) . " jours</span>";
                        } else {
                            echo "<span class='text-danger'>Terminé</span>";
                        } ?></td>
                    <td>

                        <a href="./campaign_data.php?id=<?= $data["id"] ?>" class="btn btn-success"><span
                                    class="fad fa-database"></span></a>
                        <a href="../data_csv/<?= $data["id"] ?>-<?= $data["title"] ?>.csv" class="btn btn-success"><span
                                    class="fad fa-download"></span></a>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#modalLinkCampaign<?= $data["id"] ?>">
                            <span class="far fa-link"></span>
                        </button> <!-- Bouton afficher lien du formulaire -->
                        <a href="./campaign.php?id=<?= $data["id"] ?>" class="btn btn-danger"><span
                                    class="far fa-edit"></span></a>

                    </td>
                </tr>
            <?php }
            foreach ($campaigns_list as $data) { ?>
                <div class="modal fade" id="modalLinkCampaign<?= $data["id"] ?>"
                     data-bs-keyboard="false" tabindex="-1">
                    <!-- création d'une popup pour afficher le lien d'un formulaire -->
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Lien du formulaire</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Le lien de la campagne "<?= dataBDSafe($data["title"]); ?>" (valide
                                du <?= date("d/m/Y", strtotime($data["start_date"])) ?> à 00h00
                                au <?= date("d/m/Y", strtotime($data["end_date"])) ?> est :
                                <input id="azerty" type="text" class="form-control" readonly
                                       value="<?= url_campaign($data['id'], 2) ?>">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Retour
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>
        </tbody>
    </table>
</div>
<script>

    <?php if ($modalPrint) { //afficher popup au chargement de la page
        echo "var myModal = new bootstrap . Modal(document . getElementById('modalCampaignSuccess'), {});
        myModal . show();";
    };?>
</script>
<?php
include_once "../src/layout/footer.php";
?>
