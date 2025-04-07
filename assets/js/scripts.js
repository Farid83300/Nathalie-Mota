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
            
            setTimeout(function() {
                const refPhotoField = document.getElementById('ref-photo');
                
                if (refPhotoField) {
                    // Supposons que la référence est dans un élément spécifique
                    // Si vous avez un élément HTML qui contient uniquement le code de référence, utilisez-le directement
                    const refElement = document.querySelector('.reference');
                    
                    if (refElement) {
                        // Extraire uniquement la valeur de référence sans le texte "RÉFÉRENCE:"
                        const fullText = refElement.textContent;
                        const referenceValue = fullText.includes(':') ? 
                            fullText.split(':')[1].trim() : 
                            fullText.trim();
                            
                        refPhotoField.value = referenceValue;
                    }
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