$(document).ready(function () {
   createCharts();
   $(".fetchData1").on("change", function () {
      createCharts();
   });
   $(".fetchData2").on("change", function () {
      createCharts();
   });
});

function createCharts() {
   // FORM DATA
   var year = $("#year").val();
   var month = $("#month").val();

   // AJAX REQUEST
   $.ajax({
      type: "GET",
      url: "actions/formAction.php",
      data: { year: year, month: month },
      dataType: "json",
      success: function (allData) {
         // DELETE OLD CHARTS
         if (window.chart1 !== undefined) {
            window.chart1.destroy();
         }
         if (window.chart2 !== undefined) {
            window.chart2.destroy();
         }
         if (window.chart3 !== undefined) {
            window.chart3.destroy();
         }
         if (window.chart4 !== undefined) {
            window.chart4.destroy();
         }

         // CHART 1 -> Évolution temporelle de la consommation d'énergie
         const dataChart1 = allData.dataChart1;

         const labelsChart1 = dataChart1.map((entry) => entry["Année"]);
         const valuesChart1 = dataChart1.map(
            (entry) => entry["SommeConsommation"]
         );

         var ctx1 = document.getElementById("chart__1").getContext("2d");
         window.chart1 = new Chart(ctx1, {
            type: "line",
            data: {
               labels: labelsChart1,
               datasets: [
                  {
                     label: "Consommation totale",
                     data: valuesChart1,
                     backgroundColor: "rgba(75, 192, 192, 0.2)",
                     borderColor: "rgba(75, 192, 192, 1)",
                     borderWidth: 1,
                  },
               ],
            },
            options: {
               plugins: {
                  title: {
                     display: true,
                     text: "Évolution temporelle de la consommation d'énergie en Lozère (de 2011 à 2021)",
                  },
               },
               scales: {
                  y: {
                     beginAtZero: false,
                     title: {
                        display: true,
                        text: "Consommation totale (MWh)",
                     },
                  },
                  x: {
                     title: {
                        display: true,
                        text: "Année",
                     },
                  },
               },
               responsive: true,
               maintainAspectRatio: true,
            },
         });

         const dataMoyenneConso = allData.dataChart1A;
         const dataConsoHaute = allData.dataChart1B;

         const valeurMoyenneConso = dataMoyenneConso[0].Moyenne_globale;
         const moyenneConso = totFormat(valeurMoyenneConso);
         $(".moyenneConso").text(moyenneConso);

         const valeurConsoHaute = dataConsoHaute[0].consoHaute;
         const consoHaute = totFormat(valeurConsoHaute);
         $(".consoHaute").text(consoHaute);

         // CHART 2 -> Répartition de la consommation totale par filière énergétique et par secteurs
         const dataChart2A = allData.dataChart2A;
         const dataChart2B = allData.dataChart2B;

         let valuesFiliale1 = [];
         let valuesFiliale2 = [];
         if (dataChart2A.length > 0) {
            valuesFiliale1 = Object.values(dataChart2A[0]);
         }
         if (dataChart2B.length > 0) {
            valuesFiliale2 = Object.values(dataChart2B[0]);
         }

         var ctx2 = document.getElementById("chart__2").getContext("2d");
         window.chart2 = new Chart(ctx2, {
            type: "radar",
            data: {
               labels: [
                  "Agriculture",
                  "Industrie",
                  "Tertiaire",
                  "Résidentiel",
                  "Inconnu",
               ],
               datasets: [
                  {
                     label: "Enedis",
                     data: valuesFiliale1,
                     backgroundColor: "rgba(0, 0, 255, 0.2)", // Mettre en bleu
                     borderColor: "blue",
                     borderWidth: 1,
                  },
                  {
                     label: "RTE",
                     data: valuesFiliale2,
                     backgroundColor: "rgba(255, 0, 0, 0.2)", // Mettre en rouge
                     borderColor: "red",
                     borderWidth: 1,
                  },
               ],
            },
            options: {
               plugins: {
                  title: {
                     display: true,
                     text:
                        "Production par opérateur et par secteur en Lozère (" +
                        year +
                        ")",
                  },
               },
               responsive: true,
               maintainAspectRatio: true,
            },
         });

         // CHART 3 -> Comparaison de la production d'énergie entre sources renouvelables et non renouvelables
         const dataChart3 = allData.dataChart3;

         let keysChart3 = [];
         let valuesChart3 = [];
         if (dataChart3.length > 0) {
            keysChart3 = Object.keys(dataChart3[0]);
            valuesChart3 = Object.values(dataChart3[0]);
         }

         calculateData3(dataChart3);

         var ctx3 = document.getElementById("chart__3").getContext("2d");
         window.chart3 = new Chart(ctx3, {
            type: "pie",
            data: {
               labels: keysChart3,
               datasets: [
                  {
                     label: "Répartition des énergies",
                     data: valuesChart3,
                     backgroundColor: [
                        "rgba(255, 0, 0, 0.7)",
                        "rgba(220, 0, 0, 0.7)",
                        "rgba(180, 0, 0, 0.7)",

                        "rgba(0, 255, 0, 0.7)",
                        "rgba(0, 200, 0, 0.7)",
                        "rgba(0, 150, 0, 0.7)",
                        "rgba(0, 100, 0, 0.7)",
                     ],
                     borderColor: [
                        "rgba(255, 0, 0, 1)",
                        "rgba(220, 0, 0, 1)",
                        "rgba(180, 0, 0, 1)",
                        "rgba(0, 255, 0, 1)",
                        "rgba(0, 200, 0, 1)",
                        "rgba(0, 150, 0, 1)",
                        "rgba(0, 100, 0, 1)",
                     ],
                     borderWidth: 1,
                  },
               ],
            },
            options: {
               plugins: {
                  title: {
                     display: true,
                     text:
                        "Répartition des énergies en Occitanie (" + month + ")",
                  },
               },
               responsive: true,
               maintainAspectRatio: true,
            },
         });

         // CHART 4 -> Moyenne de consommation en fonction de l'heure
         const dataChart4 = allData.dataChart4;

         const labels = dataChart4.map((entry) => entry.heures);
         const values = dataChart4.map((entry) =>
            parseFloat(entry.moyenne_consommation)
         );

         var ctx4 = document.getElementById("chart__4").getContext("2d");
         window.chart4 = new Chart(ctx4, {
            type: "bar",
            data: {
               labels: labels.map((hour) => `${hour}h`),
               datasets: [
                  {
                     label: "Moyenne de consommation",
                     data: values,
                     backgroundColor: "rgba(54, 162, 235, 0.5)",
                     borderColor: "rgba(54, 162, 235, 1)",
                     borderWidth: 1,
                  },
               ],
            },
            options: {
               plugins: {
                  title: {
                     display: true,
                     text: "Moyenne de consommation pour chaque heure en Occitanie",
                  },
               },
               scales: {
                  x: {
                     title: {
                        display: true,
                     },
                     ticks: {
                        autoSkip: false,
                        stepSize: 1,
                     },
                  },
                  y: {
                     beginAtZero: false,
                  },
               },
               responsive: true,
               maintainAspectRatio: true,
            },
         });

         // CHART 5 -> Conso totale par année
         const dataChart5 = allData.dataChart5;

         const valeurDataChart5 = dataChart5[0].tot;
         const totConso = totFormat(valeurDataChart5);
         $(".consoTot").text(totConso);
      },
      error: function (xhr, status, error) {
         console.error(error);
      },
   });
}

