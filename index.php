<?php
$title = "Accueil";
include "./source/php/layout/header.php";
?>
<main>
    <section id="home-hero">
        <div class="form-header">
            <h1>🎫 {NOM DE L'EVENT}</h1>
            <p>{DESCRIPTION}</p>
            <hr>
            <h2>🏭 {ENTREPRISE ORGANISATRICE}</h2>
        </div>
        <div class="container">
            <div class="container-form">
                <form action="?" id="register" method="POST">
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
                            <option value="0">{NOM SECTEUR}</option>
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
