<?php
include_once "../src/actions/security_token.php";
include_once "../src/config.php";
include_once "../src/actions/database-connection.php";
$campaign_id = filter_input(INPUT_GET, "id");
$sector_lines = sqlCommand("SELECT * FROM sector ORDER BY name", [], $conn);
if (isset($campaign_id) == true) {
    $data = sqlCommand("SELECT * FROM form WHERE id = :campaign_id", [":campaign_id" => $campaign_id], $conn);
    if (count($data) == 0) {
        header("Location: ./campaign.php");
    }
    $campaign_data = $data[0];
    $sectorSelect = sqlCommand("SELECT id_sector FROM form_sector WHERE id_form = :campaign_id", [":campaign_id" => $campaign_id], $conn);
    $sector_checked = [];
    foreach ($sectorSelect as $sector) {
        $sector_checked[] = $sector[0];
    }
    $title = "Modification formulaire";
} else {
    $title = "Nouveau formulaire";
    $sector_checked = [];
    $campaign_data['organisation'] = "";
    $campaign_data['title'] = "";
    $campaign_data['description'] = "";
    $campaign_data['color_primary'] = "000000";
    $campaign_data['color_secondary'] = "000000";
    $campaign_data['start_date'] = date("Y-m-d");
    $campaign_data['end_date'] = date("Y-m-d");;
}
include "../src/layout/headerAdmin.php";

?>

<main>
    <section id="home-hero">
        <div class="container my-5 border border-4 px-5 py-5 bg-light">
            <div class="container-form">
                <form class="row needs-validation" novalidate action="../src/actions/add_modify_campaign.php" id="campaign" name="campaign"
                      method="POST" enctype="multipart/form-data">
                    <div class="form-floating mb-4 col-md-6">
                        <input type="text"
                               class="form-control"
                               id="organization"
                               name="organization"
                               value="<?php echo $campaign_data['organisation']; ?>"
                               maxlength="31"
                               placeholder="nom de l'organisation"
                               required>
                        <label for="organization">nom de l'organisation</label>
                    </div>
                    <div class="form-floating mb-4 col-md-6">
                        <input type="text"
                               class="form-control"
                               id="event_name"
                               name="event_name"
                               value="<?php echo $campaign_data['title']; ?>"
                               maxlength="255"
                               placeholder="nom de l'évènement"
                               required>
                        <label for="event_name">nom de l'évènement</label>
                    </div>
                    <div class="form-floating mb-4 col-12">
                            <textarea class="form-control"
                                      name="description"
                                      id="description"
                                      placeholder="description"
                                      maxlength="65535"
                                      oninput="updateTextareaHeight(this);"
                                      required
                                      style="resize: none;"
                            ><?php echo $campaign_data['description']; ?></textarea>
                        <label for="description">description</label>
                    </div>
                    <div class="input-group mb-1 col-12">
                        <label class="input-group-text" for="add_file">bannière (taille max: 2Mo)</label>
                        <input type="file"
                               class="form-control"
                               id="add_file"
                               name="add_file"
                               accept=".png, .jpg, .jpeg"
                            <?php if ($campaign_id == null) {
                                echo "required";
                            } ?>>
                    </div>
                    <p class="visually-hidden text-danger mt-1" id="text-file">Le fichier sélectionner a une taille
                        supérieur à 2Mo</p>
                    <div class="preview align">

                    </div>
                    <div class="input-group my-4 col-12">
                        <label class="input-group-text col-md-2" for="color_primary">Couleur primaire</label>
                        <input type="color"
                               class="form-control form-control-color"
                               id="color_primary"
                               name="color_primary"
                               value="<?php echo '#' . $campaign_data['color_primary']; ?>">
                    </div>
                    <div class="input-group mb-4 col-12">
                        <label class="input-group-text col-md-2" for="color_secondary">Couleur secondaire</label>
                        <input type="color"
                               class="form-control form-control-color"
                               id="color_secondary"
                               name="color_secondary"
                               value="<?php echo '#' . $campaign_data['color_secondary']; ?>">
                    </div>
                    <div class="form-floating mb-5 col-md-6">
                        <input type="date"
                               class="form-control"
                               id="start_date"
                               name="start_date"
                               min="<?php echo $campaign_data['start_date']; ?>"
                               value="<?php echo $campaign_data['start_date']; ?>"
                               onchange="minDate()"
                               required>
                        <label for="start_date">date de début du formulaire (à 00h00)</label>
                    </div>
                    <div class="form-floating mb-3 col-md-6">
                        <input type="date"
                               class="form-control"
                               id="end_date"
                               name="end_date"
                               min="<?php echo $campaign_data['start_date']; ?>"
                               value="<?php echo $campaign_data['end_date']; ?>"
                               required>
                        <label for="end_date">date de fin du formulaire (à 23h59)</label>
                    </div>
                    <fieldset class="form-control">
                        <legend>Secteur d'activité</legend>
                        <?php
                        $item = 6;
                        echo "<div class='col-12 btn-group-vertical'>";
                        for ($y = 0; $y <= intdiv(count($sector_lines), $item); $y++) {
                            echo "<div class='btn-group'>";
                            $nbr_x = (count($sector_lines) - $y * $item >= $item) ? $item : count($sector_lines) - $y * $item;
                            for ($x = 1; $x <= $nbr_x; $x++) {
                                $value = $sector_lines[($x - 1) + $y * $item]["id"];
                                $name = "checkbox_sector_" . $value;
                                $sector_name = $sector_lines[($x - 1) + $y * $item]['name'];
                                $checked = (in_array($value, $sector_checked)) ? " checked" : "";
                                echo "<input type='checkbox'
                                        class='group-checkbox btn-check'
                                        id='$value'
                                        name='$name'
                                        onchange='checkbox_count(this)'
                                        $checked>
                                        <label class='btn btn-outline-success col-md-2 py-3' for='$value' id='label_$value'>$sector_name</label>
                                      ";
                            }
                            echo "</div>";
                        }
                        echo "<input type='checkbox' id='checkbox_required' hidden required></div>";
                        ?>
                    </fieldset>
                    <div class="invalid-feedback">Vous devez sélectionner au moins un secteur d'activité</div>
                    <input type="hidden" name="campaign_id" value="<?= $campaign_id ?>">
                    <input type="hidden" name="token" value="<?= $token ?>">
                    <div class="mt-5">
                        <input class="btn btn-outline-primary px-4" type="submit" value="Valider">
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
<script>
    var element = document.getElementsByName("campaign");
    var checkbox = document.getElementById("checkbox_required");
    var count_checkbox = countCheckedPureJS()
    validate_checkbox()

    function checkbox_count (input) {
        if (input.checked) {
            count_checkbox ++;
        }else{
            count_checkbox --;
        }
        validate_checkbox()
    }

    function validate_checkbox () {
        if (count_checkbox >= 1 && checkbox.hasAttribute("required")){
            checkbox.removeAttribute("required");
        }else if (count_checkbox === 0 && checkbox.hasAttribute("required") === false){
            checkbox.setAttribute("required","required");
        }
    }

    var uploadField = document.getElementById("add_file");

    uploadField.onchange = function () {
        if (this.files[0].size > 2097152) {
            document.getElementById("text-file").className = "text-danger mt-1";
            this.value = "";
        } else {
            document.getElementById("text-file").className = "visually-hidden text-danger mt-1";
        }
    };

    var preview = document.querySelector('.preview');
    var input = document.getElementById("add_file")
    input.addEventListener('change', updateImageDisplay);


    function updateImageDisplay() {
        while (preview.firstChild) {
            preview.removeChild(preview.firstChild);
        }
        var curFiles = input.files;
        if (curFiles.length === 1) {
            for (var i = 0; i < curFiles.length; i++) {
                var image = document.createElement('img');
                image.setAttribute("height","250px");
                image.className = "rounded mx-auto d-block mt-3";
                image.src = window.URL.createObjectURL(curFiles[i]);
                preview.appendChild(image);
            }
        }
    }


    function updateTextareaHeight(input) {
        input.style.height = 'auto';
        input.style.height = (input.scrollHeight + 2) + 'px';
    }

    function countCheckedPureJS() {
        var elements = document.getElementsByClassName("group-checkbox"), i, count = 0;
        for (i = 0; i < elements.length; i++) {
            if (elements[i].checked) {
                count++;
            }
        }
        console.log(count)
        return count;
    }

    function minDate() {
        var element = document.getElementById("end_date");
        element.setAttribute("min", document.getElementById("start_date").value)
    }

    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
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