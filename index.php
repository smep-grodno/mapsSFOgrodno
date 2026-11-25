<?php
$db_host='localhost';
$db_name='o29369h1_grodno';
$db_user='o29369h1_grodno';
$db_pass='Belusha49';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($mysqli->connect_error) {
  printf("Соединение не удалось: %s\n", $mysqli->connect_error);
  exit();
}
$tables = [
  'sfo_Bberestovitsa', 'sfo_dyatlovo', 'sfo_grodno', 'sfo_lida',
  'sfo_mosty', 'sfo_novogrudoc', 'sfo_oshmany', 'sfo_ostrovets',
  'sfo_pogranichny', 'sfo_shuchin', 'sfo_skidel', 'sfo_slonim',
  'sfo_smorgon', 'sfo_svisloch', 'sfo_volkovysk'
];
$selected_city = isset($_POST['selected_city']) ? $_POST['selected_city'] : 'sfo_grodno';
if (!in_array($selected_city, $tables)) {
  $selected_city = 'sfo_grodno';
}
$time_from = isset($_POST['time_from']) ? $_POST['time_from'] : null;
$time_to = isset($_POST['time_to']) ? $_POST['time_to'] : null;

$usk_filter = isset($_POST['usk_filter']) ? true : false;
$usk_status = isset($_POST['usk_status']) ? $_POST['usk_status'] : '';

$all_data = [];
$res_all = $mysqli->query("SELECT * FROM `$selected_city`");
while($row = $res_all->fetch_assoc()){
  $all_data[] = $row;
}
$result = $mysqli->query("SELECT * FROM `$selected_city`");

$filtered_data = [];
if(isset($_POST['start']) && $time_from && $time_to){
  $stmt = $mysqli->prepare("SELECT * FROM `$selected_city` WHERE time_from = ? AND time_to = ?");
  $stmt->bind_param("ss", $time_from, $time_to);
  $stmt->execute();
  $res = $stmt->get_result();
  while($row = $res->fetch_assoc()){
    $filtered_data[] = $row;
  }
  $stmt->close();
}

