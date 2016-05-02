// Waits until the page is fully loaded
window.addEventListener('load', init);

// Get the first element in the document with type=date
var date = document.querySelector('[type=date]');

function init(error) { // error is an event, function init executes every time the event is triggered

    var day = new Date(error.target.value).getUTCDay(); //checks what the chosen day is

    // Friday, Saturday and Sunday Cannot be chosen
    // in JS this 5, 6 and 0
    if (day == 5) {
        error.target.setCustomValidity('Kies een geldige dag a.u.b.');
        // If chosen day is 1, 5, 6, or 0 alert 'Kies een geldige dag a.u.b.'

    } else if (day == 6) {
        error.target.setCustomValidity('Kies een geldige dag a.u.b.');
    } else if (day == 0) {
        error.target.setCustomValidity('Kies een geldige dag a.u.b.');
    } else {
        error.target.setCustomValidity('');
        // Else alert nothing
    }

}

date.addEventListener('input', init); //Makes sure it actually runs
