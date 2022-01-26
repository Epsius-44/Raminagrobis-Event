<?php
$title = "Données formulaire";
include_once "../src/layout/headerAdmin.php";
include_once "../src/config.php";
include_once "../src/actions/database-connection.php";
include_once "../src/actions/function.php";


$id = filter_input(INPUT_GET, 'id');
if (isset($id)) {
    $exist = sqlCommand("SELECT count(id) FROM form WHERE id=:id", [":id" => $id], $conn)[0]['count(id)'];
    if ($exist != 1) {
        echo "<div class='container'><h1>Cette campagne n'existe pas</h1><br><a href='campaigns_list.php' class='btn btn-primary'>Liste des campagnes</a></div>";
    }else{
    $form_data = sqlCommand("SELECT title,start_date,end_date FROM form WHERE id=:id",[":id"=>$id],$conn)[0];
    $file = $id."-".$form_data["title"].".csv";

        $search = filter_input(INPUT_GET, 'search');
        if (isset($search)) {
            $campaign_data = sqlCommand("SELECT civility, firstname, lastname, email, tel_mob, tel_fix, type, comp_name, people_num, news, score, id_category FROM form_data WHERE id_form=:id AND (
firstname LIKE :search OR lastname LIKE :search OR email LIKE :search OR tel_fix LIKE :search OR tel_mob LIKE :search)", [":id" => $id, ":search"=>"%".$search."%"], $conn);
        } else {
            $campaign_data = sqlCommand("SELECT civility, firstname, lastname, email, tel_mob, tel_fix, type, comp_name, people_num, news, score, id_category FROM form_data WHERE id_form=:id", [":id" => $id], $conn);
        }
    ?>
    <div class="container">
        <div class="z-flex mb-4 mt-5">
        <a href="../data_csv/<?= $file ?>" class="btn btn-success"><span class="fad fa-download"></span>  Télécharger les données</a>
<button class="btn btn-outline-primary" data-bs-toggle="modal"
        data-bs-target="#modalLink"><span class="fad fa-link"></span> Lien du formulaire</button>
        </div>
        <h1>Donnée du formulaire</h1>
        <?php if (isset($search) and $search != "") {
            echo "<h2>Résultat de la recherche '" . DataBDSafe($search) . "'</h2>";
        } ?>
        <form action="./campaign_data.php" method="get" class="needs-validation" novalidate>
            <div class="input-group mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control" placeholder="recherche un formulaire" name="search" id="search" required>
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <label for="search">Rechercher un formulaire</label>
                </div>
                <button class="btn btn-outline-secondary fs-5" type="submit"><span class="fad fa-search"></span></button>
                <?php if (isset($search) and $search != "") {
                    echo "<a href='campaign_data.php?id=$id' class='btn btn-outline-danger text-center fs-4'><span class='fad fa-times-circle text-center'></span></a>";
                } ?>
            </div>

        </form>
        <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Genre</th>
            <th scope="col">Prénom</th>
            <th scope="col">Nom</th>
            <th scope="col">Email</th>
            <th scope="col">Mobile</th>
            <th scope="col">Fixe</th>
            <th scope="col">Nom de l'entreprise</th>
            <th scope="col">Secteur d'activité</th>
            <th scope="col">Nbr de personnes</th>
            <th scope="col">Newsletter</th>
            <th scope="col">Score</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($campaign_data) == 0) {
            ?>
            <tr>
                <th colspan="11" class="text-center">Aucune donnée</th>
            </tr>
            <?php
        } else {
            foreach ($campaign_data as $data) {

                ?>
                <tr>
                    <td class="table-list"><?php
                        switch ($data["civility"]) {
                            case 0:
                                echo "Homme";
                                break;
                            case 1:
                                echo "Femme";
                                break;
                            case 2:
                                echo "Autre";
                                break;
                        }
                        ?></td>
                    <td class="table-list"><?= dataBDSafe($data["firstname"]) ?></td>
                    <td class="table-list"><?= dataBDSafe($data["lastname"]) ?></td>
                    <td><?= dataBDSafe($data["email"]) ?></td>
                    <td><?= dataBDSafe($data["tel_mob"]) ?></td>
                    <td><?= dataBDSafe($data["tel_fix"]) ?></td>
                    <td><?php if($data["type"]==1){
                        $sector = sqlCommand("SELECT name FROM sector WHERE id=:id",[":id"=>$data["id_category"]],$conn)[0]["name"];
                        echo dataBDSafe($data["comp_name"])."</td><td>".dataBDSafe($sector);
                        }else{
                        echo "particulier</td><td>/";
                        }?></td>
                    <td><?= dataBDSafe($data["people_num"]) ?></td>
                    <td><?php if($data["news"]==1){
                        echo "Inscrit";
                        }else{
                        echo "Non";
                        }?></td>
                    <td><?= dataBDSafe($data["score"]) ?></td>
                </tr>
            <?php }
        } ?>
        </tbody>
    </table>
    </div>
        <div class="modal fade" id="modalLink"
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
                        Le lien de la campagne "<?= dataBDSafe($form_data["title"]); ?>" (valide
                        du <?= date("d/m/Y", strtotime($form_data["start_date"])) ?> à 00h00
                        au <?= date("d/m/Y", strtotime($form_data["end_date"])) ?> est :
                        <input id="azerty" type="text" class="form-control" readonly
                               value="<?= url_campaign($id, 2) ?>">

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
    }
    include_once "../src/layout/footer.php";

} else {
    header("Location: ./campaigns_list.php");
} ?>