<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/da7397688c.js" crossorigin="anonymous"></script>
    <title><?= $title ?></title>
</head>
<?php if (isset($class) == false){
    $class = "";
}
if (isset($navbar)==false){
    $navbar = true;
}
?>
<body class="<?= $class ?>">
<?php if ($navbar){ ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="./sector.php">Secteurs d'activité</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="./campaigns_list.php">Liste des campagnes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="./campaign.php">Créer une campagne</a>
                </li>
            </ul>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <!-- TODO enelever le texte "test" et remettre la fonction php quand l'utilisateur devra forcément être connecté pour accéder aux pages admin-->
                    <p class="navbar-text fs-4 my-auto me-3"><span class="fad fa-user-circle"></span> test<?php //echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></p>
                </li>
                <li class="nav-item mt-2">
                    <a class="btn btn-primary" aria-current="page" href="../src/actions/logout.php"><p class="my-auto"><span class="fas fa-sign-out-alt"></span> Se déconnecter</p></a>
                </li>
            </ul>
    </div>
</nav>
<?php }?>