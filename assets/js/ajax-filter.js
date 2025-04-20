jQuery(function($) {
    // Initialisation de select2 sur tous les éléments .taxonomy-select
    $('.taxonomy-select').select2({
        dropdownParent: $('.filtres_container'), // Attacher les dropdowns directement au container des filtres
        width: '260px', // Fixer la largeur du dropdown pour qu'elle corresponde à celle du select
        minimumResultsForSearch: Infinity, // Désactiver la recherche
        dropdownAutoWidth: true // S'adapter à la largeur du select parent
    });
    
    // Lorsque l'un des filtres est modifié
    $('.taxonomy-select').on('change', function() {
        var filters = {}; // Objet pour stocker tous les filtres

        // Je récupère tous les filtres de mon CPT UI WP
        $('.taxonomy-select').each(function() {
            var taxonomy = $(this).data('taxonomy'); // Récupère la taxonomie depuis l'attribut data-taxonomy
            var filterValue = $(this).val();
            
            if (filterValue && taxonomy) {
                filters[taxonomy] = filterValue;
            } else if ($(this).data('sort') && filterValue) {
                // Gestion du tri si présent
                filters['sort'] = filterValue;
            }
        });

        // Récupérer les IDs des photos déjà affichées
        var photoIds = [];
        $('.photo-item').each(function() {
            var photoId = $(this).data('photo-id');
            if (photoId) {
                photoIds.push(photoId);
            }
        });

        // Requête AJAX
        $.ajax({
            url: ajax_filter_obj.ajaxurl,
            method: 'POST',
            data: {
                action: 'filtrer_photos',
                filters: filters,
                photoArray: photoIds,
                nonce: ajax_filter_obj.nonce // Ajouter le nonce pour la sécurité
            },
            beforeSend: function() {
                // Optionnel : afficher un indicateur de chargement
                $('.photo-display').addClass('loading');
            },
            success: function(response) {
                $('.photo-display').html(response);
            },
            complete: function() {
                // Optionnel : supprimer l'indicateur de chargement
                $('.photo-display').removeClass('loading');
            }
        });
    });
});