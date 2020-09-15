<?php

/**
 * @package   Woo to EPH export
 * @author    Martin Fekete
 * @license   GPLv2 or later
 * @link      https://github.com/martinfekete10/eph-export-woocommerce
 * @copyright 2020 Martin Fekete
 *
 * ----------------------------------------------
 * Parses the order and saves important attributes to XML file
 * 
 */


// -----------------------------------------------
  
$xml;
$zasielky;

// -----------------------------------------------

// The header part of the XML file (sender info)
function spephe_generate_info_eph($pocet_zasielok) {

    global $xml, $zasielky;

    // DOM-generated XML file
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
    
    // <InfoEPH> subelements
    $infoEPH->appendChild($xml->createElement('Mena', 'EUR'));
    
    // TypEPH set to '1' == EPH
    $infoEPH->appendChild($xml->createElement('TypEPH', '1'));
    $infoEPH->appendChild($xml->createElement('PocetZasielok', $pocet_zasielok));

    // ------------------------------------------
    // <Uhrada>
    
    $uhrada = $xml->createElement('Uhrada');
    $infoEPH->appendChild($uhrada);
    
    // SposobUhrady set to '5' == postage will be paid in the post office (cash or card)
    $uhrada->appendChild($xml->createElement('SposobUhrady', '5'));
    
    // SumaUhrady unknown, will be calculated in the post office (hence 0.00)
    $uhrada->appendChild($xml->createElement('SumaUhrady', '0.00'));

    // ------------------------------------------
    // <InfoEPH> subelements
    
    // DruhPPP set to '5' == cash on delivery amount will be sent to provided IBAN
    $infoEPH->appendChild($xml->createElement('DruhPPP', '5'));
    
    // DruhZasielky set to '1' == registered letter (doporuceny list)
    $infoEPH->appendChild($xml->createElement('DruhZasielky', '1'));
    
    // ------------------------------------------
    // <Odosielatel>

    $odosielatel = $xml->createElement('Odosielatel');
    $infoEPH->appendChild($odosielatel);

    // ------------------------------------------
    // Load the data from the Settings API
    $options = get_option('spephe_plugin_options');

    $meno = $options['name'] . ' ' . $options['surname'];
    $firma = $options['company'];
    $ulica = $options['street'];
    $mesto = $options['city'];
    $psc = $options['postcode'];
    $telefon = $options['mobile'];
    $email = $options['email'];
    $iban = $options['iban'];

    // ------------------------------------------
    // <Odosielatel> subelements
    
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

// Generate new <Zasielka> element for every order
function spephe_generate_zasielka($order) {

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
    // Fetch important data from the order

    $meno = $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name();
    $ulica1 = $order->get_billing_address_1();
    $ulica2 = $order->get_billing_address_2();
    $mesto = $order->get_billing_city();
    $psc = $order->get_billing_postcode();
    $suma = $order->get_total();
    $telefon = $order->get_billing_phone();
    $email = $order->get_billing_email();

    // Check if residence number was filled in adress block 1 or 2, if in 2, concat it to the adress
    if ((strpos($ulica1, $ulica2) === false) && ($ulica2 != "")) {
        $ulica1 = $ulica1 . " " . $ulica2;
    }

    // ------------------------------------------
    // <Adresat> subelements

    $adresat->appendChild($xml->createElement('Meno', $meno));
    $adresat->appendChild($xml->createElement('Ulica', $ulica1));
    $adresat->appendChild($xml->createElement('Mesto', $mesto));
    $adresat->appendChild($xml->createElement('PSC', $psc));
    $adresat->appendChild($xml->createElement('Telefon', $telefon));
    $adresat->appendChild($xml->createElement('Email', $email));

    // ------------------------------------------
    // <Info>

    $info = $xml->createElement('Info');
    $zasielka->appendChild($info);

    // ------------------------------------------
    // <Info> subelements

    // If cash on delivery was selected, new element <CenaDobierky> is added
    $platba = $order->get_payment_method();
    if ($platba == "cod") {
        // Cash on delivery
        $info->appendChild($xml->createElement('CenaDobierky', $suma));
        // Variable symbol
        $info->appendChild($xml->createElement('SymbolPrevodu', $order->get_id()));
    }
    
    // All packages are implicitly sent via the 2nd class
    $info->appendChild($xml->createElement('Trieda', '2'));
    
    // Get total weight of order
    $total_weight = 0;
    foreach ($order->get_items() as $item_id => $item) {
        $product = $item->get_product();
        $quantity = $item->get_quantity();
        
        if ($product->has_weight()) {
            $total_weight = $product->get_weight() * $quantity;
        }
    }

    // Add weight element to the XML
    if ($total_weight != 0) {
        $total_weight = number_format((float)$total_weight, 2, '.', '');
        $info->appendChild($xml->createElement('Hmotnost', $total_weight));
    }
}


// Save XML variable to the file in the argument
function spephe_save_xml($xml_file) {

    global $xml;
    
    // ------------------------------------------
    // Write to XML file

    fwrite($xml_file, $xml->saveXML());

}
