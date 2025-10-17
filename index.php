<?php
require 'vendor/autoload.php'; // Composer autoload

use MongoDB\Client;

// MongoDB connection
$client = new Client("mongodb://localhost:27017"); // Change if needed
$db = $client->selectDatabase('chatdb');  // Database name
$collection = $db->selectCollection('messages');  // Collection name

// Handle new message post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['message']))) {
    $message = trim($_POST['message']);
    $collection->insertOne([
        'message' => htmlspecialchars($message),
        'created_at' => new MongoDB\BSON\UTCDateTime()
    ]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch last 50 messages sorted by newest first
$messages = $collection->find([], ['sort' => ['created_at' => -1], 'limit' => 50]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>MongoDB PHP Chat</title>
</head>
<body>
    <h2>MongoDB PHP Chat</h2>

    <form method="post">
        <input type="text" name="message" placeholder="Type your message" autofocus required />
        <button type="submit">Send</button>
    </form>

    <h3>Messages:</h3>
    <div style="border:1px solid #ccc; padding:10px; width:400px; height:300px; overflow-y:scroll;">
        <?php
        foreach ($messages as $msg) {
            echo "<div>" . htmlspecialchars($msg['message']) . "</div>";
        }
        ?>
    </div>
</body>
</html>
