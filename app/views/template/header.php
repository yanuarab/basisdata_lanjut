<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS Utama -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/style.css">


</head>
<body>

<header class="header">
    <div class="header-left">
        <div class="logo">📚 Perpustakaan</div>
    </div>

    <div class="user-info">
        <span><?= $_SESSION['admin']['username']; ?></span>
        <div class="avatar"><?= strtoupper($_SESSION['admin']['username'][0]); ?></div>
    </div>
</header>
