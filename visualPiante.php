<?php
session_start();
# se non sei loggato, errore
if( !isset($_SESSION['logged']) or $_SESSION['logged']==0)
        header("Location: errore.html");
else
{

    $sql = "SELECT NomeScientifico, NomeComune, NumEsemplari FROM Piante";

    require "php/connessione.php";

    $output = $connessione->query($sql);
    $page = file_get_contents("templates/admin/visualPiante.txt");

    if(!$output){
        $stampa = servError() ;
        $page = str_replace('contenuto', $stampa, $page);
    }
    else {
        $stampa = "";
        if($output->num_rows == 0) {
            $stampa .= "<div class=\"content\"> <p> Nessuna pianta trovata </p><p id=\"indietro\"><a href= \"adminPanel.php\">Torna al menu precedente</a></p> </div>";
            $page = str_replace('contenuto', $stampa, $page);
        }
        else {
             $table = file_get_contents('templates/admin/tabVisualPiante.txt');

             foreach($output as $campo => $cont) {

                $stampa .= "<tr> \n \t";

                foreach($cont as $i => $val) {

                    $stampa .= "<td>".$val."</td> \n \t";
                }
                $stampa .="</tr>\n"; 
            }
            $table =str_replace('corpoTabella', $stampa, $table);
            $page = str_replace('contenuto', $table, $page);
        }
    }
    
    echo $page;
    
    $connessione->close();
}

?>
