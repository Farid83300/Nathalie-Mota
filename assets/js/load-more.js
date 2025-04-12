// Script de chargement AJAX pour le bouton "Charger Plus"
jQuery(document).ready(function($) {
    // Variables pour suivre la pagination
    let currentPage = 1;
    let isLoading = false;
    // Sélectionner le bouton "Charger Plus"
    const loadMoreBtn = $('#btnLoad-more');
    const photoContainer = $('#photo-display .photo-display');
    
    // Vérifier si le conteneur existe
    if (photoContainer.length === 0) {
        console.error("Erreur: Le conteneur .photo-display n'a pas été trouvé");
        return;
    }
    
    // Gérer le clic sur le bouton "Charger Plus"
    loadMoreBtn.on('click', function() {
        // Éviter les requêtes multiples si une est déjà en cours
        if (isLoading) return;
        
        isLoading = true;
        currentPage++;
        
        // Changer le texte du bouton pendant le chargement
        loadMoreBtn.text('Chargement...');
        
        // Requête AJAX pour récupérer plus de photos
        $.ajax({
            url: motaphoto_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'load_more_photos',
                nonce: motaphoto_ajax.nonce,
                page: currentPage
            },
            success: function(response) {
                // Ajouter les nouvelles photos directement au conteneur existant
                photoContainer.append(response);
                
                // Réinitialiser le texte du bouton
                loadMoreBtn.text('Charger Plus');
                
                isLoading = false;
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX:', error);
                loadMoreBtn.text('Charger Plus');
                isLoading = false;
            }
        });
    });
});