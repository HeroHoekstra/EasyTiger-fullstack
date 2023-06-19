const styles = document.documentElement.style;

// Light theme
function set_light() {
    styles.setProperty('--text', '#171a14');
    styles.setProperty('--background', '#edf0ea');
    styles.setProperty('--primary-button', '#c6becf');
    styles.setProperty('--secondary-button', '#ffffff');
    styles.setProperty('--accent', '#9284a4');
}

// Dark theme
function set_dark() {
    styles.setProperty('--text', '#e3ebed');
    styles.setProperty('--background', '#141d1f');
    styles.setProperty('--primary-button', '#56648a');
    styles.setProperty('--secondary-button', '#1f1b2c');
    styles.setProperty('--accent', '#62568a');
}