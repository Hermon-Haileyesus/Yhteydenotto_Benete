<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = htmlspecialchars($_POST["name"]);
  $phone = htmlspecialchars($_POST["phone"]);
  $consent = isset($_POST["consent"]);

  if ($consent) {
    $entry = "$name, $phone\n";
    file_put_contents("contacts.txt", $entry, FILE_APPEND | LOCK_EX);
    echo "Thank you! We’ll be in touch.";
  } else {
    echo "Consent is required.";
  }
} else {
  echo "Invalid request.";
}
?>

