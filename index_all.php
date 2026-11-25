<!DOCTYPE html>
<html lang="ru">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="UTF-8" />
<link rel="icon" href="Logo.png" type="image/png" />
<title>Все метки</title>
<link rel="stylesheet" href="index_all.css" />
<style>
/* Полноэкранная карта */
html, body {
margin: 0;
padding: 0;
width: 100%;
height: 100%;
overflow: hidden;
}
#map {
width: 100%;
height: 100%;
position: fixed;
top: 0;
left: 0;
z-index: 0;
}
/* Панель с чекбоксами */
#toggleContainer {
position: fixed;
top: 15px;
left: 15px;
z-index: 1000;
background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
padding: 12px 14px;
border-radius: 10px;
font-size: 14px;
user-select: none;
box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12),
0 2px 6px rgba(0, 0, 0, 0.08),
inset 0 1px 0 rgba(255, 255, 255, 0.6);
backdrop-filter: blur(10px);
border: 1px solid rgba(255, 255, 255, 0.8);
min-width: 200px;
max-width: 240px;
transition: all 0.3s ease;
}

#toggleContainer:hover {
box-shadow: 0 8px 28px rgba(0, 0, 0, 0.15),
0 3px 10px rgba(0, 0, 0, 0.1);
transform: translateY(-2px);
}
.filter-block {
margin-bottom: 10px;
padding-bottom: 10px;
border-bottom: 1px solid #e9ecef;
}
.filter-block:last-child {
margin-bottom: 0;
padding-bottom: 0;
border-bottom: none;
}
.filter-title {
cursor: pointer;
user-select: none;
display: flex;
align-items: center;
justify-content: space-between;
padding: 6px 8px;
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
color: white;
border-radius: 6px;
font-weight: 600;
font-size: 10px;
text-transform: uppercase;
letter-spacing: 0.5px;
box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
transition: all 0.3s ease;
margin-bottom: 8px;
}
.filter-title:hover {
transform: translateY(-2px);
box-shadow: 0 5px 14px rgba(102, 126, 234, 0.4);
background: linear-gradient(135deg, #5568d3 0%, #65408b 100%);
}
.filter-title::after {
content: '▼';
font-size: 10px;
transition: transform 0.3s ease;
opacity: 0.8;
}

#statsTitle::after {
    display: none;
}

.filter-content {
display: none;
animation: slideDown 0.3s ease;
}
.filter-content.show {
display: block;
}
@keyframes slideDown {
from {
opacity: 0;
transform: translateY(-10px);
}
to {
opacity: 1;
transform: translateY(0);
}
}
.custom-checkbox {
display: flex;
align-items: center;
cursor: pointer;
user-select: none;
margin-bottom: 6px;
padding: 5px 8px;
border-radius: 6px;
transition: all 0.2s ease;
background: rgba(255, 255, 255, 0.6);
}
.custom-checkbox:last-child {
margin-bottom: 0;
}
.custom-checkbox:hover {
background: rgba(255, 255, 255, 0.9);
transform: translateX(4px);
box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}
.custom-checkbox input[type="checkbox"] {
margin: 0 8px 0 0;
width: 14px;
height: 14px;
cursor: pointer;
accent-color: #667eea;
flex-shrink: 0;
}
.custom-checkbox input[type="checkbox"] {
appearance: none;
-webkit-appearance: none;
background: white;
border: 2px solid #d1d5db;
border-radius: 4px;
position: relative;
transition: all 0.2s ease;
}
.custom-checkbox input[type="checkbox"]:checked {
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
border-color: #667eea;
}
.custom-checkbox input[type="checkbox"]:checked::after {
content: '✓';
position: absolute;
color: white;
font-size: 10px;
font-weight: bold;
top: 50%;
left: 50%;
transform: translate(-50%, -50%);
}
.icon-circle, .icon-square {
width: 12px;
height: 12px;
box-sizing: border-box;
border: 2px solid;
margin-right: 8px;
flex-shrink: 0;
border-radius: 50%;
box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.icon-circle {
border-radius: 50%;
}
.icon-square {
border-radius: 4px;
}
.coord-label {
display: flex;
align-items: center;
cursor: pointer;
padding: 5px 8px;
border-radius: 6px;
transition: all 0.2s ease;
background: rgba(255, 255, 255, 0.6);
}
.coord-label:hover {
background: rgba(255, 255, 255, 0.9);
transform: translateX(4px);
}
.ku-line {
width: 18px;
height: 3px;
background: linear-gradient(90deg, #10b981, #059669);
margin-right: 8px;
border-radius: 2px;
box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
}
.tooltip {
position: absolute;
background: rgba(255, 255, 255, 0.98);
border: 1px solid rgba(229, 231, 235, 0.8);
padding: 10px 12px;
border-radius: 8px;
box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15),
0 3px 10px rgba(0, 0, 0, 0.1);
white-space: nowrap;
display: none;
z-index: 10000;
font-size: 13px;
user-select: none;
backdrop-filter: blur(10px);
min-width: 160px;
animation: fadeInScale 0.25s ease;
}
.tooltip.show {
display: block;
}
@keyframes fadeInScale {
from {
opacity: 0;
transform: scale(0.9) translateY(-10px);
}
100% {
opacity: 1;
transform: scale(1) translateY(0);
}
}
#tooltipAll {
top: 45px !important;
left: 0 !important;
right: auto !important;
margin-left: 0;
}
#tooltipCircle {
top: 100px !important;
left: 0 !important;
right: auto !important;
margin-left: 0;
}
#tooltipSquare {
top: 180px !important;
left: 0 !important;
right: auto !important;
margin-left: 0;
}
@media (max-width: 600px) {
#toggleContainer {
top: 8px;
left: 8px;
min-width: 160px;
max-width: calc(100% - 16px);
padding: 10px 12px;
border-radius: 8px;
font-size: 10px;
}
.filter-title {
font-size: 9px;
padding: 5px 7px;
margin-bottom: 6px;
}
.custom-checkbox {
padding: 4px 6px;
margin-bottom: 4px;
font-size: 10px;
}
.custom-checkbox input[type="checkbox"] {
width: 12px;
height: 12px;
margin-right: 6px;
}
.icon-circle, .icon-square {
width: 10px;
height: 10px;
margin-right: 6px;
}
.ku-line {
width: 14px;
margin-right: 6px;
}
.tooltip {
min-width: 140px;
font-size: 9px;
padding: 8px 10px;
border-radius: 6px;
}
#tooltipCircle {
top: 80px !important;
}
#tooltipSquare {
top: 140px !important;
}
}
.filter-content label {
font-weight: 500;
color: #374151;
}
.filter-content label:hover {
color: #667eea;
}
.custom-checkbox input[type="checkbox"]:focus {
outline: none;
box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
}
#filterTitleCircle {
background: linear-gradient(135deg, #10b981 0%, #059669 100%);
box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3);
}
#filterTitleCircle:hover {
background: linear-gradient(135deg, #059669 0%, #047857 100%);
box-shadow: 0 5px 14px rgba(16, 185, 129, 0.4);
}
#filterTitleSquare {
background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
box-shadow: 0 3px 10px rgba(245, 158, 11, 0.3);
}
#filterTitleSquare:hover {
background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
box-shadow: 0 5px 14px rgba(245, 158, 11, 0.4);
}
.ymaps-2-1-79-control-panel {
background: rgba(255, 255, 255, 0.95) !important;
backdrop-filter: blur(10px) !important;
border-radius: 12px !important;
box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
border: 1px solid rgba(255, 255, 255, 0.8) !important;
padding: 8px !important;
gap: 8px !important;
}

}
@media (max-width: 600px) {
.ymaps-2-1-79-control-panel {
padding: 6px !important;
gap: 6px !important;
}


}
#preloader {
position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
background: #ffffff;
z-index: 99999;
display: flex;
flex-direction: column;
justify-content: center;
align-items: center;
transition: opacity 0.5s ease, visibility 0.5s ease;
}
#preloader.hidden {
opacity: 0;
visibility: hidden;
}
#preloader img {
max-width: 250px;
height: auto;
animation: pulse 1.5s infinite ease-in-out;
margin-bottom: 30px;
}
#preloader .welcome-text {
font-size: 24px;
font-weight: 600;
color: #667eea;
margin-bottom: 20px;
animation: fadeIn 0.5s ease;
}
#preloader .progress-container {
width: 300px;
height: 6px;
background: #e9ecef;
border-radius: 3px;
overflow: hidden;
box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
}
#preloader .progress-bar {
width: 0%;
height: 100%;
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
border-radius: 3px;
animation: progressLoad 2.5s ease-in-out forwards;
}
@keyframes pulse {
0% { transform: scale(1); opacity: 0.8; }
50% { transform: scale(1.05); opacity: 1; }
100% { transform: scale(1); opacity: 0.8; }
}
@keyframes fadeIn {
from { opacity: 0; transform: translateY(-10px); }
to { opacity: 1; transform: translateY(0); }
}
@keyframes progressLoad {
0% { width: 0%; }
100% { width: 100%; }
}
/* --- СТИЛИ ПАНЕЛИ СТАТИСТИКИ --- */
#statsContainer {
position: fixed;
top: 180px;
left: 0px;
z-index: 1000;
background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
padding: 12px 14px;
border-radius: 10px;
font-size: 14px;
user-select: none;
box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12),
0 2px 6px rgba(0, 0, 0, 0.08);
backdrop-filter: blur(10px);
border: 1px solid rgba(255, 255, 255, 0.8);
min-width: 290px;
max-width: 300px;
transition: all 0.3s ease;
}
#statsContainer:hover #statsContent:not(.force-close) {
    display: block !important;
}
#statsTitle:hover::after {
    transform: rotate(0deg);
}
.stats-grid {
display: grid;
grid-template-columns: 1fr 1fr;
gap: 6px 10px;
margin-top: 10px;
max-height: 400px;
overflow-y: auto;
padding-right: 5px;
}
.stats-grid::-webkit-scrollbar {
width: 5px;
}
.stats-grid::-webkit-scrollbar-track {
background: #f1f1f1;
border-radius: 3px;
}
.stats-grid::-webkit-scrollbar-thumb {
background: #667eea;
border-radius: 3px;
}
.stat-item {
display: flex;
justify-content: space-between;
align-items: center;
padding: 5px 8px;
background: rgba(255, 255, 255, 0.6);
border-radius: 6px;
font-size: 12px;
transition: all 0.2s ease;
}
.stat-item:hover {
background: rgba(102, 126, 234, 0.1);
transform: translateX(2px);
}
.stat-city {
color: #374151;
font-weight: 500;
}
.stat-count {
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
color: white;
padding: 2px 8px;
border-radius: 10px;
font-size: 11px;
font-weight: 600;
min-width: 20px;
text-align: center;
}
.stat-total {
margin-top: 10px;
padding-top: 10px;
border-top: 1px solid #e9ecef;
display: flex;
justify-content: space-between;
font-size: 13px;
font-weight: 600;
}

