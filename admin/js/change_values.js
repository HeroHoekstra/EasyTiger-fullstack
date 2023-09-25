// Add form to the "Add event" menu for bands
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
    band_id.name = `band_id_${i}`;
    band_id.value = id;
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

// Create added person for the Create and Add band menus
function add_person(parent, arr) {
    // Create a new div element
    let new_div = document.createElement('div');
    new_div.id = `person_${name_arr[arr].length}`;

    // Create remove button
    let remove = document.createElement('div');
    remove.innerText = '[Remove]';
    remove.className = 'remove_person';
    remove.addEventListener('click', () => {
        if (name_arr[arr].length > 0) {
            remove.parentNode.remove();
            name_arr[arr].pop();
        }
    })

    let i = 0;
    i = check_iteration(arr, i);

    // Create elements
    let name_header = document.createElement('h4');
    name_header.className = 'band_member_name';
    name_header.textContent = `Person ${name_arr[arr].length + 1}`;

    const name_label = document.createTextNode('Name: ');
    let name_input = document.createElement('input');
    name_input.name = `band_name_${i}`; 
    name_input.type = 'text';
    name_input.className = 'person_name';

    const email_label = document.createTextNode('Email: ');
    let email_input = document.createElement('input');
    email_input.name = `band_email_${i}`;
    email_input.type = 'email';

    const phone_number_label = document.createTextNode('Phone number: ');
    let phone_number_input = document.createElement('input');
    phone_number_input.name = `band_phone_${i}`;
    phone_number_input.type = 'text';

    // Append elements
    new_div.appendChild(name_header);
    new_div.appendChild(remove);
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

// Check if th already exists
function check_iteration(arr, i) {
    const check = document.querySelectorAll(`#person_${i}`);

    if (check.length > 0) {
        i++;
        return check_iteration(arr, i);
    }
    return i;
}

// Change title of persons
function change_name(e, i) {
    const title = document.querySelectorAll('.band_member_name');

    if (e.value !== "") {
        title[i].innerText = e.value;
    } else {
        title[i].innerText = `Person ${i + 1}`;
    }

    if (e.value.length > window.innerWidth / 50) {
        title[i].innerText = e.value.slice(0, window.innerWidth / 50) + "...";
    }
}