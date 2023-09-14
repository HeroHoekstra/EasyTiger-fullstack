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

const search = document.querySelectorAll('.search');
const found_display = document.querySelectorAll('.found_display');

let bands = [new Array(0), new Array(0)];
bands[0] = Array.from(document.querySelectorAll('#band_edit .edit_band_band'));
bands[1] = Array.from(document.querySelectorAll('#band_add .edit_band_band'));

let band_titles = [new Array(0), new Array(0)];
band_titles[0] = Array.from(document.querySelectorAll('#band_edit .edit_band_band .band_title'));
band_titles[1] = Array.from(document.querySelectorAll('#band_add .edit_band_band .band_title'));

let amount = 0;

for (let j = 0; j < search.length; j++) {
    search[j].addEventListener('input', () => {
        amount = 0;
        for (let i = 0; i < band_titles[j].length; i++) {
            band_name_lower = band_titles[j][i].dataset.name.toLowerCase();
            search_value_lower = search[j].value.toLowerCase();

            if (band_name_lower.includes(search_value_lower)) {
                amount++;
                bands[j][i].style.display = 'grid';
            } else {
                bands[j][i].style.display = 'none';
            }
        }
    
        found_display[j].innerText = `Found ${amount} band(s) that matchs the search result`;
        if (search.value === "") {
            found_display[j].innerText  =`Showing all bands`;
        }
    });
    
    found_display[j].innerText = `Found ${amount} band(s) that match the search result`;
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