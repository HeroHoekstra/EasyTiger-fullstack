// Search bands
const cancel_edit = document.querySelectorAll('.cancel_edit');
for (let i = 0; i < cancel_edit.length; i++) {
    cancel_edit[i].parentNode.parentNode.style.display = "none";
    cancel_edit[i].addEventListener('click', () => {
        cancel_edit[i].parentNode.parentNode.style.display = "none";
    });
}

// Make AJAX request for bands
var xhr = new XMLHttpRequest();
xhr.open('GET', '/EasyTiger-fullstack/content/admin/php/get_bands.php', true);
xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);

            // Make correct edit screen appear
            const edit_button = document.querySelectorAll('.edit_band .edit');
            for (let i = 0; i <  edit_button.length; i++) {
                for (let j = 0; j < data.length; j++) {
                    if (data[j].Band_id === edit_button[i].parentNode.dataset.band_id) {
                        edit_button[i].addEventListener('click', () => {
                            cancel_edit[0].parentNode.parentNode.style.display = "flex";
                            document.getElementById('edit_band_id').value = data[j].Band_id;

                            const edit_screen = document.getElementById('edit_band_members');
                            edit_screen.querySelector('input[name=\'band_name\']').value = data[j].Naam;
                            edit_screen.querySelector('input[name=\'genre\']').value = data[j].Genre;
                            edit_screen.querySelector('input[name=\'origin\']').value = data[j].Herkomst;
                            edit_screen.querySelector('textarea[name=\'desc\']').value = data[j].Omschrijving;

                            // Loop through members and show them
                            for (let k = 0; k < data[j].members.length; k++) {
                                add_person(edit_screen.querySelector('.people'), 1);

                                const newly_added = edit_screen.querySelectorAll('.people > div')[k];

                                let member_id = document.createElement('input');
                                member_id.type = "hidden";
                                member_id.name = `band_member_id_${k}`;
                                member_id.value = data[j].members[k].Lid_id;
                                newly_added.appendChild(member_id);

                                newly_added.querySelector('.band_member_name').innerText = data[j].members[k].Naam;
                                newly_added.querySelector(`input[name='band_name_${k}']`).value = data[j].members[k].Naam;
                                newly_added.querySelector(`input[name='band_email_${k}']`).value = data[j].members[k].Email;
                                newly_added.querySelector(`input[name='band_phone_${k}']`).value = data[j].members[k].Telefoon;
                            }

                            // Remove button
                            const remove_amount = edit_screen.querySelectorAll('.people > div').length - data[j].members.length;
                            for (let k = 0; k < remove_amount; k++) {
                                if (name_arr[1].length > 0) {
                                    name_arr[1][name_arr[1].length - 1].parentNode.remove();
                                    name_arr[1].pop();
                                }
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