// УСК выборка и загрузка
$usk_all_data = [];
$usk_filtered_data = [];
if ($usk_filter) {
  $query = "SELECT * FROM `usk_grodno`";
  if ($usk_status !== '') {
    $stmtU = $mysqli->prepare($query . " WHERE note = ?");
    $stmtU->bind_param("s", $usk_status);
  } else {
    $stmtU = $mysqli->prepare($query);
  }
  $stmtU->execute();
  $resU = $stmtU->get_result();
  while ($row = $resU->fetch_assoc()) {
    $usk_filtered_data[] = $row;
  }
  $stmtU->close();
} else {
  $resU_all = $mysqli->query("SELECT * FROM `usk_grodno`");
  while ($row = $resU_all->fetch_assoc()) {
    $usk_all_data[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="UTF-8" />
<link rel="icon" href="Logo.png" type="image/png" />
<title>СО и УСК г. Гродно</title>
<style>
  html, body {
    margin: 0; padding: 0; height: 100%; width: 100%;
    font-family: Arial, sans-serif;
    box-sizing: border-box;
    background: #f9fbfd;
    overflow: hidden;
  }
@media (max-width: 600px) {
  #right-panel {
    width: 200% !important;
    margin-left: 600px !important;
    height: auto !important;
    flex-direction: column;
  }

  #map {
    height: 500px !important;
    width: 100% !important;
  }
    body {
  background-image: url('Log2.png');
  background-size: 18% 40%;
  background-repeat: no-repeat;
  background-position: 630px 5px;
}

  .table-container {
    max-height: 200px !important;
    overflow-x: auto !important;
    width: 100% !important;
  }
}
  body {
    padding: 20px;
    display: flex;
    height: 100vh;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    width: 100%;
  }
  body {
  background-image: url('Log2.png');
  background-size: auto;
  background-repeat: no-repeat;
  background-position: 510px 90px;
  background-attachment: fixed;
}
.scroll-container {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  width: 100%;
}
.scroll-container table {
  min-width: 900px;
}

  .sidebar {
    width: 350px;
  }
  .search-block {
    max-width: 600px;
     width: 250px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 20px rgba(0,50,100,0.1);
    padding: 20px;
    margin-bottom: 15px;
    font-size: 14px;
    color: #334466;
  }
  .search-block h4 {
    margin-top: 0;
    margin-bottom: 15px;
  }
  .search-block label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #213f7d;
    font-size: 14px;
  }
  .search-block select,
  .search-block input[type="time"] {
    width: 100%;
    padding: 8px 0px;
    border-radius: 8px;
    border: 1.5px solid #d1d9e6;
    margin-bottom: 15px;
    font-size: 14px;
    background: #fff;
    transition: border-color 0.3s ease;
  }
  .search-block select:focus,
  .search-block input[type="time"]:focus {
    border-color: #2f80ed;
    outline: none;
    box-shadow: 0 0 6px #2f80ed;
  }
  .search-block button,
  .search-block input[type="submit"] {
    width: 100%;
    padding: 12px;
    font-weight: bold;
    font-size: 16px;
    color: #fff;
    border: none;
    border-radius: 10px;
    background: linear-gradient(45deg, #ff00bb, #12ee99);
    cursor: pointer;
    box-shadow: 0 4px 10px #2f80ed80;
    transition: background 0.3s ease;
  }
  .search-block button:hover,
  .search-block input[type="submit"]:hover {
    background: linear-gradient(45deg, #56ccf2, #2f80ed);
  }
  .selection-results-block {
    max-width: 900px;
    margin-top: 15px;
    padding: 15px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 20px rgba(0,50,100,0.1);
    font-size: 14px;
    color: #334466;
    width: 850px;
    max-height: 400px;
    overflow-y: auto;
    overflow-x: auto;
  }
  .selection-results-block table {
    border-collapse: collapse;
    table-layout: fixed;
    min-width: 850px;
  }
  .selection-results-block th,
  .selection-results-block td {
    border: 1px solid #adc1e1;
    padding: 8px 10px;
    text-align: center;
    box-sizing: border-box;
  }
  .selection-results-block th {
    background-color: #99f999;
  }
  .selection-results-block th:nth-child(1),
  .selection-results-block td:nth-child(1) {
    width: 50px;
  }
  .selection-results-block th:nth-child(2),
  .selection-results-block td:nth-child(2) {
    width: 300px;
  }
  .selection-results-block th:nth-child(3),
  .selection-results-block td:nth-child(3) {
    width: 300px;
  }
  .selection-results-block th:nth-child(4),
  .selection-results-block td:nth-child(4) {
    width: 200px;
  }
  #right-panel {
    width: calc(100% - 350px);
    display: flex;
    flex-direction: column;
    border: 1px solid #ccc;
    box-sizing: border-box;
    margin-left: 600px;
    height: 95vh;
    background: white;
    border-radius: 6px;
    justify-content: space-between;
  }
  #map {
    height: 100%;
    border: none;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
  }
  .table-container {
    height: 100%;
    overflow-y: auto;
    padding: 1px;
    border-top: 1px solid #ccc;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
  }
  .table-container table {
    width: 100%;
    border-collapse: collapse;
  }
  .table-container th, .table-container td {
    border: 1px solid #999;
    padding: 6px;
    font-size: 14px;
    text-align: center;
  }
 .top-bar-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
  }
  .usk-filter-block {
    background: #fff;
    box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    border-radius: 12px;
    padding: 16px;
    min-width: 280px;
    max-width: 320px;
  }
  .usk-filter-block label {
    font-weight: 600;
    font-size: 14px;
    color: #213f7d;
    display: block;
    margin-bottom: 8px;
  }
  .usk-filter-block select {
    width: 100%;
    padding: 8px;
    border-radius: 8px;
    border: 1.5px solid #d1d9e6;
    margin-bottom: 12px;
    background: #fff;
    font-size: 14px;
  }
  .usk-filter-block input[type="submit"] {
    width: 100%;
    padding: 12px;
    font-weight: bold;
    font-size: 16px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(45deg, #ff00bb, #12ee99);
    color: white;
    cursor: pointer;
    box-shadow: 0 4px 10px #2f80ed80;
    transition: background 0.3s ease;
  }
  .usk-filter-block input[type="submit"]:hover {
    background: linear-gradient(45deg, #56ccf2, #2f80ed);
  }
  thead th {
    background-color: #99f999;
    color: black;
    font-weight: bold;
    background: linear-gradient(1deg, #99f999, #fff);
  }
</style>
</head>
<body>
<div class="sidebar" style="display: flex; flex-direction: column; max-width: 850px;">

  <div style="display: flex; gap: 20px; margin-bottom: 15px;">

    <div style="width: 320px;">
      <div class="search-block">
        <form action="index_all.php" target="_blank" method="get">
          <label><button type="submit">Все метки</button></label>
        </form>
        <form action="" method="post">
          <label for="selected_city">Выберите город:</label>
          <select name="selected_city" id="selected_city" required>
            <?php foreach ($tables as $table):
              $sel = ($table === $selected_city) ? 'selected' : '';
            ?>
            <option value="<?= $table ?>" <?= $sel ?>><?= $table ?></option>
            <?php endforeach; ?>
          </select>
          <label for="time_from">Введите время включения СО:</label>
          <input type="time" step="1" name="time_from" id="time_from" value="<?= htmlspecialchars($time_from) ?>" />
          <label for="time_to">Введите время отключения СО:</label>
          <input type="time" step="1" name="time_to" id="time_to" value="<?= htmlspecialchars($time_to) ?>" />
          <input type="submit" value="Поиск по БД" name="start" />
        </form>
      </div>
    </div>

    <div style="width: 320px;">
      <div class="usk-filter-block">
        <form action="" method="post" style="margin-top: 0;">
          <input type="hidden" name="usk_filter" value="1" />
          <label for="usk_status">Фильтр УСК по статусу:</label>
          <select name="usk_status" id="usk_status" style="width: 100%; margin-bottom: 10px;">
            <option value="" <?= ($usk_status === '') ? 'selected' : '' ?>>Все</option>
            <option value="Работает с программой" <?= ($usk_status === 'Работает с программой') ? 'selected' : '' ?>>Работает с программой</option>
            <option value="Работает без программы" <?= ($usk_status === 'Работает без программы') ? 'selected' : '' ?>>Работает без программы</option>
            <option value="Не работает" <?= ($usk_status === 'Не работает') ? 'selected' : '' ?>>Не работает</option>
          </select>
          <input type="submit" value="Поиск по БД УСК" />
        </form>
      </div>
    </div>

  </div>

  <?php if (count($filtered_data) > 0): ?>
  <div class="search-block selection-results-block" style="overflow-x: auto; max-height: 400px;">
    <h4>Результаты выборки СО:</h4>
    <div>
      <table>
        <thead>
          <tr>
            <th>№</th><th>Наименование СО</th><th>Программы</th><th>Связь</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($filtered_data as $row): ?>
            <tr>
              <td><?= htmlspecialchars($row['id']) ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['info']) ?></td>
              <td><?= htmlspecialchars($row['connection']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>

  <?php if ($usk_filter && count($usk_filtered_data) > 0): ?>
  <div class="search-block selection-results-block">
    <h4>Результаты выборки УСК:</h4>
    <div>
      <table>
        <thead>
          <tr>
            <th>№</th><th>Наименование УСК</th><th>Статус</th><th>Направление</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($usk_filtered_data as $row): ?>
            <tr>
              <td><?= htmlspecialchars($row['id']) ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['note']) ?></td>
              <td><?= htmlspecialchars($row['direction']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>

</div>

<div id="right-panel">
  <div id="map"></div>
  <div class="table-container">
    <h3>Все данные по городу <?= $selected_city ?></h3>
    <table>
      <thead>
        <tr>
          <th>№</th><th>Наименование СО</th><th>Режим работы</th><th>Время включения СО</th>
          <th>Время отключения СО</th><th>Программы</th><th>Связь</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['status']) ?></td>
          <td><?= htmlspecialchars($row['time_from']) ?></td>
          <td><?= htmlspecialchars($row['time_to']) ?></td>
          <td><?= htmlspecialchars($row['info']) ?></td>
          <td><?= htmlspecialchars($row['connection']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru-RU"></script>
<script>
document.oncontextmenu = function () { return false; };
ymaps.ready(function () {
  var myMap = new ymaps.Map("map", {
    center: [53.677839, 23.829529],
    zoom: 12,
    controls: ["zoomControl", "rulerControl", "trafficControl", "typeSelector", "fullscreenControl"]
  });
  var myCollection = new ymaps.GeoObjectCollection();
  var uskFilterActive = <?= $usk_filter ? 'true' : 'false' ?>;
  if (uskFilterActive) {
    var uskData = <?= json_encode(count($usk_filtered_data) ? $usk_filtered_data : $usk_all_data, JSON_UNESCAPED_UNICODE) ?>;
    for (var i = 0; i < uskData.length; i++) {
      if (!uskData[i].point) continue;
      var coords = uskData[i].point.split(',').map(parseFloat);
      var rotation = (uskData[i].angle) ? parseFloat(uskData[i].angle) : 0;
      var placemark = new ymaps.Placemark(coords, {
        balloonContent: "Указатель скорости № " + uskData[i].id + ":<br><b>" + uskData[i].name + "</b><br><u>" +
              "Статус указателя:</u> " + (uskData[i].note || "") + "<br>" +
              "Направление: " + (uskData[i].direction || ""),
        iconContent: uskData[i].id,
        color: uskData[i].color || 'red'
      }, {
        iconLayout: "default#imageWithContent",
        iconImageHref: "",
        iconImageSize: [20, 20],
        iconImageOffset: [-10, -10],
        iconContentLayout: ymaps.templateLayoutFactory.createClass(
          '<div style="width: 30px; height: 20px; background-color: white; border: 2px solid $[properties.color]; text-align: center; line-height: 20px; font-size: 11px; border-radius: 6px; color: black; font-weight: normal; transform: rotate(' + rotation + 'deg); transform-origin: center center;">$[properties.iconContent]</div>'
        ),
        hideIconOnBalloonOpen: false,
      });
      myCollection.add(placemark);
    }
  } else {
    var soData = <?= json_encode(count($filtered_data) ? $filtered_data : $all_data, JSON_UNESCAPED_UNICODE) ?>;
    for (var j = 0; j < soData.length; j++) {
      if (!soData[j].point) continue;
      var coords = soData[j].point.split(',').map(parseFloat);

      // --- фильтр: не создаём метки розового цвета #ff00bb ---
      var color = (soData[j].color || 'blue').toLowerCase();
      if (color === '#ff00bb') {
        continue;
      }
      // -------------------------------------------------------

      var placemark = new ymaps.Placemark(coords, {
        balloonContent: "СФО № " + soData[j].id + ":<br><b>" + soData[j].name + "</b><br><u>Режим работы:</u> " +
                        soData[j].status + "<br>" + soData[j].info + "<br>" + soData[j].connection,
        iconContent: "<small>" + soData[j].id + "</small>"
      }, {
        preset: "islands#circleIcon",
        hideIconOnBalloonOpen: false,
        iconColor: color
      });
      myCollection.add(placemark);
    }
  }
  myMap.geoObjects.add(myCollection);
  if (myCollection.getLength() > 0) {
    myMap.setBounds(myCollection.getBounds(), {
      checkZoomRange: true,
      zoomMargin: 9
    });
  }
  myMap.enableRuler();
});
</script>
</body>
</html>
