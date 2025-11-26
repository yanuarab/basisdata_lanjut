<script>
    const sidebar = document.getElementById('sidebar');
    const header = document.querySelector('.header');
    const content = document.querySelector('.content');
    const toggleBtn = document.getElementById('toggleSidebar');

    toggleBtn.onclick = () => {
        sidebar.classList.toggle('collapsed');
        header.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
    };
</script>

</body>
</html>
