<?php 
    require_once("inc/inc.shop_Hoofd.php"); 

    if(!isset($_GET['keuze'])) {
        header("location:Shop.php");
        exit();
    }

    $keuze = $_GET['keuze'];
    $sql = "SELECT * FROM tbl_artikel WHERE Artikel_Nummer = $keuze";
    $cmd = $link->query($sql);
    $resultaat = $cmd->fetch(); 

// --- AJOUT AU PANIER AVEC VÉRIFICATION DE DOUBLON ---
    if(isset($_POST['toevoegen'])) {
        $artNr  = $_POST['Artikel_Nummer'];
        $aantal = (int)$_POST['aantal'];
        $kleur  = isset($_POST['kleur']) ? $_POST['kleur'] : 'Standaard';
        $maat   = isset($_POST['maten']) ? $_POST['maten'] : 'Standaard';

        $bestaatAl = false;

        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $item) {
                // On vérifie si les clés existent AVANT de comparer
                if (isset($item['Artikel_Nummer'], $item['kleur'], $item['maat'])) {
                    if ($item['Artikel_Nummer'] == $artNr && $item['kleur'] == $kleur && $item['maat'] == $maat) {
                        $_SESSION['cart'][$key]['aantal'] += $aantal;
                        $bestaatAl = true;
                        break;
                    }
                }
            }
        }

        if (!$bestaatAl) {
            $_SESSION['cart'][] = array(
                'Artikel_Nummer' => $artNr,
                'aantal' => $aantal,
                'kleur' => $kleur,
                'maat' => $maat
            );
        }
        
        header("location:winkelkar.php");
        exit();
    }
?>

