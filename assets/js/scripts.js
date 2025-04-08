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
    
    // Bouton de référence - ouvrir modale et ajouter référence photo
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



///////////// JS de la Miniature SINGLE-PHOTO /////////////
jQuery(document).ready(function ($) {
    let currentIndex = 0; 
    let targetUrl = photoData.photo_ids[currentIndex];

    function updateThumbnail() {
        var thumbnailUrl = photoData.thumbnails[currentIndex];
        targetUrl = photoData.photo_ids[currentIndex];
        $("#miniaturePhoto").css("background-image", "url('" + thumbnailUrl + "')");
        $("#miniaturePhoto").attr("href", targetUrl);
    }

    updateThumbnail();

    $(".arrow-left").on("click", function () {
        currentIndex = (currentIndex - 1 + photoData.thumbnails.length) % photoData.thumbnails.length;
        updateThumbnail();
    });

    $(".arrow-right").on("click", function () {
        currentIndex = (currentIndex + 1) % photoData.thumbnails.length;
        updateThumbnail();
    });

    $("#miniaturePhoto").on("click", function (e) {
        e.preventDefault();
        window.location.href = targetUrl;
    });
});