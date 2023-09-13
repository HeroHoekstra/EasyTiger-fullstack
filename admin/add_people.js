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

    /*remove_people[i].addEventListener('click', () => {
        if (name_arr[i].length > 0) {
            name_arr[i][name_arr[i].length - 1].parentNode.remove();
            name_arr[i].pop();
        }
    });*/
}
remove_people[1].addEventListener('click', () => {
    
});

// Create added person
function add_person(parent, arr) {
    // Create a new div element
    let new_div = document.createElement('div');
    new_div.id = `person_${name_arr[arr].length}`;

    // Create elements
    let name_header = document.createElement('h4');
    name_header.className = 'band_member_name';
    name_header.textContent = `Person ${name_arr[arr].length + 1}`;

    const name_label = document.createTextNode('Name: ');
    let name_input = document.createElement('input');
    name_input.name = `band_name_${name_arr[arr].length}`; 
    name_input.type = 'text';
    name_input.className = 'person_name';

    const email_label = document.createTextNode('Email: ');
    let email_input = document.createElement('input');
    email_input.name = `band_email_${name_arr[arr].length}`;
    email_input.type = 'email';

    const phone_number_label = document.createTextNode('Phone number: ');
    let phone_number_input = document.createElement('input');
    phone_number_input.name = `band_phone_${name_arr[arr].length}`;
    phone_number_input.type = 'text';

    // Append elements
    new_div.appendChild(name_header);
    new_div.appendChild(name_label);
    new_div.appendChild(name_input);
    new_div.appendChild(email_label);
    new_div.appendChild(email_input);
    new_div.appendChild(phone_number_label);
    new_div.appendChild(phone_number_input);

    // Append the new div to the parent div and add it to the array
    name_arr[arr].push(name_input);
    parent.appendChild(new_div);
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

// Search bands
// Make AJAX request for bands
let data;
const xhr = new XMLHttpRequest();
xhr.open('GET', './to_json.php', true);
xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            data = JSON.parse(xhr.responseText);

            // Make correct edit screen appear
            const edit_button = document.querySelectorAll('.edit');
            for (let i = 0; i <  edit_button.length; i++) {
                for (let j = 0; j < data.length; j++) {
                    if (data[j].Band_id === edit_button[i].parentNode.dataset.band_id) {
                        edit_button[i].addEventListener('click', () => {
                            const edit_screen = document.getElementById('edit_band_members');
                            edit_screen.querySelector('input[name=\'band_name\']').value = data[j].Naam;
                            edit_screen.querySelector('input[name=\'genre\']').value = data[j].Genre;
                            edit_screen.querySelector('input[name=\'origin\']').value = data[j].Herkomst;
                            edit_screen.querySelector('textarea[name=\'desc\']').value = data[j].Omschrijving;

                            const previously_added = edit_screen.querySelectorAll('li > .people > div');
                            for (let k = 0; k < previously_added.length; k++) {
                                previously_added[k].parentNode.removeChild(previously_added[k]);
                            }

                            for (let k = 0; k < data[j].members.length; k++) {
                                add_person(people_menu[1], 1);

                                const newly_added = edit_screen.querySelector(`li > .people > div[id='person_${k}']`);

                                newly_added.querySelector('.band_member_name').innerText = data[j].members[k].Naam;
                                newly_added.querySelector(`input[name='band_name_${k}']`).value = data[j].members[k].Naam;
                                newly_added.querySelector(`input[name='band_email_${k}']`).value = data[j].members[k].Email;
                                newly_added.querySelector(`input[name='band_phone_${k}']`).value = data[j].members[k].Telefoon;
                            }
                        });
                    }
                }
            }
        } else {
            console.log('Error:', xhr.statusText);
        }
    }
};
xhr.send();

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

function add_form(i) {
    // Add the form to the div
    let add_band_form = document.createElement('div');

    // Create inputs
    const start_time_label = document.createTextNode('Start time: ');
    let start_time_input = document.createElement('input');
    start_time_input.name = `start_time_${i}`;
    start_time_input.type = 'time';

    const end_time_label = document.createTextNode('End time: ');
    let end_time_input = document.createElement('input');
    end_time_input.name = `end_time_${i}`;
    end_time_input.type = 'time';

    const sets_label = document.createTextNode('Amount of sets: ');
    let sets_input = document.createElement('input');
    sets_input.name = `sets_${i}`;
    sets_input.type = 'number';

    const id = add_button[i].parentNode.dataset.band_id;
    let band_id = document.createElement('input');
    band_id.name = `band_id_${id}`;
    band_id.type = "hidden";

    // Append inputs
    add_band_form.appendChild(start_time_label);
    add_band_form.appendChild(start_time_input);
    add_band_form.appendChild(end_time_label);
    add_band_form.appendChild(end_time_input);
    add_band_form.appendChild(sets_label);
    add_band_form.appendChild(sets_input);
    add_band_form.appendChild(band_id);

    return add_band_form;
}