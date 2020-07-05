<?php

/**
 * Parses the order and saves important attributes to XML file
 * 
 * @package eph_plugin
 */


// -----------------------------------------------
  
$xml;
$zasielky;

// -----------------------------------------------

/**
 * Vygeneruje prvu cast XML suboru
 */
function generate_infoEPH($pocet_zasielok) {

    global $xml, $zasielky;

    // DOM-generovany XML subor    
    $xml = new DOMDocument('1.0','UTF-8');
    $xml->formatOutput = true;

    // <EPH verzia='3.0'>
    $root = $xml->createElement('EPH');
    $xml->appendChild($root);
    $root->setAttribute('verzia', '3.0');


    // ------------------------------------------
    // <InfoEPH>

    $infoEPH = $xml->createElement('InfoEPH');
    $root->appendChild($infoEPH);
    
    // <InfoEPH> podelementy
    $infoEPH->appendChild($xml->createElement('Mena', 'EUR'));
    
    // TypEPH nastaveny na '1' == EPH
    $infoEPH->appendChild($xml->createElement('TypEPH', '1'));
    $infoEPH->appendChild($xml->createElement('PocetZasielok', $pocet_zasielok));

    // ------------------------------------------
    // <Uhrada>
    
    $uhrada = $xml->createElement('Uhrada');
    $infoEPH->appendChild($uhrada);
    
    // SposobUhrady nastaveny na '5' == postovne platene na poste v hotovosti/kartou
    $uhrada->appendChild($xml->createElement('SposobUhrady', '5'));
    
    // SumaUhrady neznama, bude vypocitane pri podaji na poste, preto 0.00
    $uhrada->appendChild($xml->createElement('SumaUhrady', '0.00'));

    // ------------------------------------------
    // <InfoEPH> podelementy
    
    // DruhPPP nastaveny na '5' == dobierkova suma bude poslana na zadany IBAN
    $infoEPH->appendChild($xml->createElement('DruhPPP', '5'));
    
    // DruhZasielky nastaveny na '1' == Doporuceny list
    $infoEPH->appendChild($xml->createElement('DruhZasielky', '1'));
    
    // ------------------------------------------
    // <Odosielatel>

    $odosielatel = $xml->createElement('Odosielatel');
    $infoEPH->appendChild($odosielatel);

    // ------------------------------------------
    // Ziskanie hodnot zo Settings API
    $options = get_option('eph_plugin_options');

    $meno = $options['name'] . ' ' . $options['surname'];
    $firma = $options['company'];
    $ulica = $options['street'];
    $mesto = $options['city'];
    $psc = $options['postcode'];
    $telefon = $options['mobile'];
    $email = $options['email'];
    $iban = $options['iban'];

    // ------------------------------------------
    // <Odosielatel> podelementy
    
    $odosielatel->appendChild($xml->createElement('Meno', $meno));
    $odosielatel->appendChild($xml->createElement('Organizacia', $firma));
    $odosielatel->appendChild($xml->createElement('Ulica', $ulica));
    $odosielatel->appendChild($xml->createElement('Mesto', $mesto));
    $odosielatel->appendChild($xml->createElement('PSC', $psc));
    $odosielatel->appendChild($xml->createElement('Telefon', $telefon));
    $odosielatel->appendChild($xml->createElement('Email', $email));
    $odosielatel->appendChild($xml->createElement('CisloUctu', $iban));

    // ------------------------------------------
    // <Zasielky>

    $zasielky = $xml->createElement('Zasielky');
    $root->appendChild($zasielky);
    
}


function generate_zasielka($order) {

    global $xml, $zasielky;

    // ------------------------------------------
    // <Zasielka>

    $zasielka = $xml->createElement('Zasielka');
    $zasielky->appendChild($zasielka);

    // ------------------------------------------
    // <Adresat>

    $adresat = $xml->createElement('Adresat');
    $zasielka->appendChild($adresat);

    // ------------------------------------------
    // Ziskanie udajov z objednavky
    $meno = $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name();
    $ulica = $order->get_billing_address_1();
    $mesto = $order->get_billing_city();
    $psc = $order->get_billing_postcode();
    $suma = $order->get_total();

    // ------------------------------------------
    // <Adresat> podelementy

    $adresat->appendChild($xml->createElement('Meno', $meno));
    $adresat->appendChild($xml->createElement('Ulica', $ulica));
    $adresat->appendChild($xml->createElement('Mesto', $mesto));
    $adresat->appendChild($xml->createElement('PSC', $psc));

    // ------------------------------------------
    // <Info>

    $info = $xml->createElement('Info');
    $zasielka->appendChild($info);

    // ------------------------------------------
    // <Info> podelementy

    // Implicitne odosielane druhou triedou
    $info->appendChild($xml->createElement('Trieda', '2'));

}



function save_xml($xml_file) {

    global $xml;
    
    // ------------------------------------------
    // Zapis do XML suboru

    fwrite($xml_file, $xml->saveXML());

}


?>
