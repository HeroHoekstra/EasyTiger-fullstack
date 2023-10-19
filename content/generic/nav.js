// Nav
const nav = document.getElementById('nav_bar');
const shrinkOffset = 100;

function shrinkNav() {
    if (window.scrollY > shrinkOffset) {
        nav.style.height = '30px';
    } else {
        nav.style.height = '45px';
    }
}

// Move through page sections
// Get the buttons
const button_0 = document.getElementById('section_up');
const button_1 = document.getElementById('section_down');

const pageSections = document.querySelectorAll('.main-item');

// Give all page sections a unique id without removing existing ones
for (let i = 0; i < pageSections.length; i++) {
    pageSections[i].setAttribute('id', `item_${i}`);
}

let pageSectionHeight = pageSections[0].clientHeight;
window.addEventListener('resize', () => {
    pageSectionHeight = pageSections[0].clientHeight;
});

// Calculate how far has been scrolled
function pageScroll() {
    if (button_0 !== null) {
        const scrolled = window.scrollY;

        let currentSection = Math.floor(scrolled / pageSectionHeight);

        button_0.href = `#item_${currentSection - 1}`;
        button_1.href = `#item_${currentSection + 1}`;

        if (currentSection <= 0) {
            button_0.href = 'javascript: void(0)';
        } else if (currentSection >= pageSections.length - 1) {
            button_1.href = 'javascript: void(0)';
        }
    }
}

// Background gradiant
document.body.style.background = 'transparent';

const colors = [
    [125,201,74],
    [5, 51, 122],
    [187, 152, 240],
    [243, 73, 127]
];

const rotationFactor = 5
const gradiant = document.getElementById('gradiant');
const scrollMax = document.body.clientHeight - window.innerHeight + 200;

function updateGradiant() {
    if (gradiant !== null) {
        const y = window.scrollY;

        let rotation = y / rotationFactor % 360;
        const scrollPosition = window.scrollY;

        // Calculate the progress of the scroll
        const progress = scrollPosition / scrollMax;

        const interpolatedColors1 = interpolateColors(colors[0], colors[2], progress);
        const color1 = `rgb(${interpolatedColors1[0]}, ${interpolatedColors1[1]}, ${interpolatedColors1[2]})`;
        const interpolatedColors2 = interpolateColors(colors[1], colors[3], progress);
        const color2 = `rgb(${interpolatedColors2[0]}, ${interpolatedColors2[1]}, ${interpolatedColors2[2]})`;

        // Set the background color
        gradiant.style.background = `linear-gradient(${rotation}deg, ${color1}, ${color2})`;
    }
}

function interpolateColors(color1, color2, progress) {
    const r = Math.round(color1[0] + (color2[0] - color1[0]) * progress);
    const g = Math.round(color1[1] + (color2[1] - color1[1]) * progress);
    const b = Math.round(color1[2] + (color2[2] - color1[2]) * progress);

    return [r, g, b];
}

// Update nav elements
window.addEventListener('scroll', () => {
    shrinkNav()
    pageScroll();
    updateGradiant();
});

shrinkNav();
pageScroll();
updateGradiant();