.stat-colors {
    margin-top: 12px;
    padding-top: 12px;
    border: 2px solid #667eea;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
    padding: 10px 12px;
}
.stat-color-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 3px 6px;
    margin-bottom: 4px;
    font-size: 11px;
}
.stat-color-row:last-child {
    margin-bottom: 0;
}
.stat-color-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 1px solid #333;
    margin-right: 6px;
}
.stat-color-row span:nth-child(2) {
    flex: 1;
    color: #374151;
}
.stat-color-value {
    font-weight: 700;
    min-width: 22px;
    text-align: right;
    color: #667eea;
}

/* Tooltip для детальной статистики по городам */
/* Tooltip с детальной статистикой поверх панели */
.city-detail-tooltip {
    position: fixed;
    background: rgba(255, 255, 255, 0.98);
    border: 2px solid #667eea;
    padding: 12px;
    border-radius: 8px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    z-index: 10001;
    font-size: 12px;
    display: none;
    min-width: 200px;
    pointer-events: none;
    animation: fadeInScale 0.4s ease;
}

.city-detail-tooltip.show {
    display: block;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
    padding: 4px 8px;
    border-radius: 4px;
}

.detail-row:last-child {
    margin-bottom: 0;
}

.detail-label {
    display: flex;
    align-items: center;
    gap: 6px;
}

.detail-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 1px solid #333;
}

.detail-value {
    font-weight: 600;
    color: #374151;
}

.detail-divider {
    border-top: 1px solid #e5e7eb;
    margin: 8px 0;
    padding-top: 8px;
}

.detail-works {
    background: #d1fae5;
    font-weight: 600;
}

.detail-off {
    background: #fee2e2;
    font-weight: 600;
}


@media (max-width: 900px) {
#statsContainer {
top: auto;
bottom: 15px;
right: 15px;
min-width: 180px;
max-width: 200px;
}
.stats-grid {
grid-template-columns: 1fr;
max-height: 250px;
}



}
@media (max-width: 600px) {
    #statsContainer {
        top: 1000;
        bottom: -580px;
        right: 15px;
        min-width: 180px;
        max-width: 200px;
        font-size: 12px;
        padding: 10px;
    }
    .stats-grid {
        grid-template-columns: 1fr;
        max-height: 250px;
    }
}

.panel-closing {
    transition: all 0.3s ease !important;
}

