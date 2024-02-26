<?php
 
// die Klasse "Auto" definieren
class auto
{
 
    // eine Eigenschaft/Attribut festlegen
    var $benoetigter_kraftstoff;
 
    // eine Methode festlegen (nennt sich Funktion, 
    // ist aber in einer Klasse und 
    // wird somit als Methode bezeichnet) 
    function tankdeckel_oeffnen()
    {
        // Ihr Auto spricht mit Ihnen - wenn der
        // Tankdeckel geöffnet wird, sagt es, welchen
        // Kraftstoff es benötigt
        echo "<p>Bitte mit ";
        echo $this->benoetigter_kraftstoff;
        echo " betanken";
    }
}
 
// bisher passiert noch gar nichts,
// jetzt wird aus der Klasse ein Objekt erzeugt
$auto_1 = new auto;
 
// dem Auto wird nun der Kraftstoff zugewiesen,
// eine Eigenschaft (Attribut) wird definiert
$auto_1->benoetigter_kraftstoff = "Diesel";
 
// und nun wird das erste mal die Methode (Funktion)
// tankdeckel_oeffnen aufgerufen und das Auto sagt
// freudig, was es für Sprit benötigt
$auto_1->tankdeckel_oeffnen();
?>
