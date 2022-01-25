<?php
$title = "Données formulaire";
include_once "../src/layout/headerAdmin.php";
include_once "../src/config.php";
include_once "../src/actions/database-connection.php";

$id = filter_input(INPUT_GET, 'id');
if (isset($id)) {
    $exist = sqlCommand("SELECT count(id) FROM form WHERE id=:id", [":id" => $id], $conn)[0]['count(id)'];
    if ($exist != 1) {
        echo "<div class='container'><h1>Cette campagne n'existe pas</h1><br><a href='campaigns_list.php' class='btn btn-primary'>Liste des campagnes</a></div>";
    }else{
    $campaign_data = sqlCommand("SELECT civility, firstname, lastname, email, tel_mob, tel_fix, type, comp_name, people_num, news, score, id_category FROM form_data WHERE id_form=:id", [":id" => $id], $conn);
    $file = $id."-".sqlCommand("SELECT title FROM form WHERE id=:id",[":id"=>$id],$conn)[0]["title"].".csv";
    ?>
    <div class="container">
        <a href="../data_csv/<?= $file ?>" class="btn btn-success mb-4"><span class="fad fa-download"></span>  Télécharger les données</a>
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
                    <td class="table-list"><?= $data["firstname"] ?></td>
                    <td class="table-list"><?= $data["lastname"] ?></td>
                    <td><?= $data["email"] ?></td>
                    <td><?= $data["tel_mob"] ?></td>
                    <td><?= $data["tel_fix"] ?></td>
                    <td><?php if($data["type"]==1){
                        $sector = sqlCommand("SELECT name FROM sector WHERE id=:id",[":id"=>$data["id_category"]],$conn)[0]["name"];
                        echo $data["comp_name"]."</td><td>".$sector;
                        }else{
                        echo "particulier</td><td>/";
                        }?></td>
                    <td><?= $data["people_num"] ?></td>
                    <td><?php if($data["news"]==1){
                        echo "Inscrit";
                        }else{
                        echo "Non";
                        }?></td>
                    <td><?= $data["score"] ?></td>
                </tr>
            <?php }
        } ?>
        </tbody>
    </table>
    </div>
    <?php
    }
    include_once "../src/layout/footer.php";

} else {
    header("Location: ./campaigns_list.php");
} ?>