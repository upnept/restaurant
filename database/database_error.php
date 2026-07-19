<?php include 'views/layout/header.php'; ?>

<main>
    <h1>Database Error</h1>
    <p>There was an error connecting to the restaurant database</p>
    <p>Error msg: <?php echo $error_message; ?></p>
    <p>&nbsp;</p>
</main>

<?php include 'views/layout/footer.php'; ?>