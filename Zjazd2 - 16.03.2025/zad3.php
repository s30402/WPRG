<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Krok 1: Odbieramy dane z formularza rezerwacji
    if (!isset($_POST['step'])) {
        $osoby              = isset($_POST['osoby'])                ? (int) $_POST['osoby']                : 0;
        $imie               = isset($_POST['imie'])                 ? htmlspecialchars($_POST['imie'])     : '';
        $nazwisko           = isset($_POST['nazwisko'])             ? htmlspecialchars($_POST['nazwisko']) : '';
        $adres              = isset($_POST['adres'])                ? htmlspecialchars($_POST['adres'])    : '';
        $email              = isset($_POST['email'])                ? htmlspecialchars($_POST['email'])    : '';
        $karta              = isset($_POST['karta'])                ? htmlspecialchars($_POST['karta'])    : '';
        $data_pobytu        = isset($_POST['data_pobytu'])          ? $_POST['data_pobytu']                : '';
        $godzina_przyjazdu  = isset($_POST['godzina_przyjazdu'])    ? $_POST['godzina_przyjazdu']          : '';
        $lozko_dziecka      = isset($_POST['lozko_dziecka'])        ? 'Tak'                              : 'Nie';
        $udogodnienia       = isset($_POST['udogodnienia'])         ? $_POST['udogodnienia']               : [];

        if ($osoby == 1) {
            ?>
            <!DOCTYPE html>
            <html lang="pl">
            <head>
              <meta charset="UTF-8">
              <title>Podsumowanie rezerwacji</title>
              <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h2, h3 { color: #333; }
                .info { margin-bottom: 15px; }
                .info strong { display: inline-block; width: 180px; }
                ul { list-style-type: none; padding: 0; }
                li { margin-bottom: 5px; }
              </style>
            </head>
            <body>
              <h2>Podsumowanie rezerwacji</h2>
              <div class="info">
                <strong>Ilość osób:</strong> <?php echo $osoby; ?>
              </div>
              
              <h3>Dane osoby rezerwującej</h3>
              <div class="info">
                <strong>Imię:</strong> <?php echo $imie; ?>
              </div>
              <div class="info">
                <strong>Nazwisko:</strong> <?php echo $nazwisko; ?>
              </div>
              <div class="info">
                <strong>Adres:</strong> <?php echo $adres; ?>
              </div>
              <div class="info">
                <strong>E-mail:</strong> <?php echo $email; ?>
              </div>
              <div class="info">
                <strong>Dane karty:</strong> <?php echo $karta; ?>
              </div>
              
              <h3>Dane pobytu</h3>
              <div class="info">
                <strong>Data pobytu:</strong> <?php echo $data_pobytu; ?>
              </div>
              <div class="info">
                <strong>Godzina przyjazdu:</strong> <?php echo $godzina_przyjazdu; ?>
              </div>
              <div class="info">
                <strong>Dodatkowe łóżko dla dziecka:</strong> <?php echo $lozko_dziecka; ?>
              </div>
              
              <h3>Udogodnienia</h3>
              <?php if (!empty($udogodnienia)): ?>
                <ul>
                  <?php foreach($udogodnienia as $udo): ?>
                    <li><?php echo htmlspecialchars($udo); ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php else: ?>
                <p>Brak wybranych udogodnień.</p>
              <?php endif; ?>
              
            </body>
            </html>
            <?php
        } else {
            ?>
            <!DOCTYPE html>
            <html lang="pl">
            <head>
              <meta charset="UTF-8">
              <title>Dane osób</title>
              <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                fieldset { margin-bottom: 15px; }
                legend { font-weight: bold; }
              </style>
            </head>
            <body>
              <h2>Podaj dane poszczególnych osób</h2>
              <form action="zad3.php" method="post">
                <?php
                  echo '<input type="hidden" name="osoby" value="' . $osoby . '">';
                  echo '<input type="hidden" name="imie" value="' . $imie . '">';
                  echo '<input type="hidden" name="nazwisko" value="' . $nazwisko . '">';
                  echo '<input type="hidden" name="adres" value="' . $adres . '">';
                  echo '<input type="hidden" name="email" value="' . $email . '">';
                  echo '<input type="hidden" name="karta" value="' . $karta . '">';
                  echo '<input type="hidden" name="data_pobytu" value="' . $data_pobytu . '">';
                  echo '<input type="hidden" name="godzina_przyjazdu" value="' . $godzina_przyjazdu . '">';
                  echo '<input type="hidden" name="lozko_dziecka" value="' . $lozko_dziecka . '">';
                  if (!empty($udogodnienia)) {
                      foreach($udogodnienia as $udo) {
                          echo '<input type="hidden" name="udogodnienia[]" value="' . htmlspecialchars($udo) . '">';
                      }
                  }
                ?>
                <input type="hidden" name="step" value="osoby">
                <?php
                  for ($i = 1; $i <= ($osoby - 1); $i++) {
                      ?>
                      <fieldset>
                        <legend>Dane osoby <?php echo ($i+1); ?></legend>
                        <label for="imie_osoby_<?php echo $i; ?>">Imię:</label>
                        <input type="text" name="imie_osoby[]" id="imie_osoby_<?php echo $i; ?>" required>
                        <br><br>
                        <label for="nazwisko_osoby_<?php echo $i; ?>">Nazwisko:</label>
                        <input type="text" name="nazwisko_osoby[]" id="nazwisko_osoby_<?php echo $i; ?>" required>
                      </fieldset>
                      <?php
                  }
                ?>
                <button type="submit">Kontynuuj</button>
              </form>
            </body>
            </html>
            <?php
        }
    } elseif (isset($_POST['step']) && $_POST['step'] == 'osoby') {
        $osoby              = isset($_POST['osoby'])                ? (int) $_POST['osoby']                : 0;
        $imie               = isset($_POST['imie'])                 ? htmlspecialchars($_POST['imie'])     : '';
        $nazwisko           = isset($_POST['nazwisko'])             ? htmlspecialchars($_POST['nazwisko']) : '';
        $adres              = isset($_POST['adres'])                ? htmlspecialchars($_POST['adres'])    : '';
        $email              = isset($_POST['email'])                ? htmlspecialchars($_POST['email'])    : '';
        $karta              = isset($_POST['karta'])                ? htmlspecialchars($_POST['karta'])    : '';
        $data_pobytu        = isset($_POST['data_pobytu'])          ? $_POST['data_pobytu']                : '';
        $godzina_przyjazdu  = isset($_POST['godzina_przyjazdu'])    ? $_POST['godzina_przyjazdu']          : '';
        $lozko_dziecka      = isset($_POST['lozko_dziecka'])        ? 'Tak'                              : 'Nie';
        $udogodnienia       = isset($_POST['udogodnienia'])         ? $_POST['udogodnienia']               : [];
        
        $imie_osoby         = isset($_POST['imie_osoby'])           ? $_POST['imie_osoby']                 : [];
        $nazwisko_osoby     = isset($_POST['nazwisko_osoby'])       ? $_POST['nazwisko_osoby']             : [];
        ?>
        <!DOCTYPE html>
        <html lang="pl">
        <head>
          <meta charset="UTF-8">
          <title>Podsumowanie rezerwacji</title>
          <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            h2, h3 { color: #333; }
            .info { margin-bottom: 15px; }
            .info strong { display: inline-block; width: 180px; }
            ul { list-style-type: none; padding: 0; }
            li { margin-bottom: 5px; }
          </style>
        </head>
        <body>
          <h2>Podsumowanie rezerwacji</h2>
          <div class="info">
            <strong>Ilość osób:</strong> <?php echo $osoby; ?>
          </div>
          
          <h3>Dane osoby rezerwującej</h3>
          <div class="info">
            <strong>Imię:</strong> <?php echo $imie; ?>
          </div>
          <div class="info">
            <strong>Nazwisko:</strong> <?php echo $nazwisko; ?>
          </div>
          <div class="info">
            <strong>Adres:</strong> <?php echo $adres; ?>
          </div>
          <div class="info">
            <strong>E-mail:</strong> <?php echo $email; ?>
          </div>
          <div class="info">
            <strong>Dane karty:</strong> <?php echo $karta; ?>
          </div>
          
          <h3>Dane pobytu</h3>
          <div class="info">
            <strong>Data pobytu:</strong> <?php echo $data_pobytu; ?>
          </div>
          <div class="info">
            <strong>Godzina przyjazdu:</strong> <?php echo $godzina_przyjazdu; ?>
          </div>
          <div class="info">
            <strong>Dodatkowe łóżko dla dziecka:</strong> <?php echo $lozko_dziecka; ?>
          </div>
          
          <h3>Udogodnienia</h3>
          <?php if (!empty($udogodnienia)): ?>
            <ul>
              <?php foreach($udogodnienia as $udo): ?>
                <li><?php echo htmlspecialchars($udo); ?></li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p>Brak wybranych udogodnień.</p>
          <?php endif; ?>
          
          <h3>Dane osób</h3>
          <?php if (!empty($imie_osoby) && !empty($nazwisko_osoby)): ?>
            <ul>
              <?php for ($i = 0; $i < count($imie_osoby); $i++): ?>
                <li>
                  <strong>Osoba <?php echo ($i + 2); ?>:</strong>
                  <?php echo htmlspecialchars($imie_osoby[$i]) . " " . htmlspecialchars($nazwisko_osoby[$i]); ?>
                </li>
              <?php endfor; ?>
            </ul>
          <?php else: ?>
            <p>Brak danych dotyczących dodatkowych osób.</p>
          <?php endif; ?>
        </body>
        </html>
        <?php
    }
} else {
    echo "Błąd: Formularz nie został wysłany metodą POST.";
}
?>