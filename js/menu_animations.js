// Animate and add functionality to the menu
// With functionality I mean make it pop out from the left
// Also the user menu (menu is menu)

// Make delay function
function delay(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

// Animation functions
async function menu_animation(id, animation) {
    // Give animation class
    id.classList.add(animation);

    // Wait for animation to finish playing
    await delay(150);

    // Delay removing the animation class
    await delay(50);

    // Clear animation class
    id.classList.remove(animation);
}

async function menu_slide(name) {
    // The same thing from the function above
    menu_content.classList.add(name);
    await delay(150);
    menu_content.classList.remove(name);
}

// Menu
// Get menu & menu buttons
const menu_button = document.getElementById('open_menu');
const menu = document.getElementById('menu');
const menu_content = document.getElementById('menu_content');

// Make sure menu_button is set to false
menu_button.checked = false;

// When the menu button is clicked
function menu_open() {
    let checked = menu_button.checked;
    // a11y
    checked ? any_menu_open(true) : any_menu_open(false);

    // Change display to block
    if (checked) {
        menu.style.display = 'block';
        menu_content.style.display = 'block';
    }

    // Slide menu box
    checked ? menu_slide('menu_slide_in') : menu_slide('menu_slide_out');

    // Play correct animation
    checked ? menu_animation(menu, 'menu_open_animation') : menu_animation(menu, 'menu_close_animation');

    // Delay changing the display property to none
    setTimeout(() => {
        if (!checked) {
            menu.style.display = 'none';
            menu_content.style.display = 'none';
        }
    }, 120);
};
menu_button.addEventListener('click', () => {menu_open();});

// Login menu
const login_button = document.getElementById('login_button');
const login_menu = document.getElementById('login_menu');
const login_content = document.getElementById('login_menu_content');

// Make sure login_menu is set to false
login_button.checked = false;

function login_menu_open() {
    let checked = login_button.checked;
    // a11y
    checked ? any_menu_open(true) : any_menu_open(false);

    // Change display to block
    if (checked) login_menu.style.display = 'block';

    // Just fucking appear i dont care
    // Maybe fix it later or whatefs
    checked ? login_content.style.display = 'block' : login_content.style.display = 'none';

    // Play correct animation
    checked ? menu_animation(login_menu, 'menu_open_animation') : menu_animation(login_menu, 'menu_close_animation');

    // Delay changing the display property to none
    setTimeout(() => {
        if (!checked) login_menu.style.display = 'none';
    }, 120);
}
// When the user button is clicked
login_button.addEventListener('click', () => {login_menu_open();});


// Technically this is also a menu animation...
// It makes the user input border expand when focussed
const borders = document.querySelectorAll('.input-border');  

for (let i = 0; i < borders.length; i++) {
    const border_parent = borders[i].parentNode;
    const input_field = border_parent.querySelector('input');

    input_field.addEventListener('focus', () => {
        const input_field_width = input_field.offsetWidth;
        
        borders[i].style.width = input_field_width + 'px';
    });

    input_field.addEventListener('blur', () => {
        borders[i].style.width = '0px';
    });
}