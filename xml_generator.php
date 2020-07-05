<?php

/**
 * Parses the order and saves important attributes to XML file
 * 
 * @package eph_plugin
 */


// TODO pocet zasielok
// TODO odosielatel atributy

/**
 * Parses $order_data variable and saves its content to $xml_file
 * 
 * @param order_data variable containing order data
 * @param xml_file variable for storing xml attributes, later to be exported
 */
function create_xml($order_data, $xml_file) {
    xml_begin($xml_file);
}


function xml_begin($xml_file) {

    // ----------------------------------------
    // DOM-generovany XML file
    
    $xml = new DOMDocument('1.0','UTF-8');
    $xml->formatOutput = true;

    // ----------------------------------------
    // <EPH verzia='3.0'>
    
    $root = $xml->createElement('EPH');
    $xml->appendChild($root);
    $root->setAttribute('verzia', '3.0');

    // ----------------------------------------
    // <InfoEPH>

    $infoEPH = $xml->createElement('InfoEPH');
    $root->appendChild($infoEPH);
    
    // <InfoEPH> podelementy
    $infoEPH->appendChild($xml->createElement('Mena', 'EUR'));
    
    // TypEPH nastaveny na '1' == EPH
    $infoEPH->appendChild($xml->createElement('TypEPH', '1'));
    $infoEPH->appendChild($xml->createElement('PocetZasielok', '1'));

    // ----------------------------------------
    // <Uhrada>
    
    $uhrada = $xml->createElement('Uhrada');
    $infoEPH->appendChild($uhrada);
    
    // SposobUhrady nastaveny na '5' == postovne platene na poste v hotovosti/kartou
    $uhrada->appendChild($xml->createElement('SposobUhrady', '5'));
    
    // SumaUhrady neznama, bude vypocitane pri podaji na poste, preto 0.00
    $uhrada->appendChild($xml->createElement('SumaUhrady', '0.00'));

    // ----------------------------------------
    // <InfoEPH> podelementy
    
    // DruhPPP nastaveny na '5' == dobierkova suma bude poslana na zadany IBAN
    $infoEPH->appendChild($xml->createElement('DruhPPP', '5'));
    
    // DruhZasielky nastaveny na '1' == Doporuceny list
    $infoEPH->appendChild($xml->createElement('DruhZasielky', '1'));
    
    // ----------------------------------------
    // <Odosielatel>

    $odosielatel = $xml->createElement('Odosielatel');
    $infoEPH->appendChild($odosielatel);

    // ----------------------------------------
    // <Odosielatel> podelementy
    
    $odosielatel->appendChild($xml->createElement('Meno', 'Meno Priezvisko'));
    $odosielatel->appendChild($xml->createElement('Organizacia', 'Firma'));
    $odosielatel->appendChild($xml->createElement('Ulica', 'Ulica 42'));
    $odosielatel->appendChild($xml->createElement('Mesto', 'Mesto'));
    $odosielatel->appendChild($xml->createElement('PSC', '94901'));
    $odosielatel->appendChild($xml->createElement('Telefon', '0944123123'));
    $odosielatel->appendChild($xml->createElement('Email', 'vas@email.com'));
    $odosielatel->appendChild($xml->createElement('CisloUctu', 'SK6311000000002931097161'));
    
    fwrite($xml_file, $xml->saveXML());

}

?>
