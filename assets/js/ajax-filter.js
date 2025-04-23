jQuery(function($) {
    /**
     * Initialisation de la bibliothèque Select2 sur tous les sélecteurs de taxonomie
     * Select2 permet d'avoir des menus déroulants plus ergonomiques et personnalisables
     */
    $('.taxonomy-select').select2({
        dropdownParent: $('.filtres_container'), // Force les dropdowns à s'ouvrir dans le conteneur parent pour une meilleure gestion du z-index
        width: '260px',                          // Définit une largeur fixe pour tous les sélecteurs (cohérence UI)
        minimumResultsForSearch: Infinity,       // Désactive la barre de recherche dans les dropdowns
        dropdownAutoWidth: true,                 // Permet au dropdown de s'adapter à la largeur du sélecteur parent si nécessaire
        placeholder: function() {
            // Récupère le texte placeholder depuis l'attribut data-placeholder de l'élément
            return $(this).data('placeholder');
        }
    });
    
    /**
     * Gestionnaire d'événement pour le changement de valeur des filtres
     * Déclenche une requête AJAX à chaque modification d'un filtre
     */
    $('.taxonomy-select').on('change', function() {
        // Objet pour collecter tous les filtres actifs
        const filters = {}; 

        // Parcourt tous les sélecteurs de filtres pour récupérer leurs valeurs
        $('.taxonomy-select').each(function() {
            const taxonomy = $(this).data('taxonomy'); // Nom de la taxonomie WordPress associée
            const filterValue = $(this).val();         // Valeur sélectionnée
            
            // Ajoute le filtre à l'objet uniquement s'il a une valeur et une taxonomie
            if (filterValue && taxonomy) {
                filters[taxonomy] = filterValue;
            } 
            // Traitement spécial pour l'option de tri si présente
            else if ($(this).data('sort') && filterValue) {
                filters['sort'] = filterValue;
            }
        });

        /**
         * Récupère les IDs des photos actuellement affichées dans la galerie
         * Permet de savoir quels éléments sont déjà chargés
         */
        const photoIds = [];
        $('.photo-item').each(function() {
            const photoId = $(this).data('photo-id');
            if (photoId) {
                photoIds.push(photoId);
            }
        });

        /**
         * Configuration et envoi de la requête AJAX à WordPress
         * Utilise l'endpoint défini dans le script PHP associé
         */
        $.ajax({
            url: ajax_filter_obj.ajaxurl,           // URL de l'admin-ajax.php de WordPress (définie dans wp_localize_script)
            method: 'POST',                          // Méthode HTTP pour l'envoi des données
            data: {
                action: 'filtrer_photos',            // Action WordPress qui sera interceptée par add_action('wp_ajax_filtrer_photos', ...)
                filters: filters,                    // Objet contenant tous les filtres actifs
                photoArray: photoIds,                // IDs des photos déjà affichées
                nonce: ajax_filter_obj.nonce         // Token de sécurité WordPress pour vérifier l'authenticité de la requête
            },
            beforeSend: function() {
                // Affiche un indicateur de chargement pendant le traitement de la requête
                $('.photo-display').addClass('loading');
            },
            success: function(response) {
                // Met à jour le conteneur des photos avec le HTML retourné par la requête
                $('.photo-display').html(response);
            },
            complete: function() {
                // Supprime l'indicateur de chargement une fois la requête terminée (succès ou échec)
                $('.photo-display').removeClass('loading');
            }
        });
    });
});