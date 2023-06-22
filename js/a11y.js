// Do keyboard stuff
document.addEventListener('keydown', (event) => {
    const focussed = document.activeElement;
    const tabindex_value = focussed.getAttribute('tabindex');

    if (event.key == 'Enter' && tabindex_value != null) {
        focussed.click();
    }
});

// Check if menu is open and change the links in the footer
function any_menu_open(value) {
    const anchors = document.querySelectorAll('.footer-link');

    for (let i = 0; i < anchors.length; i++) {
        if (value) {
            anchors[i].setAttribute('tabindex', '-1');
        } else {
            anchors[i].setAttribute('tabindex', '0');
        }
    }
}