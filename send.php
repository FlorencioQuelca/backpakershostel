<?php
// Respaldo para hosting con PHP (p. ej. Hostinger). Con hosting gratuito sin PHP se usa Google Apps Script (CFG.api).
header('Content-Type: application/json; charset=utf-8');
$to = "backpackers.oruro@gmail.com";
if ($_SERVER["REQUEST_METHOD"] !== "POST") { http_response_code(405); echo '{"ok":false}'; exit; }
function c($k){ return trim(strip_tags($_POST[$k] ?? "")); }
if (c("website") !== "") { echo '{"ok":true}'; exit; }
$email = filter_var(c("email"), FILTER_VALIDATE_EMAIL);
if (!$email || c("name") === "") { http_response_code(400); echo '{"ok":false}'; exit; }
$body = "Nombre: ".c("name")."\nCorreo: $email\nLlegada: ".c("checkin")."\nSalida: ".c("checkout")."\nPersonas: ".c("guests")."\nHabitacion: ".c("room")."\n\nMensaje:\n".c("message");
$headers = "From: web@".preg_replace('/[^a-z0-9.\-]/i','',$_SERVER["HTTP_HOST"] ?? "localhost")."\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";
$ok = mail($to, "Nueva consulta - Oruro Backpackers", $body, $headers);
if (!$ok) http_response_code(500);
echo json_encode(["ok" => $ok]);
