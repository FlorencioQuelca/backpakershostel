<?php
// Cambia este correo por el del hostel
$to = "reservas@TUDOMINIO.com";
if ($_SERVER["REQUEST_METHOD"] !== "POST") { http_response_code(405); exit; }
function c($k){ return trim(strip_tags($_POST[$k] ?? "")); }
$email = filter_var(c("email"), FILTER_VALIDATE_EMAIL);
if (!$email || c("name") === "") { http_response_code(400); exit; }
$body = "Nombre: ".c("name")."\nCorreo: $email\nLlegada: ".c("checkin")."\nSalida: ".c("checkout")."\nPersonas: ".c("guests")."\nHabitación: ".c("room")."\n\nMensaje:\n".c("message");
$headers = "From: web@" . ($_SERVER["HTTP_HOST"] ?? "localhost") . "\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";
if (mail($to, "Nueva reserva - Oruro Backpackers", $body, $headers)) { echo "ok"; } else { http_response_code(500); }
