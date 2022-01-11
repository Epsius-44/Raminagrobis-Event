<?php
    $organization = filter_input(INPUT_POST,"organization");
    $event_name = filter_input(INPUT_POST, "event_name");
    $description = filter_input(INPUT_POST, "description");
    $add_file = filter_input(INPUT_POST, "add_file");
    $color_primary = filter_input(INPUT_POST, "color_primary");
    $color_secondary = filter_input(INPUT_POST, "color_secondary");
    $start_date = filter_input(INPUT_POST, "start_date");
    $end_date = filter_input(INPUT_POST, "end_date");
    $sector = [];
    //TODO boucle pour chaque secteur + vérifier intégriter donnée envoyé
    foreach