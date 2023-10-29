const container = document.getElementById('show_case');
const bandShowcases = document.querySelectorAll('.showcase-item');

// Cycle bands
let currentBandCycle = 0;
const bands = [];

for (let i = 0; i < bandShowcases.length; i++) {
    bands[i] = bandShowcases[i].querySelectorAll('.band-showcase-item');
}

function cycleBands() {
    const waitTime = 5000;
    let i = 0;

    function changeBandPos() {
        for (let j = 0; j < bands.length; j++) {
            const currentBand = i % bands[j].length;
            for (let k = 0; k < bands[j].length; k++) {
                bands[j][k].style.display = 'none';
            }

            bands[j][currentBand].style.display = 'block';
        }
        i++;
    }

    changeBandPos();
    const interval = setInterval(changeBandPos, waitTime);
}

cycleBands();

// If band title is too big
const bandName = document.querySelectorAll('.event-name > h2');
let names = [];
for (let i = 0; i < bandName.length; i++) {
    names.push(bandName[i].innerText);
}
function change_name(i) {
    if (window.innerWidth < 430 && names[i].length > 10) {
        bandName[i].innerText = names[i].slice(0, 8) + "...";
    } else {
        bandName[i].innerText = names[i]
    }
}

window.addEventListener('resize', () => {
    for (let i = 0; i < bandShowcases.length; i++) {
        change_name(i);
    }
});
for (let i = 0; i < bandShowcases.length; i++) {
    change_name(i);
}

// Price
const price = document.querySelectorAll('.price');

for (let i = 0; i < price.length; i++) {
    price[i].innerText = replaceEnd(price[i].innerText);
}

function replaceEnd(str) {
    return str.replace(/00$/, '-');
}