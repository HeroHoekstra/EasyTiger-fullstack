// Open menus
const buttons = document.querySelectorAll('.open_menu_button');
const img = document.querySelectorAll('.open_menu_img');

for (let i = 0; i < buttons.length; i++) {
    !buttons[i].checked ? img[i].style.rotate = '0deg' : img[i].style.rotate = '90deg';
    let open = document.querySelectorAll('.menu_openable');
    !buttons[i].checked ? open[i].style.display = 'none' : open[i].style.display = 'grid';

    buttons[i].addEventListener('click', () => {
        !buttons[i].checked ? img[i].style.rotate = '0deg' : img[i].style.rotate = '90deg';
        !buttons[i].checked ? open[i].style.display = 'none' : open[i].style.display = 'grid';
    });
}

// Open add / edit people menu
// There should be an equal number of people tabs and open buttons
// Open menu buttons
const open_people_menu = document.querySelectorAll('.open_band_member_menu');
const people_menu = document.querySelectorAll('.people');
const button_img = document.querySelectorAll('.open_menu_member_img');

// Add and remove people
const add_people = document.querySelectorAll('.add_item');
const remove_people = document.querySelectorAll('.remove_item');

// Arrays to keep track of the amount of people
let name_arr = [new Array(0), new Array(0)];
for (let i = 0; i < add_people.length; i++) {
    add_people[i].addEventListener('click', () => {
        open_add_menu(open_people_menu[i], people_menu[i], button_img[i]);
        add_person(people_menu[i], i);

        name_arr[i].forEach((element, index) => element.addEventListener('input', () => {
            change_name(element, index);
        }));
    });

    remove_people[i].addEventListener('click', () => {
        if (name_arr[i].length > 0) {
            name_arr[i][name_arr[i].length - 1].parentNode.remove();
            name_arr[i].pop();
        }
    });
}

// Open add / edit people menu
function open_add_menu(button, menu, img) {
    img.style.rotate = '90deg';
    menu.style.display = 'block';
    button.checked = true;
}

// Change title of persons
function change_name(e, i) {
    const title = document.querySelectorAll('.band_member_name');

    if (e.value != "") {
        title[i].innerText = e.value;
    } else {
        title[i].innerText = `Person ${i + 1}`;
    }

    if (e.value.length > window.innerWidth / 50) {
        title[i].innerText = e.value.slice(0, window.innerWidth / 50) + "...";
    }
}

// Function to perform search and update display
function performSearch(input, bandList, bandTitleList, foundDisplay) {
    let amount = 0;
    const searchValueLower = input.value.toLowerCase();

    for (let i = 0; i < bandTitleList.length; i++) {
        const bandNameLower = bandTitleList[i].dataset.name.toLowerCase();

        if (bandNameLower.includes(searchValueLower)) {
            amount++;
            bandList[i].style.display = 'grid';
        } else {
            bandList[i].style.display = 'none';
        }
    }

    foundDisplay.innerText = amount > 0 ?
        `Found ${amount} band(s) that match the search result` :
        'No matching bands found';

    if (searchValueLower === "") {
        foundDisplay.innerText = `Showing all bands`;
    }
}

const searchInputs = document.querySelectorAll('.search');
const foundDisplays = document.querySelectorAll('.found_display');

const bandLists = [
    Array.from(document.querySelectorAll('#band_edit .edit_band_band')),
    Array.from(document.querySelectorAll('#band_add .edit_band_band')),
    Array.from(document.querySelectorAll('#event_add .edit_band_band'))
];

const bandTitleLists = [
    Array.from(document.querySelectorAll('#band_edit .edit_band_band .band_title')),
    Array.from(document.querySelectorAll('#band_add .edit_band_band .band_title')),
    Array.from(document.querySelectorAll('#event_add .edit_band_band .band_title'))
];

for (let j = 0; j < searchInputs.length; j++) {
    searchInputs[j].addEventListener('input', () => {
        performSearch(searchInputs[j], bandLists[j], bandTitleLists[j], foundDisplays[j]);
    });

    // Initial display update
    performSearch(searchInputs[j], bandLists[j], bandTitleLists[j], foundDisplays[j]);
}

// Add bands to events
// Get all important divs
const band_add = document.getElementById('band_add');
const added_bands = document.getElementById('added_bands');
const add_button = document.querySelectorAll('.add');

for (let i = 0; i < add_button.length; i++) {
    add_button[i].addEventListener('click', () => {
        // Make a copy of the div
        const copy_band = add_button[i].parentNode.cloneNode(true);
        
        create_band_node(copy_band, add_form(i), i);

        add_button[i].innerText = "[Added]";
    });
}

function create_band_node(band, form, i) {
    const button = band.querySelector('.add');
    button.innerText = "[Remove]";
    button.className = "remove edit";

    button.addEventListener('click', () => {
        band.parentNode.removeChild(band);
        add_button[i].innerText = "[Add]"
    });

    band.appendChild(form);

    added_bands.appendChild(band);
}