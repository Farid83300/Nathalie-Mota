/////////////////////////////////////////////////////////////////
/////////////// Script de lightbox en JavaScript ///////////////
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer et masquer la lightbox au chargement de la page
    const lightboxOverlay = document.getElementById('lightbox-overlay');
    lightboxOverlay.style.display = 'none';
    
    // Fonction pour attacher les écouteurs d'événements aux boutons plein écran
    function activateLightbox() {
        // Récupérer tous les boutons plein écran de la page
        const fullScreenButtons = document.querySelectorAll('.full-screen');
        
        // Détacher d'abord les écouteurs existants pour éviter les doublons
        fullScreenButtons.forEach(button => {
            button.removeEventListener('click', handleFullScreenClick);
            button.addEventListener('click', handleFullScreenClick);
        });
    }
    
    // Gestionnaire d'événement pour le clic sur les boutons plein écran
    function handleFullScreenClick(e) {
        e.preventDefault(); // Empêcher le comportement par défaut du lien
        
        // Récupérer les attributs data- contenant les informations de l'image
        const imageSrc = this.getAttribute('data-image');
        const reference = this.getAttribute('data-reference');
        const category = this.getAttribute('data-category');

        // Mettre à jour le contenu de la lightbox avec les informations de l'image
        document.getElementById('lightbox-image').setAttribute('src', imageSrc);
        document.getElementById('photo-reference').textContent = 'Référence : ' + reference;
        document.getElementById('photo-category').textContent = 'Catégorie : ' + category;
        
        // Déterminer l'index actuel de l'image pour la navigation
        const photoItems = document.querySelectorAll('.photo-item');
        photoItems.forEach((item, index) => {
            if (item.contains(this)) {
                currentIndex = index; // Mise à jour de l'index global
            }
        });

        // Afficher la lightbox avec une animation fade in
        lightboxOverlay.style.display = 'block';
        setTimeout(() => {
            lightboxOverlay.style.opacity = '1';
        }, 10); // Petit délai pour permettre au navigateur d'appliquer le display avant l'opacité
    }

    // Initialiser la lightbox pour les éléments existants au chargement de la page
    activateLightbox();

    // Utiliser la délégation d'événements pour gérer les clics sur .full-screen
    // Cette approche fonctionne même avec des éléments ajoutés dynamiquement
    document.addEventListener('click', function(e) {
        // Vérifier si l'élément cliqué ou un de ses parents est un .full-screen
        let target = e.target;
        while (target && target !== document) {
            if (target.classList.contains('full-screen')) {
                e.preventDefault();
                handleFullScreenClick.call(target, e);
                return;
            }
            target = target.parentNode;
        }
    });

    /**
     * Écouteur pour fermer la lightbox lors du clic sur la croix
     */
    document.getElementById('close-lightbox').addEventListener('click', function() {
        // Animation de fade out
        lightboxOverlay.style.opacity = '0';
        setTimeout(() => {
            lightboxOverlay.style.display = 'none';
        }, 300); // Délai correspondant à la durée de la transition CSS
    });

    // Variable globale pour suivre l'index de l'image actuellement affichée
    let currentIndex = 0;

    /**
     * Navigation vers l'image précédente
     */
    document.getElementById('prev-photo').addEventListener('click', function() {
        const photoItems = document.querySelectorAll('.photo-item');
        currentIndex--;
        // Boucler vers la fin si on est au début
        if (currentIndex < 0) currentIndex = photoItems.length - 1;
        updateLightboxImage(currentIndex);
    });

    /**
     * Navigation vers l'image suivante
     */
    document.getElementById('next-photo').addEventListener('click', function() {
        const photoItems = document.querySelectorAll('.photo-item');
        currentIndex++;
        // Boucler vers le début si on est à la fin
        if (currentIndex >= photoItems.length) currentIndex = 0;
        updateLightboxImage(currentIndex);
    });

    /**
     * Met à jour le contenu de la lightbox avec l'image à l'index spécifié
     * @param {number} index - L'index de l'image à afficher
     */
    function updateLightboxImage(index) {
        const photoItems = document.querySelectorAll('.photo-item');
        // S'assurer que l'index est valide
        if (photoItems.length === 0) return;
        
        const photo = photoItems[index];
        const fullScreenButton = photo.querySelector('.full-screen');
        
        // Récupérer les données de l'image
        const imageSrc = fullScreenButton.getAttribute('data-image');
        const reference = fullScreenButton.getAttribute('data-reference');
        const category = fullScreenButton.getAttribute('data-category');

        // Mettre à jour l'affichage
        document.getElementById('lightbox-image').setAttribute('src', imageSrc);
        document.getElementById('photo-reference').textContent = 'Référence : ' + reference;
        document.getElementById('photo-category').textContent = 'Catégorie : ' + category;
    }

    /**
     * Configuration du MutationObserver pour détecter les nouvelles photos chargées via AJAX
     */
    const photoContainer = document.querySelector('.photo-display') || document.querySelector('.photos-container');
    if (photoContainer) {
        // Créer un observateur qui va surveiller les modifications du DOM
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                // Vérifier si de nouveaux nœuds ont été ajoutés
                if (mutation.addedNodes && mutation.addedNodes.length > 0) {
                    // Appliquer la lightbox aux nouveaux éléments
                    activateLightbox();
                }
            });
        });
        
        // Démarrer l'observation avec les options spécifiées
        observer.observe(photoContainer, { 
            childList: true, // Observer les ajouts/suppressions d'enfants directs
            subtree: true    // Observer également les modifications dans les enfants
        });
    }
});