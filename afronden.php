<?php
require_once("inc/inc.shop_Hoofd.php");

if (isset($_POST['plaatsen']) && !empty($_SESSION['cart'])) {
    // 1. Gegevens ophalen uit het uitgebreide formulier
    $voornaam   = htmlspecialchars($_POST['Voornaam']);
    $achternaam = htmlspecialchars($_POST['Achternaam']);
    $email      = htmlspecialchars($_POST['Email']);
    $geslacht   = htmlspecialchars($_POST['Geslacht']); // M, V of X
    $straat     = htmlspecialchars($_POST['Adres']);    // De straatnaam
    $huisnummer = htmlspecialchars($_POST['HuisNummer']); // Het huisnummer
    $postcode   = htmlspecialchars($_POST['Postcode']);
    $gemeente   = htmlspecialchars($_POST['Plaats']);
    $land       = htmlspecialchars($_POST['Land']); 
    $telefoon   = htmlspecialchars($_POST['Telefoon']);
    $totaal     = $_POST['totaal'];
    
    // Datum EN tijd (Zorg dat je kolommen in MySQL op DATETIME staan)
    $datum = date("Y-m-d H:i:s"); 
    
    try {
        $link->beginTransaction();

        // --- STAP 1: ADRES CONTROLE (Bestaat dit adres al?) ---
        $checkAdres = $link->prepare("SELECT AdresID FROM tbl_adres WHERE Plaats = ? AND HuisNummer = ? AND Postcode = ? AND Gemeente = ? AND Land = ?");
        $checkAdres->execute([$straat, $huisnummer, $postcode, $gemeente, $land]);
        $existAdres = $checkAdres->fetch();

        if ($existAdres) {
            $adresID = $existAdres['AdresID']; 
        } else {
            // Nieuw adres toevoegen als het nog niet bestaat
            $sqlAdres = "INSERT INTO tbl_adres (Plaats, HuisNummer, Postcode, Gemeente, Land) VALUES (?, ?, ?, ?, ?)";
            $stmtAdres = $link->prepare($sqlAdres);
            $stmtAdres->execute([$straat, $huisnummer, $postcode, $gemeente, $land]);
            $adresID = $link->lastInsertId();
        }

        // --- STAP 2: KLANT CONTROLE (Bestaat deze klant al via Email?) ---
        $checkKlant = $link->prepare("SELECT KlantNummer FROM tbl_klanten WHERE KlantEmail = ?");
        $checkKlant->execute([$email]);
        $existKlant = $checkKlant->fetch();

        if ($existKlant) {
            $klantID = $existKlant['KlantNummer'];
        } else {
            // Nieuwe klant aanmaken
            $sqlKlant = "INSERT INTO tbl_klanten (KlantVoornaam, KlantNaam, KlantEmail, KlantGsmnummer, AdresID, Geslacht) 
                         VALUES (?, ?, ?, ?, ?, ?)";
            $stmtKlant = $link->prepare($sqlKlant);
            $stmtKlant->execute([$voornaam, $achternaam, $email, $telefoon, $adresID, $geslacht]);
            $klantID = $link->lastInsertId();
        }

        // --- STAP 3: FACTUUR AANMAKEN ---
        $sqlFactuur = "INSERT INTO tbl_factuur (Factuur_Datum, Klant_Nummer) VALUES (?, ?)";
        $stmtFactuur = $link->prepare($sqlFactuur);
        $stmtFactuur->execute([$datum, $klantID]);
        $factuurNummer = $link->lastInsertId();

        // --- STAP 4: BESTELLING (tbl_besteling) ---
        $sqlBestel = "INSERT INTO tbl_besteling (Factuur_Nummer, Expeditie_Datum, Korting, Betaal_Optie, VerzendKosten, Verkoper_ID) 
                      VALUES (?, ?, ?, ?, ?, ?)";
        $stmtBestel = $link->prepare($sqlBestel);
        $stmtBestel->execute([$factuurNummer, $datum, 0, 'Online', 0, 1]); // Verkoper ID 1 = Brocky Admin

        // --- STAP 5: ARTIKELEN OPSLAAN (tbl_factuurlijn) ---
        foreach ($_SESSION['cart'] as $item) {
            $sqlLijn = "INSERT INTO tbl_factuurlijn (Factuur_Nummer, Artikel_Nummer, Aantal, Opmerking, Extra) 
                        VALUES (?, ?, ?, ?, ?)";
            $stmtLijn = $link->prepare($sqlLijn);
            $stmtLijn->execute([
                $factuurNummer, 
                $item['Artikel_Nummer'], 
                $item['aantal'], 
                $item['kleur'], 
                $item['maat']
            ]);
        }

        $link->commit();
        $_SESSION['cart'] = array(); // Winkelwagentje leegmaken

        // Succes melding
        echo "<div class='container mt-5 py-5 text-center'>
                <div class='card shadow-lg p-5 border-0 text-dark'>
                    <i class='fas fa-check-circle text-success fa-5x mb-3'></i>
                    <h2 class='fw-bold'>Bedankt voor je bestelling!</h2>
                    <p class='lead'>Hallo $voornaam, we hebben je gegevens goed ontvangen.</p>
                    <p>Je factuurnummer is: <strong>#$factuurNummer</strong></p>
                    <hr class='my-4'>
                    <a href='Shop.php' class='btn btn-primary btn-lg px-5'>Verder winkelen</a>
                </div>
              </div>";

    } catch (Exception $e) {
        $link->rollBack();
        echo "<div class='alert alert-danger container mt-5'>Fout bij verwerken: " . $e->getMessage() . "</div>";
    }
} else {
    header("Location: Shop.php");
    exit();
}

require_once("inc/inc.shop_voet.php");
?>