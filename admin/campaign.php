<!--TODO sécurité-->
<?php
$title = "Nouveau formulaire";
include "../src/layout/headerAdmin.php";
include_once "../src/config.php";
include_once "../src/actions/database-connection.php";
$campaign_id = filter_input(INPUT_GET, "id");
$sector_lines = sqlCommand("SELECT * FROM sector ORDER BY name", [], $conn);
if (isset($campaign_id)==true){
    $data = sqlCommand("SELECT * FROM form WHERE id = :campaign_id", [":campaign_id" => $campaign_id], $conn);
    if (count($data)==0){
       header("Location: ./campaign.php");
    }
    $campaign_data = $data[0];
    $sectorSelect = sqlCommand("SELECT id_sector FROM form_sector WHERE id_form = :campaign_id", [":campaign_id" => $campaign_id], $conn );
    $sector_checked = [];
    foreach($sectorSelect as $sector){
        $sector_checked[] = $sector[0];
    }
}else{
    $sector_checked = [];
    $campaign_data['organisation'] = "";
    $campaign_data['title'] = "";
    $campaign_data['description'] = "";
    $campaign_data['color_primary'] = "000000";
    $campaign_data['color_secondary'] = "000000";
    $campaign_data['start_date'] = date("Y-m-d");
    $campaign_data['end_date'] = date("Y-m-d");;
}
?>

    <main>
        <section id="home-hero">
            <div class="container">
                <div class="container-form">
                    <form action="../src/actions/add_modify_campaign.php" id="campaign" name="campaign" method="POST" enctype="multipart/form-data">
                        <label for="organization">nom de l'organisation</label>
                        <input type="text"
                               class="form-control"
                               id="organization"
                               name="organization"
                               value="<?php echo $campaign_data['organisation']; ?>"
                               maxlength="31"
                               required>
                        <label for="event_name">nom de l'évenement</label>
                        <input type="text"
                               class="form-control"
                               id="event_name"
                               name="event_name"
                               value="<?php echo $campaign_data['title']; ?>"
                               maxlength="255"
                               required>
                        <label for="description">description</label>
                        <input type="text"
                               class="form-control"
                               id="description"
                               name="description"
                               value="<?php echo $campaign_data['description']; ?>"
                               maxlength="65535"
                               required>
                        <label for="add_file">bannière</label>
                        <input type="file"
                               class="form-control"
                               id="add_file"
                               name="add_file"
                               accept=".png, .jpg, .jpeg"
                               <?php if ($campaign_id == null){
                                   echo "required";
                               }?>>
                        <label for="color_primary">Couleur primaire</label>
                        <input type="color"
                               class="form-control"
                               id="color_primary"
                               name="color_primary"
                               value="<?php echo '#' . $campaign_data['color_primary']; ?>">
                        <label for="color_secondary">Couleur secondaire</label>
                        <input type="color"
                               class="form-control"
                               id="color_secondary"
                               name="color_secondary"
                               value="<?php echo '#' . $campaign_data['color_secondary']; ?>">
                        <label for="start_date">date de début du formulaire (à 00h00)</label>
                        <input type="date"
                               class="form-control"
                               id="start_date"
                               name="start_date"
                               min="<?php echo $campaign_data['start_date']; ?>"
                               value="<?php echo $campaign_data['start_date']; ?>"
                               onchange="minDate()"
                               required>
                        <label for="end_date">date de fin du formulaire (à 23h59)</label>
                        <input type="date"
                               class="form-control"
                               id="end_date"
                               name="end_date"
                               min="<?php echo $campaign_data['start_date']; ?>"
                               value="<?php echo $campaign_data['end_date']; ?>"
                               required>
                        <?php
                        foreach ($sector_lines as $l) {
                            ?>
                            <input type="checkbox"
                                   class="group-checkbox"
                                   id="<?php echo $l['id']; ?>"
                                   name="<?php echo "checkbox_sector_".$l['id']; ?>"
                            <?php echo in_array($l['id'],$sector_checked) ? "checked>" : ">"?>
                            <label for="<?php echo $l['id']; ?>"><?php echo $l['name']; ?></label>
                            <?php
                        }
                        ?>
                        <input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>">
                        <p class="visually-hidden text-danger" id="text-checkbox">Vous devez sélectionner au moins un secteur d'activité</p>
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
                document.getElementById("text-checkbox").className = "text-danger";
            }
        });

        function countCheckedPureJS() {
            var elements = document.getElementsByClassName("group-checkbox"),
                i,
                count = 0;
            for (i = 0; i < elements.length; i++) {
                if (elements[i].checked) {
                    count++;
                }
            }
            return count;
        }

        function minDate() {
            var element = document.getElementById("end_date");
            element.setAttribute("min",document.getElementById("start_date").value)
        }
    </script>
<?php
include "../src/layout/footer.php";
?>