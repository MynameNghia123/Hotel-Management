let ICON_LIST = [];

// Fetch icon list từ Google Material Symbols
async function fetchIconList() {
    try {
        // Fetch từ GitHub Material Symbols repo
        const response = await fetch('https://raw.githubusercontent.com/google/material-design-icons/master/font/MaterialIcons-Regular.codepoints');
        
        if (response.ok) {
            const text = await response.text();
            // Parse icon names từ codepoints file
            const lines = text.split('\n').filter(line => line.trim());
            ICON_LIST = lines.map(line => line.split(' ')[0]).sort();
        } else {
            ICON_LIST = getDefaultIconList();
        }
    } catch (error) {
        console.warn('Failed to fetch icons from API, using default list:', error);
        ICON_LIST = getDefaultIconList();
    }
}

// Danh sách icon mặc định nếu API không khả dụng
function getDefaultIconList() {
    return [
        'wifi', 'bath', 'wind', 'truck', 'activity', 'droplet', 'tv', 'kitchen', 'pool', 'home',
        'bed', 'sofa', 'door', 'key', 'lock', 'air', 'water_heater', 'thermostat', 'light_mode',
        'dark_mode', 'sunny', 'cloud', 'waves', 'restaurant', 'local_cafe', 'local_bar',
        'fitness_center', 'sports_basketball', 'sports_tennis', 'sports_golf', 'sports_soccer',
        'pool_2', 'hot_tub', 'spa', 'shopping_cart', 'shopping_bag', 'shopping_mall',
        'store', 'local_pharmacy', 'local_florist', 'local_pizza', 'local_dining',
        'emoji_food_beverage', 'local_laundry_service', 'dry_cleaning', 'local_parking',
        'directions_car', 'directions_bike', 'directions_walk', 'public_transportation',
        'flight', 'hotel', 'vacation', 'beach_access', 'forest', 'hiking', 'surfing',
        'music_note', 'movie', 'games', 'sports_bar', 'nightlife', 'casino', 'theater_comedy',
        'event', 'calendar_month', 'schedule', 'access_time', 'more_horiz', 'info',
        'help', 'check_circle', 'checkmark', 'close', 'delete', 'edit', 'star', 'favorite'
    ];
}

document.addEventListener('DOMContentLoaded', async function() {
    // Fetch icon list từ API
    await fetchIconList();
    const iconInput = document.getElementById('iconInput');
    
    if (!iconInput) return;
    
    const iconPreview = document.getElementById('iconPreview');
    const iconSuggestions = document.getElementById('iconSuggestions');

    // Show preview in real-time
    iconInput.addEventListener('input', function() {
        const value = this.value.toLowerCase().trim();
        
        // Update preview
        if (value) {
            iconPreview.textContent = value;
        } else {
            iconPreview.textContent = '';
        }

        // Update suggestions
        if (value.length > 0) {
            const filtered = ICON_LIST.filter(icon => icon.includes(value));
            showSuggestions(filtered);
        } else {
            iconSuggestions.classList.remove('active');
        }
    });

    function showSuggestions(icons) {
        if (icons.length === 0) {
            iconSuggestions.classList.remove('active');
            return;
        }

        const html = icons.map(icon => `
            <div class="icon-suggestion-item" onclick="selectIcon('${icon}')">
                <span class="icon-display">${icon}</span>
                <span>${icon}</span>
            </div>
        `).join('');

        iconSuggestions.innerHTML = html;
        iconSuggestions.classList.add('active');
    }

    window.selectIcon = function(icon) {
        iconInput.value = icon;
        iconPreview.textContent = icon;
        iconSuggestions.classList.remove('active');
    };

    // Close suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.icon-input-wrapper')) {
            iconSuggestions.classList.remove('active');
        }
    });

    // Initialize preview on page load
    if (iconInput.value) {
        iconPreview.textContent = iconInput.value.toLowerCase().trim();
    }
});
