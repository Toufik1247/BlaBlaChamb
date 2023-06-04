import { Application } from "@hotwired/stimulus"
import flatpickr from "flatpickr";

const application = Application.start();

application.start()
    .then(() => {
        console.log("Stimulus application started");
        console.log(document.getElementById('datepicker'));
        flatpickr("#datepicker", {});
    })
    .catch(e => console.error(e));
