document.addEventListener("DOMContentLoaded", function () {
    // Sélectionner les éléments nécessaires
    const burger = document.querySelector(".burger-menu");
    const navMenu = document.querySelector("#site-navigation"); // Utiliser l'ID à la place de la classe
    const navLinks = document.querySelectorAll("#site-navigation a");
    
    // Vérifier si les éléments existent pour éviter les erreurs
    if (burger && navMenu) {
        // Écouteur d'événement pour le clic sur le burger
        burger.addEventListener("click", function (e) {
            e.preventDefault();
            
            // Toggle des classes active
            burger.classList.toggle("active");
            navMenu.classList.toggle("active");
            
            // Option: bloquer le défilement du body quand le menu est ouvert
            document.body.classList.toggle("menu-open");
        });
        
        // Fermer le menu en cliquant sur un lien
        if (navLinks) {
            navLinks.forEach(function (link) {
                link.addEventListener("click", function () {
                    burger.classList.remove("active");
                    navMenu.classList.remove("active");
                    document.body.classList.remove("menu-open");
                });
            });
        }
        
        // Fermer le menu en cliquant à l'extérieur
        document.addEventListener("click", function (e) {
            if (navMenu.classList.contains("active") && 
                !burger.contains(e.target) && 
                !navMenu.contains(e.target)) {
                burger.classList.remove("active");
                navMenu.classList.remove("active");
                document.body.classList.remove("menu-open");
            }
        });
    }
});