/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
// import './styles/header.scss';
import './styles/home.scss';
import './styles/registerForm.scss';
import './styles/rides.scss';

require('bootstrap');

import './bootstrap';
import '@popperjs/core';
import './js/hello';


document.addEventListener('DOMContentLoaded', function () {
    const rules = [];
    const addRuleButton = document.querySelector('.add-another-rule');
    const ruleNameInput = document.querySelector('.rule-name');
    const ruleDescriptionInput = document.querySelector('.rule-description');
    const ruleListContainer = document.querySelector('#rule-list');
    const hiddenRuleFieldsContainer = document.querySelector('#hidden-rule-fields');

    function updateRuleList() {
        ruleListContainer.innerHTML = '';
        hiddenRuleFieldsContainer.innerHTML = '';

        rules.forEach((rule, index) => {
            const ruleItem = document.createElement('div');
            ruleItem.classList.add('mb-2', 'd-flex', 'justify-content-between', 'align-items-center');

            ruleItem.dataset.ruleId = index;

            const ruleText = document.createElement('span');
            ruleText.textContent = `${rule.name}: ${rule.description}`;
            ruleItem.appendChild(ruleText);

            const buttonContainer = document.createElement('div');
            buttonContainer.classList.add('btn-group');
            ruleItem.appendChild(buttonContainer);

            const editButton = document.createElement('button');
            editButton.type = 'button';
            editButton.classList.add('btn', 'btn-sm', 'btn-warning');
            editButton.innerHTML = '<i class="fas fa-edit"></i>';
            editButton.addEventListener('click', function () {
                const ruleId = ruleItem.dataset.ruleId;
                editRule(ruleId);
            });
            buttonContainer.appendChild(editButton);

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.classList.add('btn', 'btn-sm', 'btn-danger');
            deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
            deleteButton.addEventListener('click', function () {
                rules.splice(index, 1);
                updateRuleList();
            });
            buttonContainer.appendChild(deleteButton);

            ruleListContainer.appendChild(ruleItem);

            const nameField = document.createElement('input');
            nameField.type = 'hidden';
            nameField.name = `rides[rules][${index}][name]`;
            nameField.value = rule.name;
            hiddenRuleFieldsContainer.appendChild(nameField);

            const descriptionField = document.createElement('input');
            descriptionField.type = 'hidden';
            descriptionField.name = `rides[rules][${index}][description]`;
            descriptionField.value = rule.description;
            hiddenRuleFieldsContainer.appendChild(descriptionField);
        });
    }


    function addRule() {
        const rule = {
            name: ruleNameInput.value,
            description: ruleDescriptionInput.value
        };
        rules.push(rule);

        ruleNameInput.value = '';
        ruleDescriptionInput.value = '';

        updateRuleList();
    }

    addRuleButton.addEventListener('click', function (event) {
        event.preventDefault();
        addRule();
    });
});
