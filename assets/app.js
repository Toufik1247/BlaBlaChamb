import './styles/app.scss';
import './styles/home.scss';
import './styles/registerForm.scss';
import './styles/rides.scss';
import './styles/header.css';

import * as bootstrap from 'bootstrap';
import '@popperjs/core';
import './js/hello';
require('jquery-ui-dist/jquery-ui');
window.bootstrap = bootstrap;
const $ = require('jquery');

$(document).ready(function () {
    let timer1, timer2, timer3, timer4;

    $('#find_ride_departure').on('input', function () {
        clearTimeout(timer1);
        timer1 = setTimeout(fetchCities, 300, $(this).val(), 'find_ride_departure');
    });

    $('#find_ride_destination').on('input', function () {
        clearTimeout(timer2);
        timer2 = setTimeout(fetchCities, 300, $(this).val(), 'find_ride_destination');
    });

    $('#rides_departure').on('input', function () {
        clearTimeout(timer3);
        timer3 = setTimeout(fetchCities, 300, $(this).val(), 'rides_departure');
    });

    $('#rides_destination').on('input', function () {
        clearTimeout(timer4);
        timer4 = setTimeout(fetchCities, 300, $(this).val(), 'rides_destination');
    });

    function fetchCities(query, elementId) {
        if (query.length < 1) return;

        $.ajax({
            url: `https://geo.api.gouv.fr/communes?nom=${query}&boost=population`,
            method: 'GET',
            success: function (data) {
                let results = data.map(function (city) {
                    return city.nom;
                });

                $('#' + elementId).autocomplete({
                    source: results,
                    open: function () {
                        $('.ui-autocomplete').addClass('list-group border');

                        $('.ui-menu-item').addClass('list-group-item');

                        $('.ui-autocomplete').css('width', $('#' + elementId).width() + 'px');
                    }

                });
            },
            error: function (error) {
                console.error('Erreur lors de la récupération des données de la ville :', error);
            }
        });
    }

});

document.addEventListener('DOMContentLoaded', () => {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach((tooltipTriggerEl) => {
        return new window.bootstrap.Tooltip(tooltipTriggerEl);
    });
});

const minSeatsSlider = document.querySelector('#{{ filter_form.minSeats.vars.id }}');
const minSeatsValue = document.querySelector('#minSeatsValue');

// Update the current slider value (each time you drag the slider handle)
minSeatsSlider.oninput = function () {
    minSeatsValue.textContent = 'Vous avez choisi : ' + this.value + ' places';
}

