document.addEventListener('DOMContentLoaded', () => {
    handleFavourites();
});

function handleFavourites() {
    const favourites = document.querySelectorAll('.favourite');
    favourites.forEach(favourite => {
        favourite.addEventListener('click', (e) => {
            e.preventDefault();
            handleClickFavourite(favourite);
        });
    });
}

function handleClickFavourite(favourite) {
    const eventItem = favourite.closest('.event-item');
    const eventId = eventItem.getAttribute('event-id');

    if (!eventId) {
        console.error('Event ID not found');
        return;
    }

    const isCurrentlyActive = favourite.classList.contains('active');
    const action = isCurrentlyActive ? 'remove' : 'add';

    // Optimistic UI update
    if (isCurrentlyActive) {
        deactivateFavourite(favourite);
    } else {
        activateFavourite(favourite);
    }

    // Disable button during request
    favourite.style.pointerEvents = 'none';
    favourite.style.opacity = '0.6';

    // AJAX request to PHP
    fetch(ajax_object.ajax_url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'toggle_event_favourite',
            event_id: eventId,
            favourite_action: action,
            nonce: ajax_object.nonce
        })
    })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                // Revert UI changes on error
                if (action === 'add') {
                    deactivateFavourite(favourite);
                } else {
                    activateFavourite(favourite);
                }
                console.error('Error:', data.data);
                alert('Erreur lors de la mise à jour des favoris');
            }
        })
        .catch(error => {
            // Revert UI changes on error
            if (action === 'add') {
                deactivateFavourite(favourite);
            } else {
                activateFavourite(favourite);
            }
            console.error('Network error:', error);
            alert('Erreur de connexion');
        })
        .finally(() => {
            // Re-enable button
            favourite.style.pointerEvents = 'auto';
            favourite.style.opacity = '1';
        });
}

function activateFavourite(favourite) {
    favourite.classList.add('active');
}

function deactivateFavourite(favourite) {
    favourite.classList.remove('active');
}