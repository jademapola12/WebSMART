<?php
require_once('./config.php');
session_start();

if (isset($_SESSION['search_query'])) {
    $searchQuery = trim($conn->real_escape_string($_SESSION['search_query']));

    if ($searchQuery !== '') {
        // Get all active titles from the database (removed the tag part)
        $fetchSql = "SELECT id, title FROM archive_list WHERE status = 1";
        $result = $conn->query($fetchSql);

        if ($result->num_rows > 0) {
            // Convert the search query into UPPERCASE words
            $searchWords = preg_split('/\s+/', strtoupper($searchQuery));
            $searchWords = array_filter($searchWords, function($word) {
                return strlen($word) >= 2; // Only keep words with 2+ characters
            });

            $bestMatchId = null;

            while ($row = $result->fetch_assoc()) {
                // Convert the title into UPPERCASE
                $title = strtoupper($row['title']);
                $titleWords = preg_split('/\s+/', $title);
                $titleWords = array_filter($titleWords, function($word) {
                    return strlen($word) >= 2; // Only keep words with 2+ characters
                });

                // Check if the search query exactly matches the title
                $commonWords = array_intersect($searchWords, $titleWords);

                // If there's an exact match, only increment the count once for this record
                if (!empty($commonWords) && implode(' ', $commonWords) === strtoupper($searchQuery)) {
                    $bestMatchId = $row['id'];
                    break; // Once a match is found, exit the loop (no need for further checks)
                }
            }

            // If an exact match was found, increment the search count for that record
            if ($bestMatchId !== null) {
                $updateSql = "UPDATE archive_list SET search_count = search_count + 1 WHERE id = " . intval($bestMatchId);
                $conn->query($updateSql);
            }
        }
    }

    // Unset the session variable to avoid repeated increments on subsequent requests
    unset($_SESSION['search_query']);
}
?>
