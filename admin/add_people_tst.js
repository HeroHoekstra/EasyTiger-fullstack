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
const open_people_menu = document.querySelectorAll('.open_band_member_menu');
const people_menu = document.querySelectorAll('.people');
const button_img = document.querySelectorAll('.open_menu_member_img');
for (let i = 0; i < open_people_menu.length; i++) {
    open_people_menu[i].addEventListener('click', () => {

    });
}

let name_arr = new Array(0)

function add_person(parent) {
    // Create a new div element
    var new_div = document.createElement('div');
    new_div.id = `person_${name_arr.length}`;

    // Create elements
    var name_header = document.createElement('h4');
    name_header.className = 'band_member_name';
    name_header.textContent = `Person ${name_arr.length + 1}`;

    var name_label = document.createTextNode('Name: ');
    var name_input = document.createElement('input');
    name_input.name = `band_name_${name_arr.length}`; 
    name_input.type = 'text';
    name_input.className = 'person_name';

    var email_label = document.createTextNode('Email: ');
    var email_input = document.createElement('input');
    email_input.name = `band_email_${name_arr.length}`;
    email_input.type = 'email';

    var phone_number_label = document.createTextNode('Phone number: ');
    var phone_number_input = document.createElement('input');
    phone_number_input.name = `band_phone_${name_arr.length}`;
    phone_number_input.type = 'text';

    // Append elements
    new_div.appendChild(name_header);
    new_div.appendChild(document.createElement('p'));
    new_div.appendChild(name_label);
    new_div.appendChild(name_input);
    new_div.appendChild(email_label);
    new_div.appendChild(email_input);
    new_div.appendChild(phone_number_label);
    new_div.appendChild(phone_number_input);

    // Append the new div to the parent div and add it to the array
    name_arr.push(name_input);
    parent.appendChild(new_div);
}

// Open add / edit people menu
function open_add_menu(button, menu, img) {
    img.style.rotate = '90deg';
    
}

// Change title of persons
function change_name(e, i) {
    const title = document.querySelectorAll('.band_member_name');

    if (e.value != "") {
        title[i].innerText = e.value;
    } else {
        title[i].innerText = `Person ${i + 1}`;
    }
}