const buttons = document.querySelectorAll('.open_menu_button');
const img = document.querySelectorAll('.open_menu_img');

for (let i = 0; i < buttons.length; i++) {
    !buttons[i].checked ? img[i].style.rotate = '0deg' : img[i].style.rotate = '90deg';

    buttons[i].addEventListener('click', () => {
        !buttons[i].checked ? img[i].style.rotate = '0deg' : img[i].style.rotate = '90deg';
        let open = document.querySelectorAll('.menu_openable');
        !buttons[i].checked ? open[i].style.display = 'none' : open[i].style.display = 'block';
    });
}


let add_buttons = new Array(0);
add_buttons.push(document.querySelectorAll('.add_item'));
add_buttons.push(document.querySelectorAll('.remove_item'));

for (let i = 0; i < add_buttons.length; i++) {
    for (let j = 0; j < add_buttons[i].length; j++) {
        add_buttons[i][j].addEventListener('click', () => {
            switch(add_buttons[i][j].id) {
                case "add_people":
                    add_person();
                    name_arr.forEach((element, index) => element.addEventListener('input', () => {
                        change_name(element, index);
                    }));
                    open_menu()

                    break;
                case "remove_people":
                    remove_person();
                    open_menu();
                    break;
                default:
                    console.log("No button like this exists");
                    break;
            }
        });
    }
}

let name_arr = new Array(0)

function add_person() {
    // Add new person
    const parent = document.getElementById('people');

    // Create a new div element
    var new_div = document.createElement('div');
    new_div.id = `person_${name_arr.length}`;

    // Create elements
    var name_header = document.createElement('h4');
    name_header.className = 'band_member_name';
    name_header.textContent = `Person ${name_arr.length + 1}`;

    var name_label = document.createTextNode('Name: ');
    var name_input = document.createElement('input');
    name_input.type = 'text';
    name_input.className = 'person_name';

    var email_label = document.createTextNode('Email: ');
    var email_input = document.createElement('input');
    email_input.type = 'email';

    var phone_number_label = document.createTextNode('Phone number: ');
    var phone_number_input = document.createElement('input');
    phone_number_input.type = 'text';

    // Append elements
    new_div.appendChild(name_header);
    new_div.appendChild(name_label);
    new_div.appendChild(name_input);
    new_div.appendChild(document.createElement('br'));
    new_div.appendChild(email_label);
    new_div.appendChild(email_input);
    new_div.appendChild(document.createElement('br'));
    new_div.appendChild(phone_number_label);
    new_div.appendChild(phone_number_input);
    new_div.appendChild(document.createElement('br'));

    // Append the new div to the parent div and add it to the array
    name_arr.push(name_input)
    parent.appendChild(new_div);
}

function remove_person() {
    const to_be_removed = document.getElementById(`person_${name_arr.length - 1}`);
    to_be_removed.parentElement.removeChild(to_be_removed);

    name_arr.pop();
}

function open_menu() {
    document.querySelector('.open_menu_member_img').style.rotate = '90deg';
    document.getElementById('open_band_member_menu').checked = true;
    document.getElementById('people').style.display = 'block';
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