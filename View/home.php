<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="View/style/mainSection.css" rel="stylesheet" type="text/css">
    <link href="View/style/general.css" rel="stylesheet" type="text/css">
    <title>Document</title>
</head>
<body>

<?php if (isset($_SESSION['user'])): ?>
    <div id="welcome-message">
        <h1 style="margin-left: 500px;">Bienvenue, <?php echo htmlspecialchars($_SESSION['user']['firstName']); ?> !</h1>
    </div>
<?php endif; ?>

<?php if (isset($_GET['logout']) && $_GET['logout'] == 'true'): ?>
    <div id="logout-message">
        <h1 style="margin-left: 500px;">Vous avez bien été déconnecté !</h1>
    </div>
<?php endif; ?>

<!-- Monthly box -->
<div id="monthly-box">
    
</div>
<!-- End Monthly Box -->

<div id="newItems">
</div>
</section>
    
</body>
</html>
