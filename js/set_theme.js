// Set the themes when the buttons are pressed
// Get variables
const theme_button = document.getElementById('theme');
const light = document.getElementById('light_mode');
const dark = document.getElementById('dark_mode');

// Change theme function
function set_theme() {
    if (theme_button.checked) {
        set_dark();
        light.style.display = 'none';
        dark.style.display = 'block';
    } else {
        set_light();
        light.style.display = 'block';
        dark.style.display = 'none';
    }
}

// Set initial button and theme
set_theme();

// Update button and theme
theme_button.addEventListener('click', () => {
    set_theme();
}); 