<?php
$title = "Connexion à votre compte";
include "../src/layout/headerAdmin.php";
?>
<main class="form-signin text-center mx-auto">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h1 class="h2 mb-3 fw-normal">Se connecter</h1>
                        <form action="?" id="register" method="POST" class="">
                            <div class="form-floating">
                                <input type="text"
                                       class="form-control form-login"
                                       id="login"
                                       name="login"
                                       placeholder="jean@raminagrobis.fr"
                                       value=""
                                       maxlength="255"
                                       required>
                                <label for="login">identifiant ou adresse email</label>
                            </div>
                                <div class="form-floating">
                                <input type="password"
                                       class="form-control form-login"
                                       id="password"
                                       name="password"
                                       placeholder="password"
                                       value=""
                                       maxlength="36"
                                       minlength="8"
                                       required>
                                <label for="password">Mot de passe</label>
                            </div>
                            <button type="submit" class="btn btn-primary my-4 w-100">
                                <span class="fas fa-sign-in-alt"></span>  Se connecter
                            </button>
                        </form>
                    </div>
                </div>
</main>
<?php
include "../src/layout/footer.php";
?>
