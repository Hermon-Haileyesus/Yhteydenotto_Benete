
<?php
session_start();
date_default_timezone_set('Europe/Helsinki');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $countryCode = htmlspecialchars(trim($_POST["countryCode"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));
    
    $consent = isset($_POST["consent"]);

    // Validate phone number
    if (!preg_match('/^\+?[0-9\s\-]{7,15}$/', $phone)) {
        $_SESSION['error'] = "Puhelinnumeron muoto on virheellinen.";
        $_SESSION['name'] = $name;
        $_SESSION['phone'] = $phone;
        header("Location: index.html");
        exit;
    }
    $fullPhone = $countryCode . $phone; // combine for validation
    $digitsOnly = preg_replace('/\D/', '', $fullPhone);

    if (strlen($digitsOnly) < 9 || strlen($digitsOnly) > 15) {
          $_SESSION['error'] = "Puhelinnumeron pituus on virheellinen.";
          $_SESSION['name'] = $name;
          $_SESSION['phone'] = $phone;
          header("Location: index.html");
          exit;
}

// Store with space for readability
  $fullPhone = $countryCode . " " . $phone;
  if ($consent) {
        require_once 'connection.php'; // ✅ Include your PDO connection

        $timestamp = date("Y-m-d H:i:s");

        try {
            $stmt = $conn->prepare("INSERT INTO contacts (name, phone, timestamp) VALUES (?, ?, ?)");
            $stmt->execute([$name, $fullPhone, $timestamp]);

            $_SESSION['success'] = "Kiitos! Otamme sinuun yhteyttä.";
            header("Location: thanks.html");
        } catch (PDOException $e) {
            $_SESSION['error'] = "Tietojen tallennus epäonnistui.";
            header("Location: index.html");
        }
        exit;
    } else {
        $_SESSION['error'] = "Suostumus on pakollinen.";
        $_SESSION['name'] = $name;
        $_SESSION['phone'] = $phone;
        header("Location: index.html");
        exit;
    }
} else {
    $_SESSION['error'] = "Virheellinen pyyntö.";
    header("Location: index.html");
    exit;
}
?>


