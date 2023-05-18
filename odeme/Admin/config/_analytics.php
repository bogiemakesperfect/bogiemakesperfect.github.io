<?php

//1. Musteriler
$query = "SELECT COUNT(*) FROM `viento_musteriler` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($musteriler);
$stmt->fetch();
$stmt->close();

//2.Siparisler
$query = "SELECT COUNT(*) FROM `viento_siparisler` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($siparisler);
$stmt->fetch();
$stmt->close();

//3. Urunler
$query = "SELECT COUNT(*) FROM `viento_urunler` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($urunler);
$stmt->fetch();
$stmt->close();





 ?>