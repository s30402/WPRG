<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pobranie danych z formularza
    $osoby              = isset($_POST['osoby'])                ?       (int) $_POST['osoby']                   : 0;
    $imie               = isset($_POST['imie'])                 ?       htmlspecialchars($_POST['imie'])        : '';
    $nazwisko           = isset($_POST['nazwisko'])             ?       htmlspecialchars($_POST['nazwisko'])    : '';
    $adres              = isset($_POST['adres'])                ?       htmlspecialchars($_POST['adres'])       : '';
    $email              = isset($_POST['email'])                ?       htmlspecialchars($_POST['email'])       : '';
    $karta              = isset($_POST['karta'])                ?       htmlspecialchars($_POST['karta'])       : '';
    $data_pobytu        = isset($_POST['data_pobytu'])          ?       $_POST['data_pobytu']                   : '';
    $godzina_przyjazdu  = isset($_POST['godzina_przyjazdu'])    ?       $_POST['godzina_przyjazdu']             : '';
    $lozko_dziecka      = isset($_POST['lozko_dziecka'])        ?       'Tak'                                   : 'Nie';
    $udogodnienia       = isset($_POST['udogodnienia'])         ?       $_POST['udogodnienia']                  : [];
    
    ?>
    <!DOCTYPE html>
    <html lang="pl">
    <head>
      <meta charset="UTF-8">
      <title>Podsumowanie rezerwacji</title>
      <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2, h3 { color: #333; }
        .data { margin-bottom: 15px; }
        .data strong { display: inline-block; width: 180px; }
      </style>
    </head>
    <body>
      <h2>Podsumowanie rezerwacji</h2>
      <div class="data">
        <strong>Ilość osób:</strong> <?php echo $osoby; ?>
      </div>
      
      <br>
      <h3>Dane osoby rezerwującej</h3>
      <div class="data">
        <strong>Imię:</strong> <?php echo $imie; ?>
      </div>
      <div class="data">
        <strong>Nazwisko:</strong> <?php echo $nazwisko; ?>
      </div>
      <div class="data">
        <strong>Adres:</strong> <?php echo $adres; ?>
      </div>
      <div class="data">
        <strong>E-mail:</strong> <?php echo $email; ?>
      </div>
      <div class="data">
        <strong>Dane karty:</strong> <?php echo $karta; ?>
      </div>
      
      <br>
      <h3>Dane pobytu</h3>
      <div class="data">
        <strong>Data pobytu:</strong> <?php echo $data_pobytu; ?>
      </div>
      <div class="data">
        <strong>Godzina przyjazdu:</strong> <?php echo $godzina_przyjazdu; ?>
      </div>
      <div class="data">
        <strong>Dodatkowe łóżko dla dziecka:</strong> <?php echo $lozko_dziecka; ?>
      </div>
      
      <h3>Udogodnienia</h3>
      <?php if (!empty($udogodnienia)): ?>
        <ul>
          <?php foreach($udogodnienia as $udogodnienie): ?>
            <li><?php echo htmlspecialchars($udogodnienie); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p>Brak wybranych udogodnień.</p>
      <?php endif; ?>
    </body>
    </html>
    <?php
} else {
    echo "Błąd: Formularz nie został wysłany metodą POST.";
}
?>
