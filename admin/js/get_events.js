// Make AJAX request for events
const ev_xhr = new XMLHttpRequest();

ev_xhr.open('GET', './php/get_events.php', true);
ev_xhr.onreadystatechange = function() {
    if (ev_xhr.readyState === 4) {
        if (ev_xhr.status === 200) {
            // Get JSON
            const data = JSON.parse(ev_xhr.responseText);

            // Get buttons
            const edit_button = document.querySelectorAll('#event_add .edit');
            for (let i = 0; i < edit_button.length; i++) {
                for (let j = 0; j < data.length; j++) {
                    if (data[j].Event_id === edit_button[i].parentNode.dataset.event_id) {
                        edit_button[i].addEventListener('click', () => {
                            cancel_edit[1].parentNode.parentNode.style.display = "flex";
                            document.getElementById('edit_event_id').value = data[j].Event_id;

                            // Edit all basic things (Name, price etc.)
                            const edit_screen = document.getElementById('edit_events');
                            edit_screen.querySelector('input[name=\'event_name\']').value = data[j].Naam;
                            edit_screen.querySelector('input[name=\'price\']').value = data[j].Entreegeld;
                            edit_screen.querySelector('input[name=\'date\']').value = data[j].Datum;
                            edit_screen.querySelector('input[name=\'start_time\']').value = remove_00(data[j].Starttijd);

                            // Add every band and stuff
                            const add_band_place = document.getElementById('added_bands')
                            const old_bands = add_band_place.querySelectorAll('.edit_band_band');
                            for (let k = 0; k < old_bands.length; k++) {
                                old_bands[k].remove();
                            }

                            for (let k = 0; k < data[j].performance.length; k++) {
                                const place = get_gg_parent('form_list', add_band_place).querySelector('.added_bands');

                                // Make a copy of the div
                                const copy_band = add_button[i].parentNode.cloneNode(true);
                                create_band_node(copy_band, add_form(k), i, place);

                                // Change their values
                                place.querySelectorAll('.band_title')[k].innerHTML = `<b>${data[j].performance[k].band_name}</b>`;
                                place.querySelector(`input[name=\'start_time_${k}\']`).value = remove_00(data[j].performance[k].Starttijd);
                                place.querySelector(`input[name=\'end_time_${k}\']`).value = remove_00(data[j].performance[k].Eindtijd);
                                place.querySelector(`input[name=\'sets_${k}\']`).value = data[j].performance[k].Sets;

                                let per_id = document.createElement('input');
                                per_id.type = 'hidden';
                                per_id.name = `performance_id_${k}`;
                                per_id.value = data[j].performance[k].Optreden_id;
                                place.querySelectorAll('.edit_band_band')[k].appendChild(per_id);
                            }
                        });
                    }
                }
            }
        } else {
            console.log("Error: ", ev_xhr.statusText);
        }
    }
};
ev_xhr.send();

function remove_00(value) {
    if (value.endsWith(':00')) {
        return value.slice(0, -3);
    } else {
        return value;
    }
}