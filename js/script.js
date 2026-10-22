// ================= WELCOME =================

window.addEventListener("load", function () {

    console.log("FitZone website loaded successfully.");

});


// ================= WELCOME FUNCTION =================

function welcomeUser() {

    let name = prompt(
        "What is your name?"
    );

    if (name !== null && name.trim() !== "") {

        alert(
            "Welcome to FitZone, " +
            name +
            "!"
        );

    }

}


// ================= JOIN CONFIRMATION =================

function confirmJoin() {

    let answer = confirm(
        "Do you want to join FitZone?"
    );

    if (answer) {

        alert(
            "Great! Let's start your fitness journey."
        );

    } else {

        alert(
            "No problem. You can join anytime."
        );

    }

}


// ================= CURRENT YEAR =================

let yearElements =
    document.querySelectorAll(".current-year");

yearElements.forEach(function (element) {

    element.innerHTML =
        new Date().getFullYear();

});