</style>
</head>
<body>
<div id="preloader">
<div class="welcome-text">Добро пожаловать</div>
<img src="Log2.png" alt="Загрузка...">
<div class="progress-container">
<div class="progress-bar"></div>
</div>
</div>
<?php
$db_host = 'localhost';
$db_name = 'o29369h1_grodno';
$db_user = 'o29369h1_grodno';
$db_pass = 'Belusha49';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($mysqli->connect_error) {
printf("Соединение не удалось: %s\n", $mysqli->connect_error);
exit();
}
$result = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `connection`, `Ctime` FROM `sfo_grodno`");
$a = [];
while ($row = $result->fetch_assoc()) {
$a[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'connection' => $row['connection'],
'Ctime' => $row['Ctime'],
];
}
$result->free();
$result2 = $mysqli->query("SELECT `id`, `name`, `direction`, `point`, `color`, `note`, `angle`, `id_key` FROM `usk_grodno`");
$b = [];
while ($row = $result2->fetch_assoc()) {
$b[] = [
'id' => $row['id'],
'name' => $row['name'],
'direction' => $row['direction'],
'point' => $row['point'],
'color' => $row['color'],
'note' => $row['note'],
'angle' => $row['angle'],
'id_key' => $row['id_key'],
];
}
$result2->free();
$result3 = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_lida`");
$c = [];
while ($row = $result3->fetch_assoc()) {
$c[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$result3->free();
$result4 = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_skidel`");
$d = [];
while ($row = $result4->fetch_assoc()) {
$d[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$result4->free();
$resultMosty = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_mosty`");
$mosty = [];
while ($row = $resultMosty->fetch_assoc()) {
$mosty[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$resultMosty->free();
$resultNovogrudoc = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_novogrudoc`");
$novogrudoc = [];
while ($row = $resultNovogrudoc->fetch_assoc()) {
$novogrudoc[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$resultNovogrudoc->free();
$resultOstrovets = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_ostrovets`");
$ostrovets = [];
while ($row = $resultOstrovets->fetch_assoc()) {
$ostrovets[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$resultOstrovets->free();
$resultIvie = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_Ivie`");
$Ivie = [];
while ($row = $resultIvie->fetch_assoc()) {
$Ivie[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$resultIvie->free();
$resultSmorgon = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_smorgon`");
$smorgon = [];
while ($row = $resultSmorgon->fetch_assoc()) {
$smorgon[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$resultSmorgon->free();
$resultOshmany = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_oshmany`");
$oshmany = [];
while ($row = $resultOshmany->fetch_assoc()) {
$oshmany[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$resultOshmany->free();
$resultDyatlovo = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_dyatlovo`");
$dyatlovo = [];
while ($row = $resultDyatlovo->fetch_assoc()) {
$dyatlovo[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$resultDyatlovo->free();
$resultVolkovysk = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_volkovysk`");
$volkovysk = [];
while ($row = $resultVolkovysk->fetch_assoc()) {
$volkovysk[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$resultVolkovysk->free();
$resultShuchin = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_shuchin`");
$shuchin = [];
while ($row = $resultShuchin->fetch_assoc()) {
$shuchin[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$resultShuchin->free();
$resultSlonim = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_slonim`");
$slonim = [];
while ($row = $resultSlonim->fetch_assoc()) {
$slonim[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$resultSlonim->free();
$resultSvisloch = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_svisloch`");
$svisloch = [];
while ($row = $resultSvisloch->fetch_assoc()) {
$svisloch[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$resultSvisloch->free();
$resultPogranichny = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_pogranichny`");
$pogranichny = [];
while ($row = $resultPogranichny->fetch_assoc()) {
$pogranichny[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$resultPogranichny->free();
$resultBberestovitsa = $mysqli->query("SELECT `id`, `name`, `status`, `point`, `color`, `info`, `Ctime`, `connection` FROM `sfo_Bberestovitsa`");
$bberestovitsa = [];
while ($row = $resultBberestovitsa->fetch_assoc()) {
$bberestovitsa[] = [
'id' => $row['id'],
'name' => $row['name'],
'status' => $row['status'],
'point' => $row['point'],
'color' => $row['color'],
'info' => $row['info'],
'Ctime' => $row['Ctime'],
'connection' => $row['connection'],
];
}
$resultBberestovitsa->free();
$resultCoord = $mysqli->query("SELECT `id`, `corridor_id`, `sfo_from`, `sfo_to`, `dir`, `speed_kmh`, `offset_sec` FROM `coord_links`");
$coordLinks = [];
while ($row = $resultCoord->fetch_assoc()) {
$coordLinks[] = [
'id'         => (int)$row['id'],
'corridor_id'=> (int)$row['corridor_id'],
'sfo_from'   => (int)$row['sfo_from'],
'sfo_to'     => (int)$row['sfo_to'],
'dir'        => $row['dir'],
'speed_kmh'  => $row['speed_kmh'] !== null ? (int)$row['speed_kmh'] : null,
'offset_sec' => (int)$row['offset_sec'],
];
}
$resultCoord->free();
$mysqli->close();
?>
<div id="toggleContainer">
<div class="filter-block">
<b class="filter-title" id="filterTitleAll">СО, УСК и КУ</b>
<div class="filter-content all-filters">
<label class="custom-checkbox">
<input type="checkbox" id="toggleCircles" checked>
<span class="icon-circle" style="background-color:white; border-color:#000000;"></span>Показать светофорные объекты
</label>
<label class="custom-checkbox">
<input type="checkbox" id="toggleSquares">
<span class="icon-square" style="background-color:white; border-color:#000000;"></span>Показать указатели скорости
</label>
<label class="custom-checkbox">
<input type="checkbox" id="toggleCoord" checked>
<span class="ku-line"></span>
Координированное управление
</label>
</div>
<!-- Панель статистики по городам -->
<div id="statsContainer">
<b class="filter-title" id="statsTitle" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
📊 Статистика по городам
<span style="float:right; display: inline-block;">▼</span>
</b>
<div class="filter-content" id="statsContent" style="display: none;">
<div class="stats-grid">
<div class="stat-item"><span class="stat-city">Гродно</span><span class="stat-count" id="countGrodno">0</span></div>
<div class="stat-item"><span class="stat-city">Лида</span><span class="stat-count" id="countLida">0</span></div>
<div class="stat-item"><span class="stat-city">Скидель</span><span class="stat-count" id="countSkidel">0</span></div>
<div class="stat-item"><span class="stat-city">Мосты</span><span class="stat-count" id="countMosty">0</span></div>
<div class="stat-item"><span class="stat-city">Новогрудок</span><span class="stat-count" id="countNovogrudoc">0</span></div>
<div class="stat-item"><span class="stat-city">Островец</span><span class="stat-count" id="countOstrovets">0</span></div>
<div class="stat-item"><span class="stat-city">Ивье</span><span class="stat-count" id="countIvie">0</span></div>
<div class="stat-item"><span class="stat-city">Сморгонь</span><span class="stat-count" id="countSmorgon">0</span></div>
<div class="stat-item"><span class="stat-city">Ошмяны</span><span class="stat-count" id="countOshmany">0</span></div>
<div class="stat-item"><span class="stat-city">Дятлово</span><span class="stat-count" id="countDyatlovo">0</span></div>
<div class="stat-item"><span class="stat-city">Волковыск</span><span class="stat-count" id="countVolkovysk">0</span></div>
<div class="stat-item"><span class="stat-city">Щучин</span><span class="stat-count" id="countShuchin">0</span></div>
<div class="stat-item"><span class="stat-city">Слоним</span><span class="stat-count" id="countSlonim">0</span></div>
<div class="stat-item"><span class="stat-city">Свислочь</span><span class="stat-count" id="countSvisloch">0</span></div>
<div class="stat-item"><span class="stat-city">Пограничный</span><span class="stat-count" id="countPogranichny">0</span></div>
<div class="stat-item"><span class="stat-city">Б. Берестовица</span><span class="stat-count" id="countBberestovitsa">0</span></div>
</div>
<div class="stat-total">
    <span>Всего объектов:</span>
    <span id="totalCount" style="font-weight:bold; color:#667eea;">0</span>
</div>
<div class="stat-colors">
    <div class="stat-color-row">
        <span class="stat-color-dot" style="background:#0000dd"></span>
        <span>МЗЦ:</span>
        <span id="totalMzc" class="stat-color-value">0</span>
    </div>
    <div class="stat-color-row">
        <span class="stat-color-dot" style="background:#00dd00"></span>
        <span>ВОЛС:</span>
        <span id="totalVols" class="stat-color-value">0</span>
    </div>
    <div class="stat-color-row">
        <span class="stat-color-dot" style="background:#aaaaaa"></span>
        <span>Нет связи:</span>
        <span id="totalNoconnect" class="stat-color-value">0</span>
    </div>
    <div class="stat-color-row">
        <span class="stat-color-dot" style="background:#ff0000"></span>
        <span>Отключены:</span>
        <span id="totalOff" class="stat-color-value">0</span>
    </div>
</div>
</div>
</div>
<div class="tooltip" id="tooltipAll"></div>
</div>
<div class="filter-block">
<b class="filter-title" id="filterTitleCircle">СО по связи</b>
<div class="filter-content filterCircle">
<label class="custom-checkbox">
<input type="checkbox" class="filterCircleColor" value="#aaaaaa" checked>
<span class="icon-circle" style="background-color:#aaaaaa; border-color:#000000;"></span> Нет связи с СО
</label>
<label class="custom-checkbox">
<input type="checkbox" class="filterCircleColor" value="#00dd00" checked>
<span class="icon-circle" style="background-color:#00dd00; border-color:#000000;"></span> ВОЛС с СО
</label>
<label class="custom-checkbox">
<input type="checkbox" class="filterCircleColor" value="#0000dd" checked>
<span class="icon-circle" style="background-color:#0000dd; border-color:#000000;"></span> СО МЗЦ
</label>
<label class="custom-checkbox">
<input type="checkbox" class="filterCircleColor" value="#FF0000" checked>
<span class="icon-circle" style="background-color:#FF0000; border-color:#000000;"></span> Отключенные
</label>
</div>
<div class="tooltip" id="tooltipCircle"></div>
</div>
<div class="filter-block">
<b class="filter-title" id="filterTitleSquare">УСК по статусу указателя</b>
<div class="filter-content filterSquare">
<label class="custom-checkbox">
<input type="checkbox" class="filterSquareColor" value="#FF0000" checked>
<span class="icon-square" style="background-color:#FF0000; border-color:#000000;"></span> Не работающие УСК
</label>
<label class="custom-checkbox">
<input type="checkbox" class="filterSquareColor" value="#FFFF00" checked>
<span class="icon-square" style="background-color:#FFFF00; border-color:#000000;"></span> Работающие без программы УСК
</label>
<label class="custom-checkbox">
<input type="checkbox" class="filterSquareColor" value="#00FF00" checked>
<span class="icon-square" style="background-color:#00FF00; border-color:#000000;"></span> Работающие с программой УСК
</label>
</div>
<div class="tooltip" id="tooltipSquare"></div>
</div>
</div>
<div id="map"></div>
<script src="https://api-maps.yandex.ru/2.1.79/?apikey=172ded13-518c-49a8-9cda-c4206f544d72&lang=ru_RU" type="text/javascript"></script>
<script>
ymaps.ready(init);
function init()
{
var myMap = new ymaps.Map("map", {
center: [53.677839, 23.829529],
zoom: 12,
controls: [
"zoomControl",
"rulerControl",
"trafficControl",
"typeSelector",
"fullscreenControl",
"searchControl",
"routeButtonControl"
]
}, {
searchControlProvider: "yandex#search"
});
var zoomControl = myMap.controls.get('zoomControl');
if (zoomControl) {
zoomControl.options.set('position', {
top: 270,
left: 10
});
}
var routeButton = myMap.controls.get('routeButtonControl');
if (routeButton) {
routeButton.options.set('position', {
top: 10,
right: 245
});
}
var searchControl = myMap.controls.get('searchControl');
if (searchControl) {
if (window.innerWidth <= 600) {
searchControl.options.set('position', {
top: 10,
right: 160
});
} else {
searchControl.options.set('position', {
top: 10,
right: 365
});
}
}
var routeButtonControl = myMap.controls.get('routeButtonControl');
if (routeButtonControl) {
if (window.innerWidth <= 600) {
routeButtonControl.options.set('position', {
top: 10,
right: 122
});
} else {
routeButtonControl.options.set('position', {
top: 10,
right: 245
});
}
}
var circlePlacemarks = [];
var squarePlacemarks = [];
var lidaPlacemarks = [];
var myCollectionCircle = new ymaps.GeoObjectCollection();
var myCollectionSquare = new ymaps.GeoObjectCollection();
var myCollectionLida = new ymaps.GeoObjectCollection();
var sfoData = <?= json_encode($a, JSON_UNESCAPED_UNICODE) ?>;
var uskData = <?= json_encode($b, JSON_UNESCAPED_UNICODE) ?>;
var lidaData = <?= json_encode($c, JSON_UNESCAPED_UNICODE) ?>;
var coordLinks = <?= json_encode($coordLinks, JSON_UNESCAPED_UNICODE) ?>;
var coordLines = [];
var bberestovitsaData = <?= json_encode($bberestovitsa, JSON_UNESCAPED_UNICODE) ?>;
var bberestovitsaPlacemarks = [];
var myCollectionBberestovitsa = new ymaps.GeoObjectCollection();
for (var i = 0; i < bberestovitsaData.length; i++) {
var coords = bberestovitsaData[i].point.split(',').map(parseFloat);
var color = bberestovitsaData[i].color.toLowerCase();
var placemark = new ymaps.Placemark(coords, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Большая Берестовица №" + bberestovitsaData[i].id + "</b><br>" +
"<b>" + bberestovitsaData[i].name + "</b><br><br>" +
"<u>Режим работы:</u> " + bberestovitsaData[i].status + "<br>" +
"<u>Программы:</u> " + bberestovitsaData[i].info + "<br>" +
"<u>Цикл:</u> " + bberestovitsaData[i].Ctime + " сек<br>" +
"<u>Связь:</u> " + bberestovitsaData[i].connection + "<br><br>" +
"<a href='/pdf_BB/sfo_pdf.php?id=" + bberestovitsaData[i].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + bberestovitsaData[i].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: bberestovitsaData[i].color
});
myCollectionBberestovitsa.add(placemark);
bberestovitsaPlacemarks.push({placemark: placemark, color: color});
}
myMap.geoObjects.add(myCollectionBberestovitsa);
var pogranichnyData = <?= json_encode($pogranichny, JSON_UNESCAPED_UNICODE) ?>;
var pogranichnyPlacemarks = [];
var myCollectionPogranichny = new ymaps.GeoObjectCollection();
for (var i = 0; i < pogranichnyData.length; i++) {
var coords = pogranichnyData[i].point.split(',').map(parseFloat);
var color = pogranichnyData[i].color.toLowerCase();
var placemark = new ymaps.Placemark(coords, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Пограничный №" + pogranichnyData[i].id + "</b><br>" +
"<b>" + pogranichnyData[i].name + "</b><br><br>" +
"<u>Режим работы:</u> " + pogranichnyData[i].status + "<br>" +
"<u>Программы:</u> " + pogranichnyData[i].info + "<br>" +
"<u>Цикл:</u> " + pogranichnyData[i].Ctime + " сек<br>" +
"<u>Связь:</u> " + pogranichnyData[i].connection + "<br><br>" +
"<a href='/pdf_pogranichny/sfo_pdf.php?id=" + pogranichnyData[i].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + pogranichnyData[i].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: pogranichnyData[i].color
});
myCollectionPogranichny.add(placemark);
pogranichnyPlacemarks.push({placemark: placemark, color: color});
}
myMap.geoObjects.add(myCollectionPogranichny);
var svislochData = <?= json_encode($svisloch, JSON_UNESCAPED_UNICODE) ?>;
var svislochPlacemarks = [];
var myCollectionSvisloch = new ymaps.GeoObjectCollection();
for (var i = 0; i < svislochData.length; i++) {
var coords = svislochData[i].point.split(',').map(parseFloat);
var color = svislochData[i].color.toLowerCase();
var placemark = new ymaps.Placemark(coords, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Свислочь №" + svislochData[i].id + "</b><br>" +
"<b>" + svislochData[i].name + "</b><br><br>" +
"<u>Режим работы:</u> " + svislochData[i].status + "<br>" +
"<u>Программы:</u> " + svislochData[i].info + "<br>" +
"<u>Цикл:</u> " + svislochData[i].Ctime + " сек<br>" +
"<u>Связь:</u> " + svislochData[i].connection + "<br><br>" +
"<a href='/pdf_svisloch/sfo_pdf.php?id=" + svislochData[i].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + svislochData[i].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: svislochData[i].color
});
myCollectionSvisloch.add(placemark);
svislochPlacemarks.push({placemark: placemark, color: color});
}
myMap.geoObjects.add(myCollectionSvisloch);
var slonimData = <?= json_encode($slonim, JSON_UNESCAPED_UNICODE) ?>;
var slonimPlacemarks = [];
var myCollectionSlonim = new ymaps.GeoObjectCollection();
for (var i = 0; i < slonimData.length; i++) {
var coords = slonimData[i].point.split(',').map(parseFloat);
var color = slonimData[i].color.toLowerCase();
var placemark = new ymaps.Placemark(coords, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Слоним №" + slonimData[i].id + "</b><br>" +
"<b>" + slonimData[i].name + "</b><br><br>" +
"<u>Режим работы:</u> " + slonimData[i].status + "<br>" +
"<u>Программы:</u> " + slonimData[i].info + "<br>" +
"<u>Цикл:</u> " + slonimData[i].Ctime + " сек<br>" +
"<u>Связь:</u> " + slonimData[i].connection + "<br><br>" +
"<a href='/pdf_slonim/sfo_pdf.php?id=" + slonimData[i].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + slonimData[i].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: slonimData[i].color
});
myCollectionSlonim.add(placemark);
slonimPlacemarks.push({placemark: placemark, color: color});
}
myMap.geoObjects.add(myCollectionSlonim);
var shuchinData = <?= json_encode($shuchin, JSON_UNESCAPED_UNICODE) ?>;
var shuchinPlacemarks = [];
var myCollectionShuchin = new ymaps.GeoObjectCollection();
for (var i = 0; i < shuchinData.length; i++) {
var coords = shuchinData[i].point.split(',').map(parseFloat);
var color = shuchinData[i].color.toLowerCase();
var placemark = new ymaps.Placemark(coords, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Щучин №" + shuchinData[i].id + "</b><br>" +
"<b>" + shuchinData[i].name + "</b><br><br>" +
"<u>Режим работы:</u> " + shuchinData[i].status + "<br>" +
"<u>Программы:</u> " + shuchinData[i].info + "<br>" +
"<u>Цикл:</u> " + shuchinData[i].Ctime + " сек<br>" +
"<u>Связь:</u> " + shuchinData[i].connection + "<br><br>" +
"<a href='/pdf_shuchin/sfo_pdf.php?id=" + shuchinData[i].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + shuchinData[i].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: shuchinData[i].color
});
myCollectionShuchin.add(placemark);
shuchinPlacemarks.push({placemark: placemark, color: color});
}
myMap.geoObjects.add(myCollectionShuchin);
var volkovyskData = <?= json_encode($volkovysk, JSON_UNESCAPED_UNICODE) ?>;
var volkovyskPlacemarks = [];
var myCollectionVolkovysk = new ymaps.GeoObjectCollection();
for (var i = 0; i < volkovyskData.length; i++) {
var coords = volkovyskData[i].point.split(',').map(parseFloat);
var color = volkovyskData[i].color.toLowerCase();
var placemark = new ymaps.Placemark(coords, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Волковыск №" + volkovyskData[i].id + "</b><br>" +
"<b>" + volkovyskData[i].name + "</b><br><br>" +
"<u>Режим работы:</u> " + volkovyskData[i].status + "<br>" +
"<u>Программы:</u> " + volkovyskData[i].info + "<br>" +
"<u>Цикл:</u> " + volkovyskData[i].Ctime + " сек<br>" +
"<u>Связь:</u> " + volkovyskData[i].connection + "<br><br>" +
"<a href='/pdf_volkovysk/sfo_pdf.php?id=" + volkovyskData[i].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + volkovyskData[i].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: volkovyskData[i].color
});
myCollectionVolkovysk.add(placemark);
volkovyskPlacemarks.push({placemark: placemark, color: color});
}
myMap.geoObjects.add(myCollectionVolkovysk);
var dyatlovoData = <?= json_encode($dyatlovo, JSON_UNESCAPED_UNICODE) ?>;
var dyatlovoPlacemarks = [];
var myCollectionDyatlovo = new ymaps.GeoObjectCollection();
for (var i = 0; i < dyatlovoData.length; i++) {
var coords = dyatlovoData[i].point.split(',').map(parseFloat);
var color = dyatlovoData[i].color.toLowerCase();
var placemark = new ymaps.Placemark(coords, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Дятлово №" + dyatlovoData[i].id + "</b><br>" +
"<b>" + dyatlovoData[i].name + "</b><br><br>" +
"<u>Режим работы:</u> " + dyatlovoData[i].status + "<br>" +
"<u>Программы:</u> " + dyatlovoData[i].info + "<br>" +
"<u>Цикл:</u> " + dyatlovoData[i].Ctime + " сек<br>" +
"<u>Связь:</u> " + dyatlovoData[i].connection + "<br><br>" +
"<a href='/pdf_dyatlovo/sfo_pdf.php?id=" + dyatlovoData[i].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + dyatlovoData[i].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: dyatlovoData[i].color
});
myCollectionDyatlovo.add(placemark);
dyatlovoPlacemarks.push({placemark: placemark, color: color});
}
myMap.geoObjects.add(myCollectionDyatlovo);
var oshmanyData = <?= json_encode($oshmany, JSON_UNESCAPED_UNICODE) ?>;
var oshmanyPlacemarks = [];
var myCollectionOshmany = new ymaps.GeoObjectCollection();
for (var i = 0; i < oshmanyData.length; i++) {
var coords = oshmanyData[i].point.split(',').map(parseFloat);
var color = oshmanyData[i].color.toLowerCase();
var placemark = new ymaps.Placemark(coords, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Ошмяны №" + oshmanyData[i].id + "</b><br>" +
"<b>" + oshmanyData[i].name + "</b><br><br>" +
"<u>Режим работы:</u> " + oshmanyData[i].status + "<br>" +
"<u>Программы:</u> " + oshmanyData[i].info + "<br>" +
"<u>Цикл:</u> " + oshmanyData[i].Ctime + " сек<br>" +
"<u>Связь:</u> " + oshmanyData[i].connection + "<br><br>" +
"<a href='/pdf_oshmany/sfo_pdf.php?id=" + oshmanyData[i].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + oshmanyData[i].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: oshmanyData[i].color
});
myCollectionOshmany.add(placemark);
oshmanyPlacemarks.push({placemark: placemark, color: color});
}
myMap.geoObjects.add(myCollectionOshmany);
var smorgonData = <?= json_encode($smorgon, JSON_UNESCAPED_UNICODE) ?>;
var smorgonPlacemarks = [];
var myCollectionSmorgon = new ymaps.GeoObjectCollection();
for (var i = 0; i < smorgonData.length; i++) {
var coords = smorgonData[i].point.split(',').map(parseFloat);
var color = smorgonData[i].color.toLowerCase();
var placemark = new ymaps.Placemark(coords, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Сморгонь №" + smorgonData[i].id + "</b><br>" +
"<b>" + smorgonData[i].name + "</b><br><br>" +
"<u>Режим работы:</u> " + smorgonData[i].status + "<br>" +
"<u>Программы:</u> " + smorgonData[i].info + "<br>" +
"<u>Цикл:</u> " + smorgonData[i].Ctime + " сек<br>" +
"<u>Связь:</u> " + smorgonData[i].connection + "<br><br>" +
"<a href='/pdf_smorgon/sfo_pdf.php?id=" + smorgonData[i].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + smorgonData[i].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: smorgonData[i].color
});
myCollectionSmorgon.add(placemark);
smorgonPlacemarks.push({placemark: placemark, color: color});
}
myMap.geoObjects.add(myCollectionSmorgon);
var ostrovetsData = <?= json_encode($ostrovets, JSON_UNESCAPED_UNICODE) ?>;
var ostrovetsPlacemarks = [];
var myCollectionOstrovets = new ymaps.GeoObjectCollection();
for (var i = 0; i < ostrovetsData.length; i++) {
var coords = ostrovetsData[i].point.split(',').map(parseFloat);
var color = ostrovetsData[i].color.toLowerCase();
var placemark = new ymaps.Placemark(coords, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Островец №" + ostrovetsData[i].id + "</b><br>" +
"<b>" + ostrovetsData[i].name + "</b><br><br>" +
"<u>Режим работы:</u> " + ostrovetsData[i].status + "<br>" +
"<u>Программы:</u> " + ostrovetsData[i].info + "<br>" +
"<u>Цикл:</u> " + ostrovetsData[i].Ctime + " сек<br>" +
"<u>Связь:</u> " + ostrovetsData[i].connection + "<br><br>" +
"<a href='/pdf_ostrovets/sfo_pdf.php?id=" + ostrovetsData[i].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + ostrovetsData[i].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: ostrovetsData[i].color
});
myCollectionOstrovets.add(placemark);
ostrovetsPlacemarks.push({placemark: placemark, color: color});
}
myMap.geoObjects.add(myCollectionOstrovets);
var novogrudocData = <?= json_encode($novogrudoc, JSON_UNESCAPED_UNICODE) ?>;
var novogrudocPlacemarks = [];
var myCollectionNovogrudoc = new ymaps.GeoObjectCollection();
for (var i = 0; i < novogrudocData.length; i++) {
var coords = novogrudocData[i].point.split(',').map(parseFloat);
var color = novogrudocData[i].color.toLowerCase();
var placemark = new ymaps.Placemark(coords, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Новогрудок №" + novogrudocData[i].id + "</b><br>" +
"<b>" + novogrudocData[i].name + "</b><br><br>" +
"<u>Режим работы:</u> " + novogrudocData[i].status + "<br>" +
"<u>Программы:</u> " + novogrudocData[i].info + "<br>" +
"<u>Цикл:</u> " + novogrudocData[i].Ctime + " сек<br>" +
"<u>Связь:</u> " + novogrudocData[i].connection + "<br><br>" +
"<a href='/pdf_novogrudoc/sfo_pdf.php?id=" + novogrudocData[i].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + novogrudocData[i].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: novogrudocData[i].color
});
myCollectionNovogrudoc.add(placemark);
novogrudocPlacemarks.push({placemark: placemark, color: color});
}
myMap.geoObjects.add(myCollectionNovogrudoc);
var mostyData = <?= json_encode($mosty, JSON_UNESCAPED_UNICODE) ?>;
var mostyPlacemarks = [];
var myCollectionMosty = new ymaps.GeoObjectCollection();
for (var i = 0; i < mostyData.length; i++) {
var coords = mostyData[i].point.split(',').map(parseFloat);
var color = mostyData[i].color.toLowerCase();
var placemark = new ymaps.Placemark(coords, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Мосты №" + mostyData[i].id + "</b><br>" +
"<b>" + mostyData[i].name + "</b><br><br>" +
"<u>Режим работы:</u> " + mostyData[i].status + "<br>" +
"<u>Программы:</u> " + mostyData[i].info + "<br>" +
"<u>Цикл:</u> " + mostyData[i].Ctime + " сек<br>" +
"<u>Связь:</u> " + mostyData[i].connection + "<br><br>" +
"<a href='/pdf_mosty/sfo_pdf.php?id=" + mostyData[i].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + mostyData[i].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: mostyData[i].color
});
myCollectionMosty.add(placemark);
mostyPlacemarks.push({placemark: placemark, color: color});
}
myMap.geoObjects.add(myCollectionMosty);
var IvieData = <?= json_encode($Ivie, JSON_UNESCAPED_UNICODE) ?>;
var IviePlacemarks = [];
var myCollectionIvie = new ymaps.GeoObjectCollection();
for (var i = 0; i < IvieData.length; i++) {
var coords = IvieData[i].point.split(',').map(parseFloat);
var color = IvieData[i].color.toLowerCase();
var placemark = new ymaps.Placemark(coords, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Ивье №" + IvieData[i].id + "</b><br>" +
"<b>" + IvieData[i].name + "</b><br><br>" +
"<u>Режим работы:</u> " + IvieData[i].status + "<br>" +
"<u>Программы:</u> " + IvieData[i].info + "<br>" +
"<u>Цикл:</u> " + IvieData[i].Ctime + " сек<br>" +
"<u>Связь:</u> " + IvieData[i].connection + "<br><br>" +
"<a href='/pdf_Ivie/sfo_pdf.php?id=" + IvieData[i].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + IvieData[i].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: IvieData[i].color
});
myCollectionIvie.add(placemark);
IviePlacemarks.push({placemark: placemark, color: color});
}
myMap.geoObjects.add(myCollectionIvie);
var skidelData = <?= json_encode($d, JSON_UNESCAPED_UNICODE) ?>;
var skidelPlacemarks = [];
var myCollectionSkidel = new ymaps.GeoObjectCollection();
for (var m = 0; m < skidelData.length; m++) {
var coordsSkidel = skidelData[m].point.split(',').map(parseFloat);
var colorSkidel = skidelData[m].color.toLowerCase();
var placemarkSkidel = new ymaps.Placemark(coordsSkidel, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Скидель №" + skidelData[m].id + "</b><br>" +
"<b>" + skidelData[m].name + "</b><br><br>" +
"<u>Режим работы:</u> " + skidelData[m].status + "<br>" +
"<u>Программы:</u> " + skidelData[m].info + "<br>" +
"<u>Цикл:</u> " + skidelData[m].Ctime + " сек<br>" +
"<u>Связь:</u> " + skidelData[m].connection + "<br><br>" +
"<a href='/pdf_skidel/sfo_pdf.php?id=" + skidelData[m].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + skidelData[m].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: skidelData[m].color
});
myCollectionSkidel.add(placemarkSkidel);
skidelPlacemarks.push({placemark: placemarkSkidel, color: colorSkidel});
}
for (var k = 0; k < lidaData.length; k++) {
var coordsLida = lidaData[k].point.split(',').map(parseFloat);
var colorLida = lidaData[k].color.toLowerCase();
var placemarkLida = new ymaps.Placemark(coordsLida, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Лида №" + lidaData[k].id + "</b><br>" +
"<b>" + lidaData[k].name + "</b><br><br>" +
"<u>Режим работы:</u> " + lidaData[k].status + "<br>" +
"<u>Программы:</u> " + lidaData[k].info + "<br>" +
"<u>Цикл:</u> " + lidaData[k].Ctime + " сек<br>" +
"<u>Связь:</u> " + lidaData[k].connection + "<br><br>" +
"<a href='/pdf_lida/sfo_pdf.php?id=" + lidaData[k].id + "' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;' class='pdf-link'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + lidaData[k].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: lidaData[k].color
});
myCollectionLida.add(placemarkLida);
lidaPlacemarks.push({placemark: placemarkLida, color: colorLida});
}
for (var i = 0; i < sfoData.length; i++) {
var coords = sfoData[i].point.split(',').map(parseFloat);
var color = sfoData[i].color.toLowerCase();
var placemarkCircle = new ymaps.Placemark(coords, {
balloonContent:
"<div style='font-size: 14px; line-height: 1.4'>" +
"<b>СФО Гродно №" + sfoData[i].id + "</b><br>" +
"<b>" + sfoData[i].name + "</b><br><br>" +
"<u>Режим работы:</u> " + sfoData[i].status + "<br>" +
"<u>Программы:</u> " + sfoData[i].info + "<br>" +
"<u>Цикл:</u> " + sfoData[i].Ctime + " сек<br>" +
"<u>Связь:</u> " + sfoData[i].connection + "<br><br>" +
"<a href='/pdf/sfo_" + sfoData[i].id + ".pdf?v=" + new Date().getTime() + "' target='_blank' " +
"style='color: #2f80ed; font-weight: bold; text-decoration: none;'>" +
"📊 Информация по объекту (PDF)</a>" +
"</div>",
iconContent: "<small>" + sfoData[i].id + "</small>"
}, {
preset: "islands#circleIcon",
hideIconOnBalloonOpen: false,
iconColor: sfoData[i].color
});
myCollectionCircle.add(placemarkCircle);
circlePlacemarks.push({placemark: placemarkCircle, color: color});
}
for (var j = 0; j < uskData.length; j++) {
var coordsSquare = uskData[j].point.split(',').map(parseFloat);
var colorSquare = uskData[j].color.toLowerCase();
var rotationAngle = 0;
if (uskData[j].angle) {
var angle = parseFloat(uskData[j].angle);
if (!isNaN(angle)) {
rotationAngle = angle;
}
}
var placemarkSquare = new ymaps.Placemark(coordsSquare, {
balloonContent:
"Указатель скорости № " + uskData[j].id + ":<br><b>" + uskData[j].name + "</b><br><u>" +
"Статус указателя:</u> " + (uskData[j].note || "") + "<br>" +
"Направление: " + (uskData[j].direction || ""),
iconContent: uskData[j].id,
color: uskData[j].color
},
{
iconLayout: "default#imageWithContent",
iconImageHref: "",
iconImageSize: [20, 20],
iconImageOffset: [-10, -10],
iconContentLayout: ymaps.templateLayoutFactory.createClass(
'<div style="width: 30px; height: 20px; background-color: white; border: 2px solid $[properties.color]; ' +
'text-align: center; line-height: 20px; font-size: 11px; border-radius: 6px; font-weight: normal; color: black; ' +
'transform: rotate(' + rotationAngle + 'deg); transform-origin: center center;">' +
'$[properties.iconContent]' +
'</div>'
),
hideIconOnBalloonOpen: false,
});
myCollectionSquare.add(placemarkSquare);
squarePlacemarks.push({placemark: placemarkSquare, color: colorSquare});
}
var sfoById = {};
for (var i = 0; i < sfoData.length; i++) {
sfoById[sfoData[i].id] = sfoData[i];
}
coordLinks.forEach(function (link) {
var a = sfoById[link.sfo_from];
var b = sfoById[link.sfo_to];
if (!a || !b) return;
var coordsA = a.point.split(',').map(parseFloat);
var coordsB = b.point.split(',').map(parseFloat);
var cid = Number(link.corridor_id);
var color = '#00AA00';
if (cid === 2) color = '#00AA00';
if (cid === 3) color = '#00AA00';
ymaps.route([coordsA, coordsB], {
routingMode: 'auto',
avoidTrafficJams: true,
avoidTolls: false,
useRouteIndex: false 
}).then(function (route) {
var path = route.getPaths().get(0);
var pathCoords = path.geometry.getCoordinates();
pathCoords[pathCoords.length] = coordsB;
var line = new ymaps.Polyline(pathCoords, {
balloonContent: 'Координация СФО ' + '<br><b>' + a.name + ' → ' + b.name + '</b>' +
'<br>Коридор: ' + cid +
(link.speed_kmh ? '<br>Скорость: ' + link.speed_kmh + ' км/ч' : '')
}, {
strokeColor: color + 'CC',
strokeWidth: 7,
strokeOpacity: 0.4,
strokeStyle: 'solid'
});
coordLines.push(line);
myMap.geoObjects.add(line);
}).catch(function() {
var straight = new ymaps.Polyline([coordsA, coordsB], {
balloonContent: 'ПРЯМАЯ ' + a.id + ' → ' + b.id
}, { strokeColor: color + '40', strokeWidth: 4 });
coordLines.push(straight);
myMap.geoObjects.add(straight);
});
});


