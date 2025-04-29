/**
 * E-Souk Tounsi - Wishlist Functionality
 * Handles wishlist operations only
 */

// Make sure ROOT_URL is defined
if (typeof ROOT_URL === 'undefined') {
    console.error('ROOT_URL is not defined. Please define it before including wishlist.js');
}

/**
 * Initialize wishlist functionality on page load
 */
document.addEventListener('DOMContentLoaded', function() {
    initWishlistButtons();
    initWishlistClearButton();
    wishlist.ensureToastContainer();
});

// Namespace for wishlist functionality
const wishlist = {
    /**
     * Show toast notification (wishlist-specific implementation)
     */
    showToast: function(message, type = 'primary') {
        const container = this.ensureToastContainer();
        
        const toastId = 'wishlist-toast-' + Date.now();
        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        container.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast, { delay: 3000 });
        bsToast.show();
        
        toast.addEventListener('hidden.bs.toast', function() {
            this.remove();
        });
    },
    
    /**
     * Ensure toast container exists
     */
    ensureToastContainer: function() {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            container.style.zIndex = '1050';
            document.body.appendChild(container);
        }
        return container;
    },
    
    /**
     * Get HTML for empty wishlist state
     */
    getEmptyWishlistHTML: function() {
        return `
            <div class="col-12 empty-wishlist">
                <div class="text-center py-5">
                    <i class="far fa-heart wishlist-empty-icon"></i>
                    <h3>Votre liste de favoris est vide</h3>
                    <p>Ajoutez des produits à votre liste pour les retrouver facilement plus tard</p>
                    <a href="${ROOT_URL}public/pages/product.php" class="btn btn-medium mt-3">Découvrir les produits</a>
                </div>
            </div>
        `;
    }
};

/**
 * Initialize all wishlist toggle buttons
 */
function initWishlistButtons() {
    document.querySelectorAll('.wishlist-btn, .wishlist-icon').forEach(button => {
        if (!button.hasAttribute('data-wishlist-initialized')) {
            button.setAttribute('data-wishlist-initialized', 'true');
            
            if (!button.hasAttribute('onclick')) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.getAttribute('data-product-id');
                    toggleWishlist(productId, this);
                });
            }
        }
    });
}

/**
 * Initialize clear wishlist button if it exists
 */
function initWishlistClearButton() {
    const clearButton = document.getElementById('clear-wishlist');
    if (clearButton && !clearButton.hasAttribute('data-wishlist-initialized')) {
        clearButton.setAttribute('data-wishlist-initialized', 'true');
        
        clearButton.addEventListener('click', function() {
            if (confirm('Êtes-vous sûr de vouloir vider votre liste de favoris?')) {
                clearWishlist();
            }
        });
    }
}

/**
 * Toggle product in wishlist
 */
function toggleWishlist(productId, element) {
    const productItem = element.closest('.product-item');
    if (productItem) {
        productItem.classList.add('removing');
    }
    
    fetch(ROOT_URL + 'public/pages/toggle_wishlist.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `product_id=${productId}`,
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update heart icon
            const heartIcon = element.querySelector('i');
            if (heartIcon) {
                heartIcon.classList.toggle('far', data.action !== 'added');
                heartIcon.classList.toggle('fas', data.action === 'added');
            }
            
            // Handle product removal from wishlist page
            if (data.action === 'removed' && productItem) {
                setTimeout(() => {
                    productItem.remove();
                    
                    // Check if wishlist is now empty
                    const container = document.querySelector('.wishlist-container');
                    if (container && document.querySelectorAll('.product-item').length === 0) {
                        container.innerHTML = wishlist.getEmptyWishlistHTML();
                        
                        const clearBtn = document.getElementById('clear-wishlist');
                        if (clearBtn) clearBtn.style.display = 'none';
                    }
                }, 300);
            }
            
            // Update wishlist count badges
            updateWishlistCountBadge(data.wishlist_count || 0);
            
            // Show success message
            wishlist.showToast(
                data.action === 'added' ? 'Produit ajouté aux favoris' : 'Produit retiré des favoris', 
                data.action === 'added' ? 'success' : 'info'
            );
        } else {
            if (productItem) {
                productItem.classList.remove('removing');
            }
            
            wishlist.showToast(data.message || 'Erreur lors de la mise à jour des favoris', 'danger');
            
            if (data.message && data.message.includes('connecté')) {
                setTimeout(() => {
                    window.location.href = ROOT_URL + 'public/pages/login.php?redirect=' + encodeURIComponent(window.location.pathname);
                }, 2000);
            }
        }
    })
    .catch(error => {
        console.error('Wishlist error:', error);
        
        if (productItem) {
            productItem.classList.remove('removing');
        }
        
        wishlist.showToast('Une erreur s\'est produite', 'danger');
    });
}

/**
 * Clear entire wishlist
 */
function clearWishlist() {
    const wishlistContainer = document.querySelector('.wishlist-container');
    if (!wishlistContainer) {
        console.error('Wishlist container not found');
        wishlist.showToast('Erreur lors de la suppression', 'danger');
        return;
    }
    
    const productItems = Array.from(document.querySelectorAll('.product-item'));
    
    if (productItems.length === 0) {
        wishlist.showToast('Aucun produit à supprimer', 'info');
        return;
    }
    
    productItems.forEach(item => {
        item.classList.add('removing');
    });
    
    fetch(ROOT_URL + 'public/pages/clear_wishlist.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            setTimeout(() => {
                wishlistContainer.innerHTML = wishlist.getEmptyWishlistHTML();
                
                const clearBtn = document.getElementById('clear-wishlist');
                if (clearBtn) {
                    clearBtn.style.display = 'none';
                }
                
                updateWishlistCountBadge(0);
                
                wishlist.showToast('Votre liste de favoris a été vidée', 'success');
            }, 300);
        } else {
            productItems.forEach(item => {
                item.classList.remove('removing');
            });
            wishlist.showToast(data.message || 'Erreur lors de la suppression', 'danger');
        }
    })
    .catch(error => {
        console.error('Clear wishlist error:', error);
        
        productItems.forEach(item => {
            item.classList.remove('removing');
        });
        
        wishlist.showToast('Une erreur s\'est produite: ' + error.message, 'danger');
    });
}

/**
 * Update wishlist count badge in navbar
 */
function updateWishlistCountBadge(count) {
    document.querySelectorAll('.wishlist-count').forEach(badge => {
        badge.textContent = count.toString();
        badge.style.display = count > 0 ? 'inline-block' : 'none';
    });
}