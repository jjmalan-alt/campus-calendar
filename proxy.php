<?php
// 1. Define allowed URLs to keep your proxy secure
$allowed_urls = [
    'wcs' => 'https://schoolbox.collegiate.school.nz/calendar/export.php?export=group&group=1139&event_type=&token=57bbf17cee18b093bc40299ad',
    'stg' => 'https://stgeorges-portal.school.kiwi/ics/school.ics'
];

// 2. Get the requested feed ID from the URL (e.g., proxy.php?id=wcs)
$id = $_GET['id'] ?? '';

if (array_key_exists($id, $allowed_urls)) {
    // 3. Set headers so the browser treats this as a legitimate calendar file
    header('Content-Type: text/calendar; charset=utf-8');
    header('Access-Control-Allow-Origin: *'); 
    
    // 4. Fetch the data from the school server
    $content = file_get_contents($allowed_urls[$id]);
    
    if ($content === false) {
        header("HTTP/1.1 502 Bad Gateway");
        echo "Error: Could not reach school server.";
    } else {
        echo $content;
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    echo "Invalid Feed ID";
}
?>
