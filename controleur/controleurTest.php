<?php

function afficherFormulaireTest(){
 require_once "vue/formulaireTest.php";   
}


function ajouterTest(){
    if(!isset($_POST["CeQueVousVoulez"]) || strlen($_POST["CeQueVousVoulez"]) > 5 ) {
        header("Location: index.php?ressource=/test");
        return;
    } 

    echo "Ajouter avec succes";
   }