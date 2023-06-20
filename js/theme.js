const styles = document.documentElement.style;

// Light theme
function set_light() {
    styles.setProperty('--text', '#000');
    styles.setProperty('--background', '#fff');
    styles.setProperty('--primary-color', '#8fb4ff');
    styles.setProperty('--secondary-color', '#ebf1ff');
    styles.setProperty('--accent', '#ff8f94');
}

// Dark theme
function set_dark() {
    styles.setProperty('--text', '#e3ebed');
    styles.setProperty('--background', '#141d1f');
    styles.setProperty('--primary-color', '#56648a');
    styles.setProperty('--secondary-color', '#1f1b2c');
    styles.setProperty('--accent', '#62568a');
}