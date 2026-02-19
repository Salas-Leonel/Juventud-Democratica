// Resaltar enlace del menú según la sección visible
(function() {
    const sections = document.querySelectorAll("section[id]");
    const navLinks = document.querySelectorAll(".nav-links a");

    function highlightLink() {
        let current = "";
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            const sectionHeight = section.clientHeight;
            if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                current = section.getAttribute("id");
            }
        });

        navLinks.forEach(link => {
            link.style.borderBottomColor = "transparent";
            if (link.getAttribute("href") === `#${current}`) {
                link.style.borderBottomColor = "#74c0fc";
            }
        });
    }

    window.addEventListener("scroll", highlightLink);
    window.addEventListener("load", highlightLink);

    // Smooth scroll interno al hacer clic en los enlaces
    navLinks.forEach(link => {
        link.addEventListener("click", function(e) {
            e.preventDefault();
            const targetId = this.getAttribute("href");
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: "smooth" });
            }
        });
    });
})();