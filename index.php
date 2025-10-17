<?php
// File to store chat messages
$messagesFile = 'messages.txt';

// Handle new message submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    // Sanitize the input to prevent HTML injection
    $msg = strip_tags(trim($_POST['message']));
    $msg = htmlspecialchars($msg, ENT_QUOTES, 'UTF-8');

    // Append the message with a timestamp
    $entry = date('Y-m-d H:i:s') . ' - ' . $msg . PHP_EOL;

    // Save to file (append mode)
    file_put_contents($messagesFile, $entry, FILE_APPEND | LOCK_EX);

    // Redirect to avoid resubmission on reload
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Load existing messages
$messages = '';
if (file_exists($messagesFile)) {
    $messages = file_get_contents($messagesFile);
    // Convert new lines to <br> for display
    $messages = nl2br($messages);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Simple PHP Chat</title>
</head>
<body>
    <h1>Simple PHP Chat</h1>

    <div style="border:1px solid #ccc; padding:10px; width: 400px; height: 300px; overflow-y: scroll; background:#f9f9f9;">
        <?= $messages ?: 'No messages yet.' ?>
    </div>

    <form method="post" action="">
        <input type="text" name="message" placeholder="Type your message" required style="width:300px;" />
        <button type="submit">Send</button>
    </form>
</body>
</html>
