<?php


/* ================= ABSTRACT CLASS ================= */

abstract class Workout {

    protected $name;

    public function __construct($name) {

        $this->name = $name;

    }

    abstract public function getWorkout();

}


/* ================= CHILD CLASS ================= */

class CardioWorkout extends Workout {

    public function getWorkout() {

        return
            $this->name .
            ": Running, Cycling and HIIT";

    }

}


/* ================= INTERFACE ================= */

interface Payment {

    public function pay($amount);

}


/* ================= IMPLEMENTATION ================= */

class MembershipPayment
    implements Payment {

    public function pay($amount) {

        return
            "Payment successful: ₹"
            . $amount;

    }

}


/* ================= OBJECT ================= */

$workout =
    new CardioWorkout(
        "Weight Loss"
    );


$payment =
    new MembershipPayment();


echo $workout->getWorkout();

echo "<br>";

echo $payment->pay(1499);

?>