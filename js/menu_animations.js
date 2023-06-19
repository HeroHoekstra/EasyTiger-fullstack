// Make delay function
function delay(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

// Animation functions
async function menu_animation(name) {
    // Give animation class
    menu.classList.add(name);

    // Wait for animation to finish playing
    await delay(150);

    // Delay removing the animation class
    await delay(50);

    // Clear animation class
    menu.classList.remove(name);
}

async function menu_slide(name) {
    // The same thing from the function above
    menu_content.classList.add(name);
    await delay(150);
    menu_content.classList.remove(name);
}

// Get menu & menu buttons
const menu_button = document.getElementById('open_menu');
const menu = document.getElementById('menu');
const menu_content = document.getElementById('menu_content');

// Make sure menu_button is set to false
menu_button.checked = false;

// When the menu button is clicked
menu_button.addEventListener('click', () => {
    let checked = menu_button.checked;

    // Change display to block
    if (checked) menu.style.display = 'block';

    // Slide menu box
    checked ? menu_slide('menu_slide_in') : menu_slide('menu_slide_out');

    // Play correct animation
    checked ? menu_animation('menu_open_animation') : menu_animation('menu_close_animation');

    // Delay changing the display property to none
    setTimeout(() => {
        if (!checked) menu.style.display = 'none';
    }, 120);
});