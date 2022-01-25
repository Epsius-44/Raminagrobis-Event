<?php
$title = "Liste des campagnes";
include_once "../src/layout/headerAdmin.php";
include_once "../src/config.php";
include_once "../src/actions/database-connection.php";
include_once "../src/actions/function.php";



$search = filter_input(INPUT_GET, 'search');
if (isset($search)) {
    $campaigns_list = sqlCommand("SELECT id,title,description,start_date,end_date,organisation FROM form WHERE title LIKE :search OR description LIKE :search OR organisation LIKE :search", [":search" => "%" . $search . "%"], $conn);
} else {
    $campaigns_list = sqlCommand("SELECT id,title,description,start_date,end_date,organisation FROM form", [], $conn);
}
$today = date("Y-m-d");

?>

<div class="container">
    <h1>Liste des campagnes</h1>
    <?php if (isset($search)) {
        echo "<h2>Résultat de la recherche '" . htmlspecialchars($search, ENT_QUOTES, 'UTF-8') . "'</h2>";
    } ?>


    <form action="./campaigns_list.php" method="get">
        <div class="input-group mb-3">
            <div class="form-floating">
                <input type="text" class="form-control" placeholder="recherche un formulaire" name="search" id="search">
                <label for="search">Rechercher un formulaire</label>
            </div>
            <button class="btn btn-outline-secondary" type="submit"><span class="fad fa-search"></span></button>
        </div>
    </form>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nom</th>
            <th scope="col">Organisation</th>
            <th scope="col">Description</th>
            <th scope="col">Début</th>
            <th scope="col">Fin</th>
            <th scope="col">Status</th>
            <th scope="col">Modifier</th>
            <th scope="col">Données</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($campaigns_list)==0){
            ?>
        <tr>
            <th colspan="9" class="text-center">Aucune donnée</th>
        </tr>
        <?php
        }else{
            foreach ($campaigns_list as $data) {
                ?>
            <tr>
                <th scope="row"><?= $data["id"] ?></th>
                <td class="table-list"><?= $data["title"] ?></td>
                <td class="table-list"><?= $data["organisation"] ?></td>
                <td class="table-list"><?= $data["description"] ?></td>
                <td><?= $data["start_date"] ?></td>
                <td><?= $data["end_date"] ?></td>
                <td ><?php if ($today >= $data['start_date'] and $today <= $data['end_date']) {
                        echo "<span class='text-success'>En cours</span>";
                    }else if($today < $data['start_date']){
                        echo "<span class='text-warning'>Commence dans ".nbDays($today,$data['start_date'])." jours</span>";
                    }else{
                        echo "<span class='text-danger'>Terminé</span>";
                    }?></td>
                <td><a href="./campaign.php?id=<?= $data["id"] ?>" class="btn btn-danger"><span class="far fa-edit"></span></a></td>
                <td><a href="./campaign_data.php?id=<?= $data["id"] ?>" class="btn btn-primary"><span class="fad fa-database"></span></a></td>
            </tr>
        <?php }} ?>
        </tbody>
    </table>
</div>
<?php
include_once "../src/layout/footer.php";
?>
