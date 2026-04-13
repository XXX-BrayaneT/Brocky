<!-- afiche le ID , naam , aantal en subtotal van de producten in de winkelkar die in de data-bank was -->
<?php require_once("inc/inc.shop_Hoofd.php"); ?>

<?php
// Si l'utilisateur clique sur le lien "Vider le panier"
if(isset($_GET['action']) && $_GET['action'] == "empty") {
    $_SESSION['cart'] = array(); // On remet le panier à zéro
    header("location:winkelkar.php"); // On recharge la page proprement
    exit();
}
?>

<section class="py-5" style="margin-top: 50px;">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Mijn Winkelmandje</h2>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Art-Nr</th>
                        <th>Artikel Naam</th>
                        <th>Kleur</th> <th>Maat</th>  <th>Aantal</th>
                        <th>Prijs (p.st.)</th>
                        <th>Totaal</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $totaal = 0;  
                    
                    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        foreach($_SESSION['cart'] as $bestelregel) {
                            $artikelNummer = isset($bestelregel['Artikel_Nummer']) ? $bestelregel['Artikel_Nummer'] : '';
                            
                            if (empty($artikelNummer)) {
                                continue;
                            }

                            $artNr = $bestelregel['Artikel_Nummer'];
                            $sql = "SELECT * FROM tbl_artikel WHERE Artikel_Nummer = $artNr";
                            $cmd = $link->query($sql);
                            $resultaat = $cmd->fetch(); 
                            
                            // Calculs
                            $aantal = $bestelregel['aantal'];
                            $subtotaal = $resultaat['Artikel_Prijs'] * $aantal;
                            $totaal += $subtotaal;
                            
                            // SÉCURITÉ : Si la couleur ou la taille n'existe pas, on met "Standaard"
                            $kleur = !empty($bestelregel['kleur']) ? $bestelregel['kleur'] : "Standaard";
                            $maat = !empty($bestelregel['maat']) ? $bestelregel['maat'] : "Standaard";
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($artikelNummer); ?></td>
                                    <td><strong><?php echo $resultaat['Artikel_Naam']; ?></strong></td>                       
                                    <td><?php echo isset($bestelregel['kleur']) ? htmlspecialchars($bestelregel['kleur']) : '-'; ?></td>
                                    <td><?php echo isset($bestelregel['maat']) ? htmlspecialchars($bestelregel['maat']) : '-'; ?></td>               
                                    <td><?php echo $bestelregel['aantal']; ?></td>                      
                                    <td>€ <?php echo number_format($resultaat['Artikel_Prijs'], 2, ',', ' '); ?></td>
                                    <td class="fw-bold">€ <?php echo number_format($subtotaal, 2, ',', ' '); ?></td>                                
                                </tr>
                            <?php
                        }
                    } 
                    else {
                        // Message si le panier est vide
                        echo "<tr><td colspan='7' class='text-center py-4 fw-bold'>Je winkelmandje is leeg.</td></tr>";
                    }
                ?> 
                </tbody>
            </table>
        </div>

        <a href="winkelkar.php?action=empty" class="btn btn-outline-danger btn-sm mb-5">
            <i class="fas fa-trash me-2"></i> Hele winkelwagen legen
        </a>
         <!-- terug naar de shop -->

        <div class="mt-4">
            <a href="shop.php" class="btn btn-outline-primary btn-sm mb-5">
                <i class="fas fa-arrow-left me-2"></i> Terug naar de shop
            </a>
        </div>

    </div>
</section>


<section class="container mb-5">
    <div class="row">
        <div class="col-md-6 offset-md-6 border p-4 rounded shadow-sm bg-light">
            <h4 class="mb-4 text-end">Totaal te betalen : <strong class="text-primary">€ <?php echo number_format($totaal, 2, ',', ' '); ?></strong></h4>

            <form action="afronden.php" method="post">
                <input type="hidden" name="totaal" value="<?php echo $totaal; ?>">
                
                <h5 class="mb-3 border-bottom pb-2">Persoonlijke Gegevens</h5>
                
                <div class="mb-2">
                    <select name="Geslacht" class="form-control" required>
                        <option value="" disabled selected>Selecteer Geslacht</option>
                        <option value="M">Man</option>
                        <option value="V">Vrouw</option>
                        <option value="X">Anders</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <input type="text" name="Voornaam" class="form-control" placeholder="Voornaam" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="text" name="Achternaam" class="form-control" placeholder="Achternaam" required>
                    </div>
                </div>

                <div class="mb-2">
                    <input type="email" name="Email" class="form-control" placeholder="Email (wordt gebruikt voor controle)" required>
                </div>

                <div class="mb-2">
                    <input type="text" name="Telefoon" class="form-control" placeholder="GSM Nummer" required>
                </div>

                <h5 class="mb-3 mt-4 border-bottom pb-2">Adresgegevens</h5>

                <div class="row">
                    <div class="col-md-9 mb-2">
                        <input type="text" name="Straat" class="form-control" placeholder="Straatnaam" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" name="Huisnummer" class="form-control" placeholder="Nr." required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4 mb-2">
                        <input type="text" name="Postcode" class="form-control" placeholder="Postcode" required>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" name="Plaats" class="form-control" placeholder="Gemeente / Stad" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold">Land</label>
                    <input type="text" name="Land" class="form-control" placeholder="Bijv. België, Frankrijk..." required>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="voorwaarden" id="voorwaarden" required>
                    <label class="form-check-label" for="voorwaarden">
                        Ik ga akkoord met de <a href="#" target="_blank">algemene voorwaarden</a>
                    </label>
                </div>

                <button type="submit" name="plaatsen" class="btn btn-success btn-lg w-100 fw-bold">
                    <i class="fas fa-check me-2"></i> BESTELLING PLAATSEN
                </button>
            </form>
        </div>
    </div>
</section>
        </div>
    </div>
</section>

<?php require_once("inc/inc.shop_voet.php"); ?>

