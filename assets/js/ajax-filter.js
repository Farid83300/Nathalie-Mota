//////////////////////////////////////////////////////////////////////
///////////////// Script pour le filtrage des Photos ////////////////
jQuery(function($) {
    /**
     * Initialisation de la bibliothèque Select2 sur tous les sélecteurs de taxonomie
     * Select2 permet d'avoir des menus déroulants plus ergonomiques et personnalisables
     */
    $('.taxonomy-select').select2({
        dropdownParent: $('.filtres_container'), 
        width: '260px',                         
        minimumResultsForSearch: Infinity,      
        dropdownAutoWidth: true,              
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
            const taxonomy = $(this).data('taxonomy'); 
            const filterValue = $(this).val();        
            
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
            url: ajax_filter_obj.ajaxurl,          
            method: 'POST',                          
            data: {
                action: 'filtrer_photos',            
                filters: filters,                    
                photoArray: photoIds,                
                nonce: ajax_filter_obj.nonce         
            },
            success: function(response) {
                // Met à jour le conteneur des photos avec le HTML retourné par la requête
                $('.photo-display').html(response);
            },
        });
    });
});