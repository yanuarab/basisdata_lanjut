<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/style.css">

<style>
/* HEADER */
.header {
    width: 100%;
    height: 60px;
    background: #659cd6ff;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    box-sizing: border-box;
}

.logo {
    font-size: 20px;
    font-weight: bold;
}

/* USER AREA */
.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* SVG ICON dalam lingkaran */
.user-info svg {
    width: 38px;
    height: 38px;
    padding: 6px;
    background: white;
    color: #007bff;
    border-radius: 50%;
    box-sizing: border-box;
}

/* TEXT ADMIN */
.user-info span {
    font-size: 18px; /* lebih besar */
    font-weight: 600; /* lebih tebal */
    letter-spacing: 0.5px;
}
</style>
</head>

<body>

<header class="header">

    <div class="header-left">
        <div class="logo">Sistem Manajemen Perpustakaan</div>
    </div>

    <div class="user-info">
        <!-- Tidak ambil dari database, tulis manual -->
        <span>Admin</span>

        <!-- SVG ICON -->
        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round">
            <circle cx="12" cy="8" r="5"/>
            <path d="M20 21a8 8 0 0 0-16 0"/>
        </svg>
    </div>

</header>