<section class="py-5" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <img class="card-img-top mb-5 mb-md-0 rounded shadow" src="images/<?php echo $resultaat['Artikel_Image']; ?>" alt="<?php echo $resultaat['Artikel_Naam']; ?>" />
            </div>
        
            <div class="col-md-6">
                <div class="small mb-1">Art-Nr : <?php echo $resultaat['Artikel_Nummer']; ?></div>
                <h1 class="display-5 fw-bolder"><?php echo $resultaat['Artikel_Naam']; ?></h1>

                <div class="rating mb-3">
                    <?php
                    foreach(range(1, 5) as $i) {
                        if($i <= floor($resultaat['Artikel_Beoordeling'])) {
                            echo '<i class="fas fa-star"></i>';
                        } elseif($i - 0.5 == $resultaat['Artikel_Beoordeling']) {
                            echo '<i class="fas fa-star-half-alt"></i>';
                        } else {
                            echo '<i class="far fa-star"></i>';
                        }
                    }
                    ?>
                </div>        
                
                <div class="fs-5 mb-5 mt-3 fw-bold text-primary">
                    <span>€ <?php echo number_format($resultaat['Artikel_Prijs'], 2, ',', ' '); ?></span>
                </div>   
                <p class="lead"><?php echo $resultaat['Artikel_Omschrijving']; ?></p>

                <form action="detail.php?keuze=<?php echo $keuze; ?>" method="post">
                    <input type="hidden" name="Artikel_Nummer" value="<?php echo $resultaat['Artikel_Nummer']; ?>">


                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase small mb-2">Kleur:</h6>
                        <div class="d-flex gap-2" style="flex-wrap: wrap; display: flex;">
                            <?php 
                            // On ne récupère que les couleurs de l'article actuel ($keuze)
                            $sql_kleuren = "SELECT DISTINCT Artikel_Kleur FROM tbl_artikel WHERE Artikel_Nummer = ? AND Artikel_Kleur IS NOT NULL";
                            $cmd_kleuren = $link->prepare($sql_kleuren);
                            $cmd_kleuren->execute([$keuze]);
                            $kleuren = $cmd_kleuren->fetchAll();
                            ?>

                            <?php foreach($kleuren as $kleur): ?>
                                <label style="cursor: pointer;">
                                    <div style="width: 60px; border: 1px solid #ccc; border-radius: 8px; padding: 5px; text-align: center; background-color: <?php echo $kleur['Artikel_Kleur']; ?>;">
                                        <input type="radio" name="kleur" value="<?php echo $kleur['Artikel_Kleur']; ?>" required>
                                        <p style="color: black; background-color: rgba(255,255,255,0.7); margin: 5px 0 0 0; font-size: 11px; font-weight: bold; border-radius: 3px; text-transform: capitalize;">
                                            <?php echo $kleur['Artikel_Kleur']; ?>
                                        </p>
                                    </div>
                                </label>
                            <?php endforeach; 
                            ?>
                        </div>
                    </div>                      

                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase small mb-2">Maat:</h6>
                        <div class="d-flex gap-2" style="display: flex; flex-wrap: wrap; gap: 8px;">
                            <?php 
                            // On ne récupère que les tailles de l'article actuel ($keuze)
                            $sql_maten = "SELECT DISTINCT Artikel_maten FROM tbl_artikel WHERE Artikel_Nummer = ? AND Artikel_maten IS NOT NULL";
                            $cmd_maten = $link->prepare($sql_maten);
                            $cmd_maten->execute([$keuze]);
                            $maten = $cmd_maten->fetchAll();
                            ?>

                            <?php foreach($maten as $data_maat): ?>
                                <label style="cursor: pointer;">
                                    <div style="width: 50px; border: 1px solid #ccc; border-radius: 8px; padding: 8px; text-align: center; background-color: lightgray;">
                                        <input type="radio" name="maten" value="<?php echo $data_maat['Artikel_maten']; ?>" required> 
                                        <p style="color: black; margin-top: 5px; margin-bottom: 0; font-weight: bold;">
                                            <?php echo $data_maat['Artikel_maten']; ?>
                                        </p> 
                                    </div>
                                </label>
                            <?php endforeach; ?>
                            
                        </div>
                    </div>    
                    
                    




                    <hr>

                    <div class="d-flex align-items-center mt-4 mb-4">
                        <h6 class="fw-bold text-uppercase me-3 mb-0 small">Aantal:</h6>
                        <div class="input-group" style="width: 140px; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                            <button class="btn btn-light border-0 px-3" type="button" onclick="document.getElementById('inputQuantity').stepDown()" style="background: #f8f9fa;">-</button>
                            <input class="form-control text-center border-0 fw-bold" id="inputQuantity" type="number" name="aantal" value="1" min="1" style="background: #f8f9fa; pointer-events: none;" />
                            <button class="btn btn-light border-0 px-3" type="button" onclick="document.getElementById('inputQuantity').stepUp()" style="background: #f8f9fa;">+</button>
                        </div>
                    </div>

                    <button class="btn btn-dark btn-lg w-100 mb-4 fw-bold text-uppercase" type="submit" name="toevoegen" style="border-radius: 10px; padding: 16px; letter-spacing: 1px; transition: all 0.3s ease;">
                        <i class="fas fa-shopping-cart me-2"></i> Voeg toe aan winkelwagen
                    </button>
                </form>

                <div class="mt-4 p-4 rounded" style="background-color: #f8f9fa; border-left: 4px solid #212529;">
                    <h6 class="fw-bold mb-3 text-uppercase" style="letter-spacing: 0.5px;">Garantie</h6>
                    <p class="small text-muted mb-2 d-flex align-items-center">
                        <i class="fas fa-check-circle text-success me-2" style="font-size: 1.1rem;"></i> 14 dagen retourrecht
                    </p>
                    <p class="small text-muted mb-0 d-flex align-items-center">
                        <i class="fas fa-check-circle text-success me-2" style="font-size: 1.1rem;"></i> Veilige betaling
                    </p>
                </div>

            </div>       
                
            <div class="mt-4">
                <a href="Shop.php" class="text-decoration-underline text-muted"><i class="fas fa-arrow-left me-2"></i>Terug naar de shop</a>
            </div>

        </div>
            
    </div>
</section>

<?php require_once("inc/inc.shop_voet.php"); ?>