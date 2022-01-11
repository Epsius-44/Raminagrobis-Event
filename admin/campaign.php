<?php
$title = "Nouveau formulaire";
include "../source/php/layout/header.php";
?>

    <main>
        <section id="home-hero">
            <div class="container">
                <div class="container-form">
                    <?php include "../source/php/actions/database-connection.php";
                    $request = $conn->prepare("select * from sector order by name");
                    $request->execute();
                    $lines=$request->fetchAll();
                    ?>
                    <form action="?" id="campaign" name="campaign" method="POST" enctype="multipart/form-data">
                        <label for="event_name"></label>
                        <input type="text"
                               class="form-control"
                               id="event_name"
                               name="event_name"
                               value=""
                               maxlength="255"
                               required>
                        <label for="description"></label>
                        <input type="text"
                               class="form-control"
                               id="description"
                               name="description"
                               value=""
                               maxlength="65535"
                               required>
                        <label for="add_file"></label>
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
                               name="color_primary">
                        <label for="color_secondary">Couleur secondaire</label>
                        <input type="color"
                               class="form-control"
                               id="color_secondary"
                               name="color_secondary">

                        <?php
                        foreach($lines as $l){
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
        document.getElementById("campaign").addEventListener("submit",function(e){
            if (countCheckedPureJS() === 0){
                e.preventDefault();
                console.log(countCheckedPureJS());
            }
        });
        function countCheckedPureJS(){
            var elements = document.getElementsByClassName("groupcheckbox"),
                i,
                count = 0;
            for (i = 0; i < elements.length; i++){
                if (elements[i].checked){
                    count++;
                }
            }
            return count;
        }
    </script>
<?php
include "../source/php/layout/footer.php";
?>