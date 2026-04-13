<?php require_once("inc/inc.shop_Hoofd.php"); ?>

  <section class="shop-banner">
    <div class="content">
      <h1 class="display-4 fw-bold mb-3">DE BROCKY-SHOP</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Brocky</a></li>
          <li class="breadcrumb-item active" aria-current="page">Shop</li>
        </ol>
      </nav>
    </div>
  </section>

  <div class="container mt-5 mb-5">
    <div class="row">

      <aside class="col-lg-3 col-md-4 mb-4">
        <div class="sidebar-widget">
          <h5 class="widget-title">Categorieën</h5>
            <?php
            $sql = "select distinct Artikel_Type from tbl_artikel";
            $cmd = $link -> query($sql);
            $resultaat = $cmd -> fetchAll();

            foreach($resultaat as $data)
            {
            ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="<?php echo $data['Artikel_Type']; ?>" id="cat<?php echo $data['Artikel_Type']; ?>" checked>
              <label class="form-check-label" for="cat<?php echo $data['Artikel_Type']; ?>"><?php echo $data['Artikel_Type']; ?></label>
            </div>
            <?php
            }
            ?>
        </div>

        <div class="sidebar-widget">
          <h5 class="widget-title">Prijsklasse</h5>
          <div class="price-input-group">
            <span>€</span>
            <input type="number" placeholder="Min" id="priceMin">
            <span>-</span>
            <input type="number" placeholder="Max" id="priceMax">
          </div>
          <button class="filter-btn" onclick="filterProducts()">Filter Toepassen</button>
        </div>

        <div class="sidebar-widget">
          <h5 class="widget-title">Categorieën</h5>
          <div class="size-grid">
            <?php
            $sql = "select distinct Artikel_categorie from tbl_artikel";
            $cmd = $link -> query($sql);
            $resultaat = $cmd -> fetchAll();

            foreach($resultaat as $data)
            {
            ?>

            <div class="form-check">
              <input class="form-check-input" href="shop.php?categorie=<?php echo $data['Artikel_categorie']; ?> " type="checkbox" value="<?php echo $data['Artikel_categorie']; ?>" id="cat<?php echo $data['Artikel_categorie']; ?>" checked>
              <label class="form-check-label" for="cat<?php echo $data['Artikel_categorie']; ?>"><?php echo $data['Artikel_categorie']; ?></label>
            </div>

            <?php
            }
            ?>

          </div>
        </div>

        <div class="sidebar-widget text-center"
          style="background: var(--beige-sand); color: var(--dark-blue); padding: 30px; border-radius: 6px;">
          <h4 class="mb-3 fw-bold">Zomer Sale</h4>
          <p class="mb-3">Krijg tot 50% korting op geselecteerde modellen.</p>
          <button class="btn btn-dark w-100">Bekijk Aanbiedingen</button>
        </div>
      </aside>

      <div class="col-lg-9 col-md-8">

        <div class="sort-bar">
          <span class="text-muted">Toont 1-9 van 12 resultaten</span>
          <div class="d-flex align-items-center">
            <span class="me-2">Sorteer op:</span>

            <select class="form-select form-select-sm w-auto border-0 shadow-sm" style="background-color: white;">
              <option>Populariteit
                <?php
                $sql = "select distinct Artikel_Populair from tbl_artikel";
                $cmd = $link -> query($sql);
                $resultaat = $cmd -> fetchAll();
                foreach($resultaat as $data)
                {
                ?>
                <option value="<?php echo $data['Artikel_Populair']; ?>"><?php echo $data
                ['Artikel_Populair']; ?></option>
                <?php
                }
                ?>

              </option>
              <option>Prijs: Laag naar Hoog</option>
              <option>Prijs: Hoog naar Laag</option>

              <option>Nieuwste collectie
                  <?php
                  $sql = "select distinct Artikel_Nieuw from tbl_artikel";
                  $cmd = $link -> query($sql);
                  $resultaat = $cmd -> fetchAll();
                  foreach($resultaat as $data)
                  {
                  ?>
                  <option value="index.php"><?php echo $data['Artikel_Nieuw']; ?></option>
                  <?php
                  }
                  ?>
              </option>

            </select>
          </div>
        </div>

        <div class="row g-4" id="productGrid">


        <?php

          $sql = "select * from tbl_artikel";
          if(isset($_GET["keuze"]))
          {
              $sql .= " where type = '" . $_GET["keuze"] . "'";

          }  
          if(isset($_GET["pop"]))
          {
              $sql .= " where populair = '" . $_GET["pop"] . "'";

          }  
          if(isset($_GET["nieuw"]))
          {
              $sql .= " where nieuw = '" . $_GET["nieuw"] . "'" ;

          }                     
          
          $cmd = $link -> query($sql);
          $resultaat = $cmd -> fetchAll();


          
          foreach($resultaat as $data)
          {
            
          ?>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="product-card">
              <div class="card-img-wrapper">

                <img src="images/<?php echo $data['Artikel_Image']; ?>" alt="<?php echo $data['Artikel_Naam']; ?>">
                <div class="badge badge-new">Nieuw</div>
                <div class="card-overlay">
                  <a href="#" class="overlay-btn btn-add-cart"
                    onclick="addToCart('<?php echo $data['Artikel_Naam']; ?>', <?php echo $data['Artikel_Prijs']; ?>, '<?php echo $data['Artikel_Image']; ?>')">

                    <i class="fas fa-shopping-cart me-2"></i> In winkelwagen
                  </a>

                  <a href="detail.php?keuze=<?php echo $data['Artikel_Nummer']; ?>" class="overlay-btn btn-quick-view">
                      <i class="fas fa-eye me-2"></i> Snel bekijken
                  </a>

                  
                </div>
              </div>
              <div class="card-body">
                <div class="product-category"><?php echo $data['Artikel_Type']; ?></div>
                <a href="#" class="product-title"><?php echo $data['Artikel_Naam']; ?></a>
                <div class="product-price">€<?php echo number_format($data['Artikel_Prijs'], 2, ',', '.'); ?></div>
              </div>
            </div>
          </div>

          <?php
          }
          ?>          

        </div> <nav class="mt-5" aria-label="Page navigation">
          <ul class="pagination justify-content-center">
            <li class="page-item disabled"><a class="page-link text-dark" href="#">Vorige</a></li>
            <li class="page-item active"><a class="page-link bg-beige text-dark border-0" href="#">1</a></li>
            <li class="page-item"><a class="page-link text-dark" href="#">2</a></li>
            <li class="page-item"><a class="page-link text-dark" href="#">3</a></li>
            <li class="page-item"><a class="page-link text-dark" href="#">Volgende</a></li>
          </ul>
        </nav>

      </div> </div>
  </div>

  <section class="container mb-5">
    <div class="cart-header d-flex justify-content-between align-items-center">
      <span>Winkelwagen</span>
      <span id="cartCountBadge" class="badge bg-dark text-light px-3 py-2 rounded-pill">0 Items</span>
    </div>

    <div class="row mt-3">
      <div class="col-md-8">
        <div class="table-responsive" id="cartTableContainer">
          <table class="table table-borderless">
            <thead>
              <tr>
                <th scope="col" class="text-muted" style="width: 20%;">Product</th>
                <th scope="col" class="text-muted">Prijs</th>
                <th scope="col" class="text-muted">Aantal</th>
                <th scope="col" class="text-muted">Totaal</th>
                <th scope="col" class="text-muted text-end" style="width: 10%;">Verwijderen</th>
              </tr>
            </thead>
            <tbody id="cartItemsBody">
              <tr>
                <td colspan="5" class="text-center text-muted py-5">
                  <i class="fas fa-shopping-cart fa-3x mb-3 opacity-50"></i>
                  <p class="mb-0">Je winkelwagen is momenteel leeg.</p>
                  <a href="#" class="btn btn-outline-dark mt-2">Begin met winkelen</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="col-md-4">
        <div class="cart-totals">
          <h5 class="fw-bold mb-4">Winkelmand Totaal</h5>
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Subtotaal</span>
            <span class="fw-bold" id="cartSubtotal">€0,00</span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Verzending</span>
            <span class="fw-bold">Gratis</span>
          </div>
          <div class="d-flex justify-content-between mb-4 border-top pt-3">
            <span class="fw-bold fs-5">Totaal</span>
            <span class="fw-bold fs-5" id="cartTotal">€0,00</span>
          </div>
          <button class="btn btn-checkout" onclick="alert('Doorgaan naar afrekenen...')">
            Doorgaan naar afrekenen
          </button>
          <div class="text-center mt-3">
            <a href="#" class="text-decoration-underline small text-muted">Verder winkelen</a>
          </div>
        </div>
      </div>
    </div>
  </section>


  <div class="modal fade modal-shop" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body p-4 p-md-5">
          <div class="row">
            <div class="col-md-6">
              <div class="product-detail-img">
                <img src="" id="modalProductImage" class="img-fluid w-100 rounded" alt="Product Detail">
              </div>
              <div class="d-flex justify-content-center mt-3">
                <button class="btn btn-light me-2"><i class="fas fa-arrows-alt"></i></button>
                <button class="btn btn-light"><i class="fas fa-share-alt"></i></button>
              </div>
            </div>

            <div class="col-md-6 ps-md-4">
              <div class="mb-2">
                <span class="badge bg-beige text-dark" id="modalCategory">Categorie</span>
              </div>

              
              <h2 class="fw-bold mb-2" id="modalTitle">Product Titel</h2>

              <div class="rating mb-3">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <span class="text-muted ms-2">(12 Beoordelingen)</span>
              </div>

              <h3 class="text-dark fw-bold mb-4" id="modalPrice">€0,00</h3>

              <p class="text-muted mb-4" style="line-height: 1.6;">
                Ervaar ultiem comfort en stijl met deze premium editie schoenen.
                Ontworpen voor duurzaamheid en een moderne esthetiek, perfect voor dagelijks gebruik of sportieve activiteiten.
              </p>

              <p id="modalDescription" class="text-muted mb-4" style="line-height: 1.6;">

              </p>

              <p class="text-muted mb-4" style="line-height: 1.6;">


              </p>

              <h6 class="fw-bold text-uppercase mb-2 small">Selecteer Maat</h6>
              <div class="size-selector" id="modalSizeSelector">
                <div class="size-opt active" onclick="selectModalSize(this)">39</div>
                <div class="size-opt" onclick="selectModalSize(this)">40</div>
                <div class="size-opt" onclick="selectModalSize(this)">41</div>
                <div class="size-opt" onclick="selectModalSize(this)">42</div>
                <div class="size-opt" onclick="selectModalSize(this)">43</div>
                <div class="size-opt" onclick="selectModalSize(this)">44</div>
              </div>

              <div class="d-flex align-items-center mt-4 mb-4">
                <h6 class="fw-bold text-uppercase me-3 mb-0 small">Aantal:</h6>
                <div class="qty-control">
                  <button class="qty-btn" onclick="updateModalQty(-1)">-</button>
                  <input type="number" class="qty-input" id="modalQty" value="1" min="1" readonly>
                  <button class="qty-btn" onclick="updateModalQty(1)">+</button>
                </div>
              </div>

              <button class="btn btn-add-cart-modal" onclick="addToCartFromModal()">
                <i class="fas fa-shopping-cart me-2"></i> Voeg toe aan winkelwagen
              </button>

              <div class="mt-4">
                <h6 class="fw-bold mb-2">Garantie</h6>
                <p class="small text-muted mb-1"><i class="fas fa-check text-success me-2"></i> 14 dagen retourrecht</p>
                <p class="small text-muted mb-1"><i class="fas fa-check text-success me-2"></i> Veilige betaling</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php require_once("inc/inc.shop_voet.php"); ?>





