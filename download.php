<?php
// download.php
// Define the downloads folder
$downloadFolder = "downloads";
if (!file_exists($downloadFolder)) {
    mkdir($downloadFolder, 0777, true);
} 
 
// Check if the form is submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Agar form data JSON ke bajaye traditional POST form se aa raha hai, to:
    $url = isset($_POST['url']) ? trim($_POST['url']) : '';

    if (empty($url)) {
        echo "Error: No URL provided.";
        exit;
    }

    $outputPattern = $downloadFolder . DIRECTORY_SEPARATOR . '%(title)s.%(ext)s';
    $command = "yt-dlp -f best -o " . escapeshellarg($outputPattern) . " " . escapeshellarg($url);

    exec($command, $output, $returnVar);

    if ($returnVar === 0) {
        echo "Download started successfully!";
    } else {
        echo "Failed to download video. Details: " . implode("\n", $output);
    }
} else {
    echo "Invalid request method.";
}
?>

