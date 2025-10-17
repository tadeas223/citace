<?php
session_start();

// Initialize messages array in session if not set
if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = [];
}

// When form is submitted
if (isset($_POST['message']) && trim($_POST['message']) !== '') {
    $msg = htmlspecialchars(trim($_POST['message']));
    $_SESSION['messages'][] = $msg;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Simple Chat</title>
</head>
<body>
    <h2>Simple PHP Chat</h2>
    <form method="post">
        <input type="text" name="message" placeholder="Type your message" autofocus required />
        <button type="submit">Send</button>
    </form>

    <h3>Messages:</h3>
    <div style="border:1px solid #ccc; padding:10px; width:300px; height:200px; overflow-y:scroll;">
        <?php
        foreach ($_SESSION['messages'] as $message) {
            echo htmlspecialchars($message) . "<br>";
        }
        ?>
    </div>
</body>
</html>
