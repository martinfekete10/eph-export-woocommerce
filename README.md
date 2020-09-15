# Woocommerce to EPH Export
*English description with installation guide [below](#ENG).*

---

Woocommerce to EPH Export je plugin určený na export Woocommerce objednávok do XML súboru, ktorý je možné importovať do webového systému EPH od Slovenskej Pošty (eph.posta.sk).

### **Funkcie**
- objednávky sú exportované ako **doporučený list**
- podpora **hromadného exportu** objednávok
- podpora zásielok s platbou cez dobierku aj bez dobierky
- okrem adresy príjemcu je exportovaný aj jeho email a telefón (ak bol pri objednávke zadaný)

### **Inštalácia**

1. Stiahnite si obsah tohto archívu kliknutím na zelené tlačidlo **Code** -> **Download ZIP**

![stiahnut plugin](https://i.imgur.com/8Nfa3X9.png "Stiahnuť")

2. Po stiahnutí archívu ho rozbaľte v ľubovoľnom priečinku a nahrajte súbor **eph-export.zip** na váš eshop cez administrátorský systém. **Pluginy** -> **Pridať nový** -> **Prehľadávať** -> nájdite súbor **eph-export.zip** a vyberte ho

![export eph upload plugin](https://i.imgur.com/5S0LNsm.png "Upladnúť plugin")

3. Plugin bude potom automaticky nainštalovaný do vášho systému

![eph plugin nainstalovany](https://i.imgur.com/8x87FVB.png "Nainštalované")

4. Aktivujte plugin. **Pluginy** -> **Nainštalované pluginy** -> Nájdite **Woocommerce to EPH Export** a kliknite na **Aktivovať**. 

![woocommerce export eph konfigurovat](https://i.imgur.com/PeXAG16.png "Konfigurovať")

5. Po aktivovaní sa v hornej časti obrazovky objaví správa o potrebnej konfigurácii, ktorá vás odkáže na **nastavenia pluginu**, kde je potrebné vyplniť **údaje odosielateľa**, ktoré máte uvedené v systéme EPH

![woocommerce export eph nastavenia](https://i.imgur.com/AI6coUz.png "Nastaviť")

### **Použitie**

1. Pre export objednávok stačí **označiť** objednávky určené na podanie
2. Z menu s hromadnými akciami (nad tabuľkou s objednávkami) vyberte možnosť **Exportovať do EPH**.

![woocommerce export eph](https://i.imgur.com/D8BHtM7.png "Exportovať do EPH")

2. Následne bude stiahnutý súbor *eph-export.xml*, ktorý už stačí importovať do EPH.

![eph import xml](https://i.imgur.com/Z02YBaP.png "Exportovať do EPH")

---

## **<a name="ENG"></a>English**
Wordpress plugin for exporting Woocommerce orders into XML file accepted by EPH (Slovak Post online service). Slovak description below.

## **Features**
- orders are exported as **registered letter**
- orders can be **exported in bulk**
- both online payment and cash on delivery payment are supported
- if provided, email and phone of the customer are exported as well

## **Installation**

**Uploading in WordPress Dashboard**
1. Navigate to the **Add New** in the plugins dashboard
2. Navigate to the **Upload** area
3. Select **eph-export.zip** from your computer
4. Click **Install Now**
5. Activate the plugin in the Plugin dashboard

**Using FTP**
1. Download **eph-export.zip**
2. Extract the **eph-export** directory to your computer
3. Upload the **eph-export** directory to the **/wp-content/plugins/** directory
4. Activate the plugin in the Plugin dashboard

## **Usage**
1. Bulk select orders to export
2. In the menu above order table select *Export to EPH*
3. Upload downloaded file to eph.posta.sk

<br>
<br>

---
<br>
<br>

<p style="text-align: center;">
 <a href="http://cutt.ly/eph-export">Donate on PayPal</a>
</p>
