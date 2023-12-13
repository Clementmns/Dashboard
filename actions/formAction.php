<?php
require('dbConnection.php');


if (isset($_GET["year"])) {
   $year = htmlspecialchars($_GET["year"]);
} else {
   $year = 2011;
}
if (isset($_GET["month"])) {
   $month = htmlspecialchars($_GET["month"]);
} else {
   $month = "2021-01";
}



// CHART 1
$requestGetChart1 = "SELECT Année, SUM(`Consommation totale (MWh)`) AS SommeConsommation FROM sae303_departement GROUP BY Année ORDER BY Année;";
$getChart1 = $db->prepare($requestGetChart1);
$getChart1->execute();
$dataChart1 = $getChart1->fetchAll(PDO::FETCH_ASSOC);

// CHART CONSO MOYENNE
$requestGetChart1A = "SELECT AVG(consoMoyenne) AS Moyenne_globale FROM ( SELECT `Année`, SUM(`Consommation totale (MWh)`) AS consoMoyenne FROM sae303_departement GROUP BY `Année` ) AS Moyennes_par_annee;";
$getChart1A = $db->prepare($requestGetChart1A);
$getChart1A->execute();
$dataChart1A = $getChart1A->fetchAll(PDO::FETCH_ASSOC);

// CHART CONSO LA PLUS HAUTE
$requestGetChart1B = "SELECT MAX(consoMoyenne) AS consoHaute FROM ( SELECT `Année`, SUM(`Consommation totale (MWh)`) AS consoMoyenne FROM sae303_departement GROUP BY `Année` ) AS consoMoyenne;";
$getChart1B = $db->prepare($requestGetChart1B);
$getChart1B->execute();
$dataChart1B = $getChart1B->fetchAll(PDO::FETCH_ASSOC);


// CHART 2A
$requestGetChart2A = "SELECT `Consommation Agriculture (MWh)`, `Consommation Industrie (MWh)`, `Consommation Tertiaire  (MWh)`, `Consommation Résidentiel  (MWh)`,`Consommation Secteur Inconnu (MWh)` FROM sae303_departement WHERE `Année` = :year AND `Opérateur` = \"Enedis\";";
$getChart2A = $db->prepare($requestGetChart2A);
$getChart2A->bindParam(':year', $year);
$getChart2A->execute();
$dataChart2A = $getChart2A->fetchAll(PDO::FETCH_ASSOC);

// CHART 2B
$requestGetChart2B = "SELECT `Consommation Agriculture (MWh)`, `Consommation Industrie (MWh)`, `Consommation Tertiaire  (MWh)`, `Consommation Résidentiel  (MWh)`,`Consommation Secteur Inconnu (MWh)` FROM sae303_departement WHERE `Année` = :year AND `Opérateur` = 'RTE';";
$getChart2B = $db->prepare($requestGetChart2B);
$getChart2B->bindParam(':year', $year);
$getChart2B->execute();
$dataChart2B = $getChart2B->fetchAll(PDO::FETCH_ASSOC);

// CHART 3
$requestGetChart3 = "SELECT SUM(`Thermique (MW)`) as `Thermique`,SUM(`Nucléaire (MW)`) as `Nucléaire`,SUM(`Ech. physiques (MW)`) as `Ech. physiques`,SUM(`Hydraulique (MW)`) as `Hydraulique`,SUM(`Bioénergies (MW)`) as `Bioénergies`,SUM(`Eolien (MW)`) as `Eolien`,SUM(`Solaire (MW)`) as `Solaire` FROM sae303_region WHERE `Date` LIKE :month";
$getChart3 = $db->prepare($requestGetChart3);
$monthParam = $month . "-%";
$getChart3->bindParam(':month', $monthParam);
$getChart3->execute();
$dataChart3 = $getChart3->fetchAll(PDO::FETCH_ASSOC);

// CHART 4
$requestGetChart4 = "SELECT HOUR(`Heure`) AS heures, AVG(`Consommation (MW)`) AS moyenne_consommation FROM sae303_region GROUP BY HOUR(`Heure`);";
$getChart4 = $db->prepare($requestGetChart4);
$getChart4->execute();
$dataChart4 = $getChart4->fetchAll(PDO::FETCH_ASSOC);

// CHART 5 -> CONSO TOTALE
$requestGetChart5 = "SELECT SUM(`Consommation totale (MWh)`) as tot FROM sae303_departement WHERE `Année` = :year;";
$getChart5 = $db->prepare($requestGetChart5);
$getChart5->bindParam(':year', $year);
$getChart5->execute();
$dataChart5 = $getChart5->fetchAll(PDO::FETCH_ASSOC);


// DATA TO JSON
$allData = array(
   "dataChart1" => $dataChart1,
   "dataChart2A" => $dataChart2A,
   "dataChart2B" => $dataChart2B,
   "dataChart3" => $dataChart3,
   "dataChart4" => $dataChart4,
   "dataChart5" => $dataChart5,
   "dataChart1A" => $dataChart1A,
   "dataChart1B" => $dataChart1B
);

$jsonData = json_encode($allData);

header('Content-Type: application/json');
echo $jsonData;
