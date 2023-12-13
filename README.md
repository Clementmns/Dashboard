# SAE 303 - DashBoard

## Installation

Téléchargez l'archive. Ouvrez la dans un éditeur de texte comportant un invite de commande. Allez dans le dossier contenant le README.MD avec `cd ... ` et entrez dans l'invite de commande :

`npm install` ou `npm i`

## Choix réalisés :

### Technique :

Utilisation de npm pour gérer les dépendances (**TailwindCSS et jQuery**).
J'ai choisi d'utiliser AJAX pour transmettre les données de JavaScript à PHP à JavaScript (**Envoie des valeurs des formulaires, requête via la bdd, Affichage avec Chart.JS**).

#### Représentation des données :

Du point de vue des représentation des données, étant donné que les années des bdd étaient différentes en fonction de la table, j'ai du mettre deux graphiques concernant le département (**Évolution temporelle de la consommation d'énergie, Répartition de la consommation totale par filière énergétique et par secteurs**) et deux graphiques concernant la région (**Comparaison de la production d'énergie entre sources renouvelables et non renouvelables, Moyenne de consommation en fonction de l'heure**). Ces représentations permettent de couvrir un large champ des données utilisables.

## Niveau de réalisation :

Le Dashboard s'appuie sur une base de donnée et permet une **interaction** avec l'utilisateur (Année et mois).

## Difficultés rencontrées et surmontées :

-  "Consommation ... (Mwh)" dans région en varchar dans la bdd -> Je l'ai donc mise en Float
-  Réalisation d'une requête AJAX qui renvoie un tableau JSON comprennant lui-même les tableaux du contenu des requêtes SQL.

## Lien TPWEB

https://omnescle.tpweb.univ-rouen.fr/sae303/
