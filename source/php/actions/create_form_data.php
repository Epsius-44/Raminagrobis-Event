<?php
include "database-connection.php";
// TODO ADD SECURE TOKEN
$civility = filter_input(INPUT_POST, "civility-fild");
$firstname = filter_input(INPUT_POST, "firstname-field");
$lastname = filter_input(INPUT_POST, "lastname-field");
$email = filter_input(INPUT_POST, "email-field");
$mobile = filter_input(INPUT_POST, "mobile-field");
$fixe = filter_input(INPUT_POST, "fixe-field");
$peopleType = filter_input(INPUT_POST, "peopleType-field");
$sector = filter_input(INPUT_POST, "sector-field");
$compagny = filter_input(INPUT_POST, "compagny-field");
$number = 1; // FIXME Add number field in form
$rgdp = filter_input(INPUT_POST, "rgpd-field");
$news = filter_input(INPUT_POST, "news-field");
$score = 3; //TODO ADD SCORE DEFINITION
$id_form = 1; //TODO ADD FORM ID


// TODO ADD DATA VALIDATION
$request = $conn->prepare("INSERT INTO form_data (civility, firstname, lastname, email, tel_mob, tel_fix, type, comp_name, people_num, news, score, id_form, id_category) VALUES (:civility, :firstname, :lastname, :email, :tel_mob, :tel_fix, :type, :comp_name, :people_num, :news, :score, :id_form, :id_category)");
$request->bindParam(":civility", $civility);
$request->bindParam(":firstname", $firstname);
$request->bindParam(":lastname", $lastname);
$request->bindParam(":email", $email);
$request->bindParam(":tel_mob", $mobile);
$request->bindParam(":tel_fix", $fixe);
$request->bindParam(":type", $peopleType);
$request->bindParam(":comp_name", $compagny);
$request->bindParam(":people_num", $number);
$request->bindParam(":news", $news);
$request->bindParam(":score", $score);
$request->bindParam(":id_form", $id_form);
$request->bindParam(":id_category", $sector);
$request->execute();