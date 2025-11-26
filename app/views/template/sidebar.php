<style>
/* ------------------------------ */
/* SIDEBAR BASE */
/* ------------------------------ */

.sidebar {
    position: fixed;
    top: 60px;
    left: 0;
    width: 250px;
    height: calc(100vh - 60px);
    
    background: rgba(230,230,230,0.45);
    backdrop-filter: blur(20px);

    padding-top: 25px;
    transition: width 0.3s ease;
    overflow: hidden;
    z-index: 50;
}

.sidebar.collapsed {
    width: 70px;
}

/* ------------------------------ */
/*  GLOW CIRCLES */
/* ------------------------------ */

.circle {
    position: absolute;
    width: 160px;
    height: 160px;
    border-radius: 50%;
    filter: blur(110px);
    opacity: 1;
    z-index: -1;
}

.circle.top {
    top: -60px;
    left: -50px;
    background: rgb(198,110,82);
}

.circle.bottom {
    bottom: -60px;
    left: -50px;
    background: rgb(138,190,185);
}

/* ------------------------------ */
/* SIDEBAR MENU */
/* ------------------------------ */

#toggleSidebar {
    background: none;
    border: none;
    font-size: 22px;
    margin-left: 18px;
    cursor: pointer;
    color: #333;
    position: relative;
    z-index: 5;
}

.menu {
    margin-top: 30px;
    list-style: none;
    padding: 0;
    position: relative;
    z-index: 5;
}

.menu li {
    margin-bottom: 12px;
}

.menu a {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 20px;
    text-decoration: none;
    font-size: 16px;
    color: #222;
    transition: 0.3s;
}

.menu a:hover {
    background: rgba(0,0,0,0.08);
    border-radius: 8px;
}

.sidebar.collapsed .menu a span {
    display: none;
}

.sidebar.collapsed .menu a {
    justify-content: center;
    padding: 12px 0;
}
</style>

<aside class="sidebar" id="sidebar">

    <!-- GLOW CIRCLES -->
    <div class="circle top"></div>
    <div class="circle bottom"></div>

    <button id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <ul class="menu">

        <li>
            <a href="<?= BASE_URL ?>dashboard">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>buku">
                <i class="fas fa-book"></i>
                <span>Data Buku</span>
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>anggota">
                <i class="fas fa-users"></i>
                <span>Data Anggota</span>
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>peminjaman">
                <i class="fas fa-handshake"></i>
                <span>Peminjaman</span>
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>laporan">
                <i class="fas fa-file"></i>
                <span>Laporan</span>
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>

</aside>

<script>
document.getElementById("toggleSidebar").onclick = function() {
    document.getElementById("sidebar").classList.toggle("collapsed");
};
</script>