document
    .getElementById("membershipForm")
    .addEventListener(
        "submit",
        validateForm
    );


function validateForm(event) {

    let name =
        document.getElementById("name").value.trim();

    let email =
        document.getElementById("email").value.trim();

    let phone =
        document.getElementById("phone").value.trim();

    let age =
        Number(
            document.getElementById("age").value
        );


    if (name.length < 3) {

        alert(
            "Name must contain at least 3 characters."
        );

        event.preventDefault();

        return;

    }


    if (phone.length !== 10) {

        alert(
            "Phone number must contain 10 digits."
        );

        event.preventDefault();

        return;

    }


    if (age < 14 || age > 80) {

        alert(
            "Please enter a valid age."
        );

        event.preventDefault();

        return;

    }


    let answer = confirm(
        "Are you sure you want to submit the membership form?"
    );


    if (!answer) {

        event.preventDefault();

    }

}