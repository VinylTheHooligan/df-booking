document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const hideBtn = document.getElementById("sidebarHideBtn");
    const showBtn = document.getElementById("sidebarShowBtn");

    // Cacher la sidebar (desktop)
    if (hideBtn) {
        hideBtn.addEventListener("click", () => {
            sidebar.classList.add("hidden");
            if (showBtn) showBtn.style.display = "block";
        });
    }

    // Réafficher la sidebar (desktop)
    if (showBtn) {
        showBtn.addEventListener("click", () => {
            sidebar.classList.remove("hidden");
            showBtn.style.display = "none";
        });
    }

    // Mobile : transformer en offcanvas
    function adaptSidebar() {
        if (window.innerWidth < 768) {
            sidebar.classList.add("offcanvas", "offcanvas-start");
        } else {
            sidebar.classList.remove("offcanvas", "offcanvas-start", "show");
        }
    }

    adaptSidebar();
    window.addEventListener("resize", adaptSidebar);
});
