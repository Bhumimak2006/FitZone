document
    .getElementById("calculateBtn")
    .addEventListener("click", calculateBMI);


function calculateBMI() {

    let weight =
        Number(
            document.getElementById("weight").value
        );

    let height =
        Number(
            document.getElementById("height").value
        );


    if (weight <= 0 || height <= 0) {

        alert(
            "Please enter valid weight and height."
        );

        return;
    }


    let bmi =
        weight / (height * height);


    let category;


    if (bmi < 18.5) {

        category = "Underweight";

    }
    else if (bmi < 25) {

        category = "Normal Weight";

    }
    else if (bmi < 30) {

        category = "Overweight";

    }
    else {

        category = "Obesity";

    }


    document
        .getElementById("result")
        .innerHTML =
        "Your BMI is " +
        bmi.toFixed(2) +
        "<br>Category: " +
        category;

}