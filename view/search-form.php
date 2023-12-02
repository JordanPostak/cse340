<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/base.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/ico" href="../images/site/logo.png">
    <title>PHP Motors - Search</title>
</head>
<body>
    <div class="border">
        <header>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
        </header>
        <nav>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/navigation.php'; ?> 
        </nav>
        <main>
            <div class="search">
                <h1>Search PHP Motors Inventory</h1>
                <form action="/phpmotors/search/index.php" method="post">
                    <label for="searchQuery">Search:</label>
                    <input type="text" id="searchQuery" name="searchQuery" required>
                    <button type="submit">Search</button>
                    <input type="hidden" name="action" value="performSearch">
                </form>
            </div>
            <hr>    
            <div class="result">
            <?php
        // Include the search results if available
        if (!empty($searchResults)) {
            $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
            // Use the correct total pages value passed from performSearch
            echo displaySearchResults($searchResults, $currentPage, $totalPages);
        }
        ?>
            </div>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
        <script src="/phpmotors/scripts/last_updated.js"></script>
    </div>
</body>
</html>