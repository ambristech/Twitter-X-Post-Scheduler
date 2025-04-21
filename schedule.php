<?php
require 'vendor/autoload.php';
use Dotenv\Dotenv;
use Abraham\TwitterOAuth\TwitterOAuth;

// API credentials (update with your own)
$consumerKey = 'tf17cF3rlt1N5h4rDj2MtAVSc';
$consumerSecret = 'OpyZMhaaqQI0ANpGu2vBHYk03M8i9imdwdwgsqDqU7Dm3oYc1D';
//$accessToken = '1854825590555344896-CtFWvuV1zQb5NVXiYoiE9PRexPfymR';
//$accessTokenSecret = 'OkEp18ZJBOaU5vOEhunLV6IrPPwpU2sHXcT3NtFQ4KZFo';
$accessToken = '1854825590555344896-2iiHUlN5EOWThge2o3fOTXpSVhwVsu';
$accessTokenSecret = 'TlZcLJ1LFtKvkUa5KVsxfwuoRkI4IlxowyM5xNJC0EUcs';

// Database connection
try {
    $db = new PDO('mysql:host=localhost;dbname=x_scheduler', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Initialize TwitterOAuth
$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

// Handle POST requests for scheduling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['posts'])) {
    $responses = [];

    foreach ($_POST['posts'] as $index => $post) {
        $text = trim($post['text']);
        $scheduleTime = $post['schedule_time'];

        if (empty($text) || empty($scheduleTime)) {
            $responses[] = "Post $index: Missing text or schedule time.";
            continue;
        }

        $scheduleTimestamp = strtotime($scheduleTime);
        if ($scheduleTimestamp <= time()) {
            $responses[] = "Post $index: Schedule time must be in the future.";
            continue;
        }

        $stmt = $db->prepare("INSERT INTO scheduled_posts (text, schedule_time) VALUES (?, ?)");
        $stmt->execute([$text, $scheduleTime]);
        $responses[] = "Post $index: Scheduled successfully for $scheduleTime.";
    }

    // Output responses
    echo '<h1>Schedule Results</h1><ul>';
    foreach ($responses as $response) {
        echo "<li>$response</li>";
    }
    echo '</ul><a href="index.html">Schedule More Posts</a>';
}

// Function to post scheduled tweets
function postScheduledTweets() {
    global $connection, $db;
    $stmt = $db->query("SELECT * FROM scheduled_posts WHERE schedule_time <= NOW() AND status = 'pending'");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($posts as $post) {
        try {
            $result = $connection->post('tweets', ['text' => $post['text']]);
            if (isset($result->data->id)) {
                $db->prepare("UPDATE scheduled_posts SET status = 'posted' WHERE id = ?")->execute([$post['id']]);
                echo "Posted: {$post['text']}<br>";
            } else {
                $db->prepare("UPDATE scheduled_posts SET status = 'failed' WHERE id = ?")->execute([$post['id']]);
                echo "Failed to post: {$post['text']}<br>";
            }
        } catch (Exception $e) {
            $db->prepare("UPDATE scheduled_posts SET status = 'failed' WHERE id = ?")->execute([$post['id']]);
            echo "Error posting: {$e->getMessage()}<br>";
        }
    }
}

// Run postScheduledTweets if called directly (e.g., via cron.php)
if (basename($_SERVER['PHP_SELF']) === 'cron.php' || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    postScheduledTweets();
}
?>