function filterPlacemarks() {
var showCircles = document.getElementById('toggleCircles').checked;
var showSquares = document.getElementById('toggleSquares').checked;
var showCoord = document.getElementById('toggleCoord').checked;
var selectedCircleColors = Array.from(document.querySelectorAll('.filterCircleColor:checked'))
.map(el => el.value.toLowerCase());
var selectedSquareColors = Array.from(document.querySelectorAll('.filterSquareColor:checked'))
.map(el => el.value.toLowerCase());
circlePlacemarks.forEach(function(item) {
if (item.color === '#ff00bb') {
myMap.geoObjects.remove(item.placemark);
return;
}
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
skidelPlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
lidaPlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
smorgonPlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
IviePlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
dyatlovoPlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
oshmanyPlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
pogranichnyPlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
novogrudocPlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
ostrovetsPlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
mostyPlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
shuchinPlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
volkovyskPlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
slonimPlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
svislochPlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
bberestovitsaPlacemarks.forEach(function(item) {
if (showCircles && selectedCircleColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
squarePlacemarks.forEach(function(item) {
if (showSquares && selectedSquareColors.includes(item.color)) {
myMap.geoObjects.add(item.placemark);
} else {
myMap.geoObjects.remove(item.placemark);
}
});
coordLines.forEach(function(line) {
if (showCoord) {
myMap.geoObjects.add(line);
} else {
myMap.geoObjects.remove(line);
}
});
}
// --- ФУНКЦИЯ ПОДСЧЁТА СТАТИСТИКИ (ВНУТРИ init) ---
// --- ФУНКЦИЯ ПОДСЧЁТА СТАТИСТИКИ С ДЕТАЛИЗАЦИЕЙ ---
// --- ФУНКЦИЯ ПОДСЧЁТА СТАТИСТИКИ С DETAIL TOOLTIP ---
function updateStats() {
    var allowedColors = ['#aaaaaa', '#00dd00', '#0000dd', '#ff0000'];
    
    function countByColor(placemarks, color) {
        return placemarks.filter(function(item) {
            return item.color.toLowerCase() === color.toLowerCase();
        }).length;
    }
    
    function countTotal(placemarks) {
        return placemarks.filter(function(item) {
            return allowedColors.includes(item.color.toLowerCase());
        }).length;
    }
    
    var cities = {
        Grodno: {name: 'Гродно', data: circlePlacemarks},
        Lida: {name: 'Лида', data: lidaPlacemarks},
        Skidel: {name: 'Скидель', data: skidelPlacemarks},
        Mosty: {name: 'Мосты', data: mostyPlacemarks},
        Novogrudoc: {name: 'Новогрудок', data: novogrudocPlacemarks},
        Ostrovets: {name: 'Островец', data: ostrovetsPlacemarks},
        Ivie: {name: 'Ивье', data: IviePlacemarks},
        Smorgon: {name: 'Сморгонь', data: smorgonPlacemarks},
        Oshmany: {name: 'Ошмяны', data: oshmanyPlacemarks},
        Dyatlovo: {name: 'Дятлово', data: dyatlovoPlacemarks},
        Volkovysk: {name: 'Волковыск', data: volkovyskPlacemarks},
        Shuchin: {name: 'Щучин', data: shuchinPlacemarks},
        Slonim: {name: 'Слоним', data: slonimPlacemarks},
        Svisloch: {name: 'Свислочь', data: svislochPlacemarks},
        Pogranichny: {name: 'Пограничный', data: pogranichnyPlacemarks},
        Bberestovitsa: {name: 'Б. Берестовица', data: bberestovitsaPlacemarks}
    };
    
    var total = 0;
    var totalMzc = 0;          // 🔵 Синие
    var totalVols = 0;         // 🟢 Зелёные
    var totalNoconnect = 0;    // ⚪ Серые
    var totalOff = 0;          // 🔴 Красные
    
    for (var cityKey in cities) {
        var city = cities[cityKey];
        var placemarks = city.data;
        var count = countTotal(placemarks);
        
        // Считаем по цветам для ЭТОГО города
        var gray = countByColor(placemarks, '#aaaaaa');
        var green = countByColor(placemarks, '#00dd00');
        var blue = countByColor(placemarks, '#0000dd');
        var red = countByColor(placemarks, '#ff0000');
        
        // ✅ ДОБАВЛЯЕМ к общим суммам
        totalMzc += blue;
        totalVols += green;
        totalNoconnect += gray;
        totalOff += red;
        
        var works = gray + green + blue;
        var off = red;
        
        document.getElementById('count' + cityKey).textContent = count;
        total += count;
        
        // Tooltip код (без изменений)
        var statItem = document.querySelector('#count' + cityKey).closest('.stat-item');
        var tooltipId = 'tooltip_detail_' + cityKey;
        var tooltip = document.getElementById(tooltipId);
        
        if (!tooltip) {
            tooltip = document.createElement('div');
            tooltip.id = tooltipId;
            tooltip.className = 'city-detail-tooltip';
            document.body.appendChild(tooltip);
            
            statItem.addEventListener('mouseenter', function(e) {
                var tt = document.getElementById(this.dataset.tooltipId);
                if (tt) {
                    var rect = this.getBoundingClientRect();
                    tt.style.left = (rect.left) + 'px';
                    tt.style.top = (rect.top - tt.offsetHeight - 10) + 'px';
                    tt.classList.add('show');
                }
            });
            
            statItem.addEventListener('mouseleave', function(e) {
                var tt = document.getElementById(this.dataset.tooltipId);
                if (tt) {
                    tt.classList.remove('show');
                }
            });
        }
        
        statItem.dataset.tooltipId = tooltipId;
        
        tooltip.innerHTML = 
            '<div style="font-weight:600;margin-bottom:8px;color:#667eea;">' + city.name + '</div>' +
            '<div class="detail-row detail-works">' +
                '<span class="detail-label">✓ Работают</span>' +
                '<span class="detail-value">' + works + '</span>' +
            '</div>' +
            '<div class="detail-row">' +
                '<span class="detail-label"><span class="detail-dot" style="background:#0000dd"></span>МЗЦ</span>' +
                '<span class="detail-value">' + blue + '</span>' +
            '</div>' +
            '<div class="detail-row">' +
                '<span class="detail-label"><span class="detail-dot" style="background:#00dd00"></span>ВОЛС</span>' +
                '<span class="detail-value">' + green + '</span>' +
            '</div>' +
            '<div class="detail-row">' +
                '<span class="detail-label"><span class="detail-dot" style="background:#aaaaaa"></span>Нет связи</span>' +
                '<span class="detail-value">' + gray + '</span>' +
            '</div>' +
            '<div class="detail-divider"></div>' +
            '<div class="detail-row detail-off">' +
                '<span class="detail-label">✗ Отключены</span>' +
                '<span class="detail-value">' + off + '</span>' +
            '</div>';
    }
    
    // ✅ ОБНОВЛЯЕМ общие значения в HTML
    document.getElementById('totalCount').textContent = total;
    document.getElementById('totalMzc').textContent = totalMzc;
    document.getElementById('totalVols').textContent = totalVols;
    document.getElementById('totalNoconnect').textContent = totalNoconnect;
    document.getElementById('totalOff').textContent = totalOff;
}


document.getElementById('toggleCircles').addEventListener('change', filterPlacemarks);
document.getElementById('toggleSquares').addEventListener('change', filterPlacemarks);
document.getElementById('toggleCoord').addEventListener('change', filterPlacemarks);
document.querySelectorAll('.filterCircleColor').forEach(el => el.addEventListener('change', filterPlacemarks));
document.querySelectorAll('.filterSquareColor').forEach(el => el.addEventListener('change', filterPlacemarks));
// Вызов фильтрации при инициализации
// Вызов фильтрации при инициализации
// Вызов фильтрации при инициализации
filterPlacemarks();

// Вызываем updateStats ПОСЛЕ создания всех меток
setTimeout(function() {
    updateStats();
}, 100);

// --- АВТОЗАКРЫТИЕ ПАНЕЛЕЙ ПРИ ДВИЖЕНИИ КАРТЫ (МОБИЛЬНЫЕ) ---
var isMobile = window.innerWidth <= 900;
var mapMoved = false;
var closeTimeout;

if (isMobile) {
    // Слушаем начало движения карты
    myMap.events.add('actionbegin', function() {
        mapMoved = true;
    });
    
    // Слушаем окончание движения карты
    myMap.events.add('actionend', function() {
        if (mapMoved) {
            closeTimeout = setTimeout(function() {
                // Закрываем все фильтры
                document.querySelectorAll('.filter-content.show').forEach(function(content) {
                    content.classList.remove('show');
                    content.style.display = 'none';
                });
                
                // Закрываем статистику
                var statsContent = document.getElementById('statsContent');
                if (statsContent) {
                    statsContent.style.display = 'none';
                    statsContent.classList.add('force-close');
                    
                }
                
                mapMoved = false;
            }, 100);
        }
    });
    
    // Отменяем закрытие при клике на панель
    document.getElementById('toggleContainer').addEventListener('click', function() {
        if (closeTimeout) {
            clearTimeout(closeTimeout);
        }
    });
    
    document.getElementById('statsContainer').addEventListener('click', function() {
    if (closeTimeout) {
        clearTimeout(closeTimeout);
    }
    var statsContent = document.getElementById('statsContent');
    if (statsContent) {
        statsContent.classList.remove('force-close');  // ← ДОБАВИТЬ
    }
});
}

var ruler = myMap.controls.get('rulerControl');
if (ruler) {
    ruler.state.set('expanded', true);
}
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
function copyCheckboxes(fromSelector, toSelector) {
const from = document.querySelector(fromSelector);
const to = document.querySelector(toSelector);
if (!from || !to) return;
to.innerHTML = from.innerHTML;
to.querySelectorAll('input[type=checkbox]').forEach(input => {
input.addEventListener('change', function () {
let orig;
if (input.id) {
orig = document.getElementById(input.id);
}
if (!orig && input.className) {
orig = Array.from(document.querySelectorAll('input.' + input.className))
.find(chk => chk.value.toLowerCase() === input.value.toLowerCase());
}
if (orig) {
orig.checked = input.checked;
orig.dispatchEvent(new Event('change'));
}
});
});
}
copyCheckboxes('.all-filters', '#tooltipAll');
copyCheckboxes('.filterCircle', '#tooltipCircle');
copyCheckboxes('.filterSquare', '#tooltipSquare');
function showTooltip(titleId, tooltipId) {
const titleEl = document.getElementById(titleId);
const tooltipEl = document.getElementById(tooltipId);
titleEl.addEventListener('mouseenter', function () {
const rect = titleEl.getBoundingClientRect();
tooltipEl.style.display = 'block';
tooltipEl.classList.add('show');
tooltipEl.style.top = (window.scrollY + rect.top - 70) + 'px';
tooltipEl.style.left = (window.scrollX + rect.left + 200) + 'px';
tooltipEl.style.transform = 'translateY(0%)';
});
titleEl.addEventListener('mouseleave', function () {
setTimeout(() => {
if (!tooltipEl.matches(':hover') && !titleEl.matches(':hover')) {
tooltipEl.style.display = 'none';
}
}, 1000);
});
tooltipEl.addEventListener('mouseleave', function () {
tooltipEl.classList.remove('show');
tooltipEl.style.display = 'none';
});
tooltipEl.addEventListener('mouseenter', function () {
tooltipEl.classList.add('show');
tooltipEl.style.display = 'block';
});
}
showTooltip('filterTitleAll', 'tooltipAll');
showTooltip('filterTitleCircle', 'tooltipCircle');
showTooltip('filterTitleSquare', 'tooltipSquare');
});
</script>
<script>
window.addEventListener('load', function() {
var preloader = document.getElementById('preloader');
if (preloader) {
setTimeout(function() {
preloader.classList.add('hidden');
setTimeout(function() {
preloader.style.display = 'none';
}, 500);
}, 2500);
}
});
</script>
</body>
</html>