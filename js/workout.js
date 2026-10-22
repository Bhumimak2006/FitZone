const workouts = [

    {
        name: "Beginner Full Body",
        type: "beginner",
        duration: "45 Minutes",
        exercises: [
            "Squats",
            "Push Ups",
            "Plank",
            "Walking"
        ]
    },

    {
        name: "Weight Loss",
        type: "weightloss",
        duration: "60 Minutes",
        exercises: [
            "Running",
            "Jumping Jacks",
            "Burpees",
            "Cycling"
        ]
    },

    {
        name: "Muscle Building",
        type: "muscle",
        duration: "60 Minutes",
        exercises: [
            "Bench Press",
            "Squats",
            "Deadlift",
            "Shoulder Press"
        ]
    }

];


const container =
    document.getElementById(
        "workoutContainer"
    );


function showWorkouts(type) {

    container.innerHTML = "";


    const filtered =
        type === "all"
        ? workouts
        : workouts.filter(
            workout =>
                workout.type === type
        );


    filtered.forEach(
        workout => {

            let exerciseList =
                workout.exercises
                    .map(
                        exercise =>
                            `<li>${exercise}</li>`
                    )
                    .join("");


            container.innerHTML += `

                <div class="card">

                    <h2>
                        ${workout.name}
                    </h2>

                    <p>
                        Duration:
                        ${workout.duration}
                    </p>

                    <ul>
                        ${exerciseList}
                    </ul>

                </div>

            `;

        }
    );

}


showWorkouts("all");