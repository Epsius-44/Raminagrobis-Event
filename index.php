<?php
$form_id = filter_input(INPUT_GET, "id");
$title = "Participation à un event";
include "./source/php/layout/header.php";
include "./source/php/actions/database-connection.php";
$request = $conn->prepare("SELECT * FROM form WHERE id=:form_id");
$request->bindParam(":form_id", $form_id);
$request->execute();
$result = $request->fetch();
$today = date("Y-m-d");
if ($result === false or $today <= $result['start_date'] or $today >= $result['end_date']) {
    die("
        <h1>Cet évènement n'existe pas !</h1>
        <p>Merci de vérifier l'URL entrée ainsi que la date de début et de fin des inscription à l'évènement.</p>
        ");
}
?>
<main>
    <section id="home-hero">
        <div class="form-header">
            <h1>🎫 <?= $result['title'] ?></h1>
            <p><?= $result['description'] ?></p>
            <hr>
            <h2>🏭 <?= $result['organisation'] ?></h2>
        </div>
        <div class="container">
            <div class="container-form">
                <form action="source/php/actions/create_form_data.php" id="register" method="POST">
                    <div class="inline-form">
                        <label for="civility-fild">🧑 Civilité</label>
                        <select name="civility-fild" id="civility-fild" required>
                            <option value="" selected disabled>-----</option>
                            <option value="0">M</option>
                            <option value="1">Mme</option>
                            <option value="2">Autre</option>
                        </select>
                        <label for="firstname-field">🧑 Prénom</label>
                        <input type="text"
                               name="firstname-field"
                               id="firstname-field"
                               placeholder="Camille"
                               required>
                        <label for="lastname-field">🧑 Nom</label>
                        <input type="text"
                               name="lastname-field"
                               id="lastname-field"
                               placeholder="Dupont"
                               required>
                    </div>
                    <label for="email-field">✉ E-mail</label>
                    <input type="email"
                           name="email-field"
                           id="email-field"
                           placeholder="camille@dupont.fr"
                           required>
                    <div class="inline-form">
                        <label for="mobile-field">📞 Téléphone Mobile</label>
                        <input type="tel"
                               name="mobile-field"
                               id="mobile-field"
                               placeholder="0600000000">
                        <label for="fixe-field">📞 Téléphone Fixe</label>
                        <input type="tel"
                               name="fixe-field"
                               id="fixe-field"
                               placeholder="0200000000">
                    </div>
                    <label for="peopleType-field">🏭 Entreprise ?</label>
                    <input type="checkbox"
                           name="peopleType-field"
                           id="peopleType-field"
                           onchange="peopleType()">
                    <div class="inline-form">
                        <label for="sector-field" id="sector-label" hidden>🎯 Secteur</label>
                        <select name="sector-field" id="sector-field" hidden>
                            <option value="" selected disabled>Choisir un secteur d'activité</option>
                            <option value="1">{NOM SECTEUR}</option>
                        </select>
                        <label for="compagny-field" id="compagny-label" hidden>🏭 Entreprise</label>
                        <input type="text"
                               name="compagny-field"
                               id="compagny-field"
                               placeholder="Raminagrobis"
                               hidden>
                    </div>
                    <div class="inline-form">
                        <label for="rgpd-field">RGPD ?</label>
                        <input type="checkbox"
                               name="rgpd-field"
                               id="rgpd-field"
                               required>
                        <label for="news-field">Newsletter ?</label>
                        <input type="checkbox"
                               name="news-field"
                               id="news-field">
                    </div>
                    <button type="submit">Valider le formulaire</button>
                </form>
            </div>
        </div>
    </section>
</main>
<script>
    function peopleType(){
        let form_field = [
            document.getElementById("sector-field"),
            document.getElementById("sector-label"),
            document.getElementById("compagny-field"),
            document.getElementById("compagny-label")
        ]
        if (document.getElementById("peopleType-field").checked) {
            for (const field in form_field) {
                form_field[field].hidden = false;
                if (field%2===0) {
                    form_field[field].required = true;
                }
            }
        }
        else{
            for (const field in form_field) {
                form_field[field].hidden = true;
                if (field%2===0) {
                    form_field[field].required = false;
                }
            }
        }
    }
</script>
<?php
include "./source/php/layout/footer.php";
?>
