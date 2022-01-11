<?php
$title = "Modification des catégories";
include "../source/php/layout/header.php";
include "../source/php/actions/database-connection.php";
?>

<main>
    <section>
        <div class="container">
            <h1>Gestion des secteurs</h1>
            <?php
            //connexion à la base de donnée
            $requete=$conn->prepare("SELECT * FROM sector");//creation de la requete
            $requete->execute();//executer la requete
            $lignes=$requete->fetchAll();//réccupérer le résultat sous forme d'un tableau
            ?>
            <table class="table table-striped">
                <tr>
                    <th>Nom</th>
                    <th>Action</th>
                </tr>
                <?php

                foreach($lignes as $l){
                    ?>
                    <tr>
                        <td><?php echo $l["name"] ?></td>
                        <td>
                            <span id="modify_name" class="fas fa-edit"></span><!-- apparition et disparition au clic de la div modify-->
                            <div id="modify">
                                <form action="">

                                </form>
                            </div>
                            <span class="fas fa-trash"></span><!-- apparition et disparition au clic de la poubelle et d'un "yes/no"-->
                        </td>
                    </tr>
                    <?php
                }

                ?>
            </table>
            <a href="ajouterCategorie.php" class="btn btn-success">Ajouter</a>
        </div>
    </section>
</main>
<script>
    let modify_name = document.getElementById("modify_name");
    let modify = document.getElementById("modify");
    modify_name.addEventListener("click", () => {
        if(getComputedStyle(modify).display != "none"){
            modify.style.display = "none";
        } else {
            modify.style.display = "block";
        }
    })
</script>
<?php
include "../source/php/layout/footer.php";
?>