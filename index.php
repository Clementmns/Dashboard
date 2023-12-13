<!-- Mise a jour des formulaires -->
<?php
if (isset($_GET["year"])) {
   $globalYear = $_GET["year"];
} else {
   $globalYear = 2011;
}

if (isset($_GET["month"])) {
   $globalMonth = $_GET["month"];
} else {
   $globalMonth = "2021-01";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard -- SAE303</title>
   <link rel="stylesheet" href="output.css">
   <!-- JQuery -->
   <script src="./node_modules/jquery/dist/jquery.min.js"></script>
   <!-- Chart JS -->
   <script src="./node_modules/chart.js/dist/chart.umd.js"></script>

</head>

<body class="bg-gray-200 dark:bg-gray-900 dark:text-gray-400 text-gray-900">

   <!-- NAVBAR -->
   <nav class="fixed w-screen h-12 mt-0 top-0 bg-gray-100 dark:bg-gray-800 z-10 p-3">
      <div class="flex justify-between">
         <div>
            <h2>Dashboard - Clément Omnès</h2>
         </div>
      </div>
   </nav>

   <!-- CONTAINER -->
   <div class="w-screen p-5 mt-12">
      <!-- GRILLE 1 -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-10 gap-5 w-full z-0">

         <!-- CHART 1 - Évolution temporelle de la consommation d'énergie en Lozère -->
         <div class="bg-gray-100 dark:bg-gray-800 p-6 md:col-span-2 lg:col-span-6 rounded-lg drop-shadow-md row-span-3">
            <div class="mt-[5vh]">
               <canvas id="chart__1" class="m-0" height="120"></canvas>
            </div>
            <!-- CONSO MOYENNE -->
            <div class="flex justify-between items-center gap-10 w-full mt-8">
               <p id="title5">Moyenne de consommation (de 2011 à 2021) : </p>
               <h3 class="moyenneConso lg:text-8xl md:text-7xl text-7xl"></h3>
            </div>
            <!-- CONSO HAUTE -->
            <div class="flex justify-between items-center gap-10 w-full mt-8">
               <p id="title5">Consommation la plus haute (2021) : </p>
               <h3 class="consoHaute lg:text-8xl md:text-7xl text-7xl"></h3>
            </div>
         </div>

         <!-- CHART 2 - Répartition de la consommation totale par filière énergétique et par secteurs  -->
         <div class="bg-gray-100 dark:bg-gray-800 p-6 lg:col-span-4 rounded-lg drop-shadow-md lg:row-span-3 row-span-2">
            <form>
               <label for="year">Année :</label>
               <select class="fetchData1" name="year" id="year">
                  <option <?php if ($globalYear == 2011) {
                              echo "selected";
                           } ?> value="2011">2011</option>
                  <option <?php if ($globalYear == 2012) {
                              echo "selected";
                           } ?> value="2012">2012</option>
                  <option <?php if ($globalYear == 2013) {
                              echo "selected";
                           } ?> value="2013">2013</option>
                  <option <?php if ($globalYear == 2014) {
                              echo "selected";
                           } ?> value="2014">2014</option>
                  <option <?php if ($globalYear == 2015) {
                              echo "selected";
                           } ?> value="2015">2015</option>
                  <option <?php if ($globalYear == 2016) {
                              echo "selected";
                           } ?> value="2016">2016</option>
                  <option <?php if ($globalYear == 2017) {
                              echo "selected";
                           } ?> value="2017">2017</option>
                  <option <?php if ($globalYear == 2018) {
                              echo "selected";
                           } ?> value="2018">2018</option>
                  <option <?php if ($globalYear == 2019) {
                              echo "selected";
                           } ?> value="2019">2019</option>
                  <option <?php if ($globalYear == 2020) {
                              echo "selected";
                           } ?> value="2020">2020</option>
                  <option <?php if ($globalYear == 2021) {
                              echo "selected";
                           } ?> value="2021">2021</option>
               </select>
            </form>

            <div>
               <canvas id="chart__2"></canvas>
            </div>
            <hr>
            <!-- CONSO GLOBALE PAR ANNÉE -->
            <div class="flex items-center h-full w-full flex-col mt-8">
               <p id="title5">Consommation globale en Lozère (en MWh)</p>
               <h3 class="consoTot lg:text-8xl md:text-7xl text-7xl h-auto"></h3>
            </div>
         </div>

         <!-- CHART 3 - Comparaison de la production d'énergie entre sources renouvelables et non renouvelables -->
         <div class="bg-gray-100 dark:bg-gray-800 p-6 lg:col-span-3 rounded-lg drop-shadow-md row-span-2">
            <form>
               <label for="month">Mois :</label>
               <input type="month" min="2021-01" max="2022-05" <?php echo "value=" . $globalMonth ?> id="month" class="fetchData2" name="month">
            </form>
            <div class="w-full">

               <canvas id="chart__3"></canvas>
               <div class="flex justify-center items-center">
                  <div class="w-full flex justify-center">
                     <div class="flex justify-center gap-10 sm:gap-40 md:gap-20 lg:top-[62%] top-[70%] w-full dark:text-white lg:text-2xl md:text-xl md:top-[62%] sm:top-[55%] text-xl">
                        <div>
                           <p class="text-[12px]">Energie renouvelables</p>
                           <p class=" energyRenouvelables"></p>
                        </div>
                        <div class="flex items-end flex-col">
                           <p class="text-[12px]">Energie non-renouvelables</p>
                           <p class="energyNonRenouvelables"></p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <!-- CHART 4 - Moyenne de consommation en fonction de l'heure -->
         <div class="bg-gray-100 dark:bg-gray-800 p-6 lg:col-span-7 md:col-span-2 rounded-lg drop-shadow-md row-span-2">
            <div>
               <canvas id="chart__4"></canvas>
            </div>
         </div>
      </div>
   </div>

   <!-- JAVASCRIPT -->
   <script src="./chartManager.js"></script>

</body>

</html>