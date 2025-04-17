///////////// Script AJAX de chargement pour le bouton "Charger Plus" /////////////
document.addEventListener('DOMContentLoaded', function() {
    // Variables pour suivre la pagination
    let currentPage = 1;
    let isLoading = false;
    const loadMoreBtn = document.getElementById('btnLoad-more');
    const photoContainer = document.querySelector('#photo-display .photo-display');

    // Gére le clic sur le bouton "Charger Plus"
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            // Évite les requêtes multiples si une est déjà en cours
            if (isLoading) return;
            isLoading = true;

            // Incrémentation de la page
            currentPage++;

            // Change le texte du bouton pendant le chargement
            loadMoreBtn.textContent = 'Chargement...';

            // Création de l'objet FormData pour les données de la requête
            const formData = new FormData();
            formData.append('action', 'load_more_photos');
            formData.append('nonce', motaphoto_ajax.nonce);
            formData.append('page', currentPage);

            // Requête fetch pour remplacer $.ajax
            fetch(motaphoto_ajax.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau: ' + response.status);
                }
                return response.text();
            })
            .then(data => {
                // Ajoute les nouvelles photos directement au conteneur existant
                photoContainer.insertAdjacentHTML('beforeend', data);
                
                // Réinitialise le texte du bouton
                loadMoreBtn.textContent = 'Charger Plus';
                isLoading = false;
            })
            .catch(error => {
                console.error('Erreur AJAX:', error);
                loadMoreBtn.textContent = 'Charger Plus';
                isLoading = false;
            });
        });
    }
});