'use strict'

import {getDataFromServer} from "./app";

class Location {
    constructor() {
        this.locationFormFields = null;
        this.locationRadioInputChecked = null;
        this.accordion = null;

        this.init();
    }


    init() {
        if (this.validatePropertiesBeforeInitialize()) {
            this.initializeProperties();
            this.handleSelectedInputRadio();
            this.listenToChangeRadioInput();
        }
    }

    handleSelectedInputRadio() {
        this.isLocationRadionInputCheckedAsDefault(this.locationRadioInputChecked) === true
            ? this.disableFormFieldsInAccordion()
            : this.enableFormFieldsInAccordion();
    }

    isLocationRadionInputCheckedAsDefault(radioInput)
    {
        return radioInput.id === 'accordion-radio-default';
    }

    initializeProperties() {
        this.accordion = document.querySelector('.accordion');
        this.locationRadioInputChecked = document.querySelector('.accordion-radio:checked');
        this.locationFormFields = this.accordion.querySelectorAll('[name]');
    }

    validatePropertiesBeforeInitialize() {
        const accordion = document.querySelector('.accordion') || false;

        if (!accordion) {
            return false;
        }

        const locationFormFields = accordion.querySelectorAll('[name]') || [];

        return locationFormFields.length > 0
    }

    disableFormFieldsInAccordion() {
        this.locationFormFields.forEach(field => field.disabled = true);
        this.accordion.classList.add('accordion--disabled');
        this.accordion.classList.remove('accordion--active');
    }

    enableFormFieldsInAccordion() {
        this.locationFormFields.forEach(field => field.disabled = false);
        this.accordion.classList.remove('accordion--disabled');
        this.accordion.classList.add('accordion--active');
    }

    removeErrorsForFormFieldsInAccordion() {
        this.accordion.querySelectorAll('.location-error')
            .forEach(error => error.remove());
    }

    setDefaultValuesForFormFieldsInAccordion() {
        this.locationFormFields.forEach(field => {
            field.name === 'province'
                ? field.value = 'default'
                : field.value = '';
        })
    }

    listenToChangeRadioInput() {
        document.addEventListener('change', (event) => {
            const {target} = event;

            if (!target.classList.contains('accordion-radio')) {
                return false;
            }

            if (target.checked) {
                this.enableFormFieldsInAccordion();
            }

            if (target.hasAttribute('data-location-id')) {
                console.log('location-id');
                this.setLocationFromDatabase(target.getAttribute('data-url'));
            }

            if (target.id === 'accordion-radio-create') {
                this.setDefaultValuesForFormFieldsInAccordion();
                this.removeErrorsForFormFieldsInAccordion();
            }

            if (this.isLocationRadionInputCheckedAsDefault(target)) {
                this.disableFormFieldsInAccordion();
                this.removeErrorsForFormFieldsInAccordion();
            }


        })
    }

    async setLocationFromDatabase(url) {
        const location = await getDataFromServer(url);

        console.log(location);

        location.json().then(location => {
            const locationKeys = Object.keys(location);
            this.locationFormFields.forEach(field => {
                if (locationKeys.find(key => key === field.name)) {
                    field.value = location[field.name];
                }
            })
        })
    }
}

window.addEventListener('DOMContentLoaded',  new Location());
