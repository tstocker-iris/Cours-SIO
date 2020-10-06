<?php

/**
 * Fonction permettant de require le fichier de notre classe automatiquement
 *
 * @param $name
 */
function chargerClass($name) {
    require_once './Class/'.$name.'.php';
}

/**
 * Appel à la fonction qui permet d'ajouter nos fichiers de classe automatiquement lors de leur appel
 */
spl_autoload_register('chargerClass');

/**
 * Initialisation de mes objets
 */
$api = new ApiRequest();
$bdd = new PDO('mysql:host=db;dbname=employee', 'root', 'example');

/**
 * Récupération des données à traiter
 */
$data = $bdd->query('SELECT * FROM locations;');

/**
 * Configuration de notre objet avec les données du webservice
 */
$api->setUrl('https://geocode.xyz/');
$api->addOption('json', 1);


foreach ($data as $location) {
    /**
     * Configuration du webservice avec l'adresse de la location
     */
    $api->setAddress(str_replace(' ', '+', $location['street_address']) . '+' . $location['postal_code'] . '+' .str_replace(' ', '+', $location['city']));
    /**
     * Appel du webservice
     */
    $ws = $api->call();

//    print_r($ws);
    echo "Updating location in DB with lat = ".$ws['latt']." lng = ".$ws['longt']."..." . PHP_EOL;
    /**
     * Mise à jour des données en base de données
     */
    $bdd->query('UPDATE locations SET lat = ' . $ws['latt'] . ', lng = ' . $ws['longt'] . ' WHERE location_id = ' .$location['location_id']);

    echo "Sleep 2 sec..." . PHP_EOL;
    /**
     * Mise en pause du script pendant 2 secondes pour ne pas passer le quota de requete autorisées
     */
    sleep(2);
}