// FONCTIONS

function calculateData3(dataChart3) {
   const energiesRenouvelables = [
      "Bioénergies",
      "Eolien",
      "Hydraulique",
      "Solaire",
   ];

   let totalRenouvelable = 0;
   let totalNonRenouvelable = 0;

   if (dataChart3.length > 0) {
      const energyData = dataChart3[0];

      for (const energy in energyData) {
         const value = parseInt(energyData[energy]);
         if (energiesRenouvelables.includes(energy)) {
            totalRenouvelable += value;
         } else {
            totalNonRenouvelable += value;
         }
      }

      const total = totalRenouvelable + Math.abs(totalNonRenouvelable);
      const pourcentageRenouvelable = (totalRenouvelable / total) * 100;
      const pourcentageNonRenouvelable =
         (Math.abs(totalNonRenouvelable) / total) * 100;
      $(".energyRenouvelables").text(`${pourcentageRenouvelable.toFixed(1)}%`);
      $(".energyNonRenouvelables").text(
         `${pourcentageNonRenouvelable.toFixed(1)}%`
      );
   } else {
      console.error("Le tableau de données dataChart3 est vide.");
   }
}

function totFormat(valeur) {
   const millions = Math.round((valeur / 1000) * 10) / 10;
   return millions + "K MWh";
}
