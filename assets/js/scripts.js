
document.addEventListener('DOMContentLoaded', function() {
    // Sélectionne le lien "Contact" dans le menu principal
    const contactLinks = document.querySelectorAll('.menu-header a[href*="contact"], a[href="#contact"]');
    const modal = document.getElementById('contactModal');
    
    // Ajoute l'écouteur d'événements à tous les liens de contact
    contactLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Empêche la navigation vers la page de contact
            modal.style.display = 'block';
        });
    });
    
    // Fermer la modale en cliquant à l'extérieur
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});


