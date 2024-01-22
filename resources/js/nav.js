document.addEventListener('DOMContentLoaded', function () {
     setUserInitials();
    setRandomColors();
});




function setUserInitials() {
    const userInitialsElements = document.querySelectorAll('.user-initials');
    if (userInitialsElements.length === 0) return;

    const username = userInitialsElements[0].getAttribute('data-username');
    setInitials(username);
}

function setInitials(username) {
    if (!username) return;

    const initials = username.split(' ').map(name => name[0]).join('').toUpperCase();
    document.querySelectorAll('.user-initials').forEach(element => {
        element.textContent = initials;
    });
}

function setRandomColors() {
    const elements = document.querySelectorAll('.user-initials');
    elements.forEach(element => {
        element.style.backgroundColor = getRandomColor();
    });
}

function getRandomColor() {
    const maxHex = 0x1000000; 
    const darkColorThreshold = 0x808080; 
    let color = Math.floor(Math.random() * maxHex); 

    if (color > darkColorThreshold) {
        color = color - darkColorThreshold; 
    }

    return '#' + color.toString(16).padStart(6, '0');
}

