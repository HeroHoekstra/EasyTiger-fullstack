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

// Background gradiant
const colors = [
    "rgb(125,201,74)",
    "rgb(5, 51, 122)",
    "rgb(187, 152, 240)",
    "rgb(243, 73, 127)"
];

function interpolateColors(color1, color2, progress) {
    const c1 = color1.match(/\d+/g).map(Number);
    const c2 = color2.match(/\d+/g).map(Number);
    const result = c1.map((channel, index) =>
        Math.round(channel + (c2[index] - channel) * progress)
    );

    return `rgb(${result[0]}, ${result[1]}, ${result[2]})`;
}

const rotationFactor = 5
const gradiant = document.getElementById('gradiant');

function updateGradiant() {
    const y = window.scrollY;

    const color1 = interpolateColors(colors[0], colors[2]);
    const color2 = interpolateColors(colors[1], colors[3]);

    let rotation = y / rotationFactor % 360;
    gradiant.style.background = `linear-gradient(${Math.floor(rotation)}deg, ${color1}, ${color2})`;

    console.log(color1, color2);
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