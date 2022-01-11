<?php
$title = "Nouveau formulaire";
include "../source/php/layout/header.php";
include "../source/php/actions/database-connection.php";
$campaign_id = filter_input(INPUT_GET, "id");

$request = $conn->prepare("select * from sector order by name");
$request->execute();
$sector_lines = $request->fetchAll();



$campaign_data = ["", "", "", "FFFFFF", "FFFFFF", date("Y-m-d"), date("Y-m-d")];
if ($campaign_id != null) {
    $request = $conn->prepare("select * from form where id = '{$campaign_id}'");
    $request->execute();
    $result = $request->fetchAll();
    if (count($result) == 1) {
        $campaign_data = [$result[0]["organisation"],$result[0]["title"],$result[0]["description"],$result[0]["color_primary"],$result[0]["color_secondary"],$result[0]["start_date"],$result[0]["end_date"]];
        var_dump($campaign_data);
    }
}

$organization = $campaign_data[0];
$event_name = $campaign_data[1];
$event_description = $campaign_data[2];
$color_primary = $campaign_data[3];
$color_secondary = $campaign_data[4];
$start_date = $campaign_data[5];
$end_date = $campaign_data[6];

?>

    <main>
        <section id="home-hero">
            <div class="container">
                <div class="container-form">
                    <form action="?" id="campaign" name="campaign" method="POST" enctype="multipart/form-data">
                        <label for="organization">nom de l'organisation</label>
                        <input type="text"
                               class="form-control"
                               id="organization"
                               name="organization"
                               value="<?= $organization ?>"
                               maxlength="10"
                               required>
                        <label for="event_name">nom de l'évenement</label>
                        <input type="text"
                               class="form-control"
                               id="event_name"
                               name="event_name"
                               value="<?= $event_name ?>"
                               maxlength="255"
                               required>
                        <label for="description">description</label>
                        <input type="text"
                               class="form-control"
                               id="description"
                               name="description"
                               value="<?= $event_description ?>"
                               maxlength="65535"
                               required>
                        <label for="add_file">bannière</label>
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
                               name="color_primary"
                               value="<?= '#' . $color_primary ?>">
                        <label for="color_secondary">Couleur secondaire</label>
                        <input type="color"
                               class="form-control"
                               id="color_secondary"
                               name="color_secondary"
                               value="<?= '#' . $color_secondary ?>">
                        <label for="start_date">date de début du formulaire (à 00h00)</label>
                        <input type="date"
                               class="form-control"
                               id="start_date"
                               name="start_date"
                               value="<?= $start_date ?>"
                               required>
                        <label for="end_date">date de fin du formulaire (à23h59)</label>
                        <input type="date"
                               class="form-control"
                               id="end_date"
                               name="end_date"
                               value="<?= $end_date ?>"
                               required>

                        <?php
                        foreach ($sector_lines as $l) {
                            ?>
                            <input type="checkbox"
                                   class="groupcheckbox"
                                   id="<?= $l['id'] ?>"
                                   name="<?= $l['id'] ?>">
                            <label for="<?= $l['id'] ?>"><?= $l['name'] ?></label>
                            <?php
                        }
                        ?>
                        <!--TODO Connexion à la base de donnée pour ajouter les catégories-->
                        <input type="submit" value="OK">
                    </form>
                </div>
            </div>
        </section>
    </main>
    <script>
        var element = document.getElementsByName("campaign");
        document.getElementById("campaign").addEventListener("submit", function (e) {
            if (countCheckedPureJS() === 0) {
                e.preventDefault();
                console.log(countCheckedPureJS());
            }
        });

        function countCheckedPureJS() {
            var elements = document.getElementsByClassName("groupcheckbox"),
                i,
                count = 0;
            for (i = 0; i < elements.length; i++) {
                if (elements[i].checked) {
                    count++;
                }
            }
            return count;
        }
    </script>
<?php
include "../source/php/layout/footer.php";
?>