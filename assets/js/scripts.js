///////////////////////////////////////////
///////////// JS de la Modale /////////////
document.addEventListener('DOMContentLoaded', function() {
    // Sélecteurs pour les éléments de contact et la modale
    const contactLinks = document.querySelectorAll('.menu-header a[href*="contact"], a[href="#contact"]');
    const refBtn = document.getElementById('ref-btn');
    const modal = document.getElementById('contactModal');
    
    // Liens de contact standard - juste ouvrir la modale
    contactLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            modal.style.display = 'block';
        });
    });
    // Ouverture Modale avec ajout Référence Photo en cliquant sur le Bouton Contact
    if (refBtn) {
        refBtn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.style.display = 'block';
            // Récupérer la référence depuis l'attribut data-ref du bouton
            const photoRef = this.getAttribute('data-ref');
            setTimeout(function() {
                const refPhotoField = document.getElementById('ref-photo');
                if (refPhotoField && photoRef) {
                    refPhotoField.value = photoRef;
                }
            }, 300);
        });
    }
    // Fermer la modale en cliquant à l'extérieur
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});


///////////////////////////////////////////////////////////////
///////////// jQuery de la Miniature SINGLE-PHOTO /////////////
jQuery(document).ready(function ($) {
    let currentIndex = 0; 
    let targetUrl = photoData.photo_ids[currentIndex];
    let savedIndex = currentIndex; // Variable pour sauvegarder l'index actuel

    // Fonction qui met à jour la miniature affichée
    function updateThumbnail(index) {
        // Récupère l'URL de la miniature correspondant à l'index fourni
        var thumbnailUrl = photoData.thumbnails[index];
        // Met à jour l'URL cible pour le clic
        targetUrl = photoData.photo_ids[index];
        // Change l'image de fond de l'élément #miniaturePhoto
        $("#miniaturePhoto").css("background-image", "url('" + thumbnailUrl + "')");
        // Met à jour l'attribut href de l'élément
        $("#miniaturePhoto").attr("href", targetUrl);
    }

    // Appel initial pour afficher la première miniature
    updateThumbnail(currentIndex);

    // Gestion du survol sur la flèche gauche
    $(".arrow-left").on("mouseenter", function () {
        // Sauvegarde l'index actuel avant de changer
        savedIndex = currentIndex;
        // Calcule l'index précédent pour le survol
        let hoverIndex = (currentIndex - 1 + photoData.thumbnails.length) % photoData.thumbnails.length;
        // Met à jour temporairement l'affichage pendant le survol
        updateThumbnail(hoverIndex);
    }).on("mouseleave", function () {
        // Restaure l'affichage de la miniature originale quand on quitte le survol
        updateThumbnail(savedIndex);
    }).on("click", function () {
        // Met à jour l'index actuel lors du clic
        currentIndex = (currentIndex - 1 + photoData.thumbnails.length) % photoData.thumbnails.length;
        // Met à jour l'index sauvegardé également
        savedIndex = currentIndex;
        // Met à jour l'affichage définitivement
        updateThumbnail(currentIndex);
    });

    // Gestion du survol sur la flèche droite
    $(".arrow-right").on("mouseenter", function () {
        // Sauvegarde l'index actuel avant de changer
        savedIndex = currentIndex;
        // Calcule l'index suivant pour le survol
        let hoverIndex = (currentIndex + 1) % photoData.thumbnails.length;
        // Met à jour temporairement l'affichage pendant le survol
        updateThumbnail(hoverIndex);
    }).on("mouseleave", function () {
        // Restaure l'affichage de la miniature originale quand on quitte le survol
        updateThumbnail(savedIndex);
    }).on("click", function () {
        // Met à jour l'index actuel lors du clic
        currentIndex = (currentIndex + 1) % photoData.thumbnails.length;
        // Met à jour l'index sauvegardé également
        savedIndex = currentIndex;
        // Met à jour l'affichage définitivement
        updateThumbnail(currentIndex);
    });

    // Gestion du clic sur la miniature
    $("#miniaturePhoto").on("click", function (e) {
        e.preventDefault();
        // Redirige vers l'URL cible correspondant à l'image actuelle
        window.location.href = targetUrl;
    });
});