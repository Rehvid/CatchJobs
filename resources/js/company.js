'use strict'

import Tagify from '@yaireo/tagify'

import "@yaireo/tagify/dist/tagify.css";
import {createCKEditorForTextarea, deleteDataFromServer, getDataFromServer} from "./app";


class Company {
    constructor() {
        this.init();
    }
    init() {
        this.createTagifyForIndustryInput();
        this.createTagifyForBenefitInput();
        this.initCKEditorForDescriptionField();
        this.selectOldValueEmployeesOption();
        this.removeImage();
    }

    selectOldValueEmployeesOption() {
        const oldValueEmployees = document.querySelector('.old_employees');
        const selectEmployees = document.querySelector('#employees');

        if (!oldValueEmployees || !selectEmployees) {
            return false;
        }

        if (oldValueEmployees.value) {
            selectEmployees.value = oldValueEmployees.value;
        }
    }

    async createTagifyForIndustryInput() {
        const industryInput = document.querySelector('.js-industry') || false;
        if (!this.isInputValidForTagify(industryInput)) {
            return false;
        }

        const url = industryInput.getAttribute('data-url');
        const industriesData = await getDataFromServer(url);

        industriesData.json().then(industries => {
            new Tagify(industryInput, {
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(','),
                maxTags: 1,
                dropdown: {
                    enabled: 0,
                    classname: "tags-look",
                    maxItems: 10,
                },
                enforceWhiteList: true,
                whitelist:industries,
            })
        })
    }

    async createTagifyForBenefitInput() {
        const benefitInput = document.querySelector('.js-benefit') || false;
        if (!this.isInputValidForTagify(benefitInput)) {
            return false;
        }

        const url = benefitInput.getAttribute('data-url');
        const benefitsData = await getDataFromServer(url);

        benefitsData.json().then(benefits => {
            new Tagify(benefitInput, {
                dropdown: {
                    enabled: 0,
                    classname: "tags-look",
                    maxItems: 10,
                },
                enforceWhiteList: true,
                whitelist:benefits,
            })
        })
    }

    isInputValidForTagify(input) {
        return input !== false && input.hasAttribute('data-url');
    }

    initCKEditorForDescriptionField() {
        createCKEditorForTextarea(document.querySelector('.js-textarea'));
    }

    async removeImage() {
        document.addEventListener('click', async (e) => {
            const { target } = e;

            if (target.classList.contains('js-remove-image')) {

                const data = {
                    id: target.getAttribute('data-image-id'),
                    company_id: target.getAttribute('data-company-id')
                }

                const response =  await deleteDataFromServer(target.getAttribute('data-url'), data);
                response.json().then(response => {
                    if (response.status) {
                        target.closest('div').remove();
                    }
                })
            }
        })
    }
}

document.addEventListener('DOMContentLoaded', () => new Company());
