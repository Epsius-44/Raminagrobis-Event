<?php
    $title = "Accueil";
    include "./source/php/layout/header.php";
    include "./source/php/actions/database-connection.php";
?>
<main>
    <section id="home-hero">
        <div class="container">
            <div class="container-form">
                <h1>Se connecter</h1>
                <form action="?" id="register" method="POST">

                    <input type="text"
                           class="form-control"
                           id="username"
                           name="username"
                           placeholder="Nom d'utilisateur"
                           value=""
                           maxlength="255"
                           required>


                    <input type="password"
                           class="form-control"
                           id="password"
                           name="password"
                           placeholder="Mot de passe"
                           value=""
                           maxlength="36"
                           minlength="8"
                           required>

                    <button type="submit" class="btn btn-primary"><span class="fas fa-sign-in-alt"></span> Se connecter
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>
<br>
<?php
    include "./source/php/layout/footer.php";
?>
