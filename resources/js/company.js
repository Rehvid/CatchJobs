'use strict'

import Tagify from '@yaireo/tagify'

import "@yaireo/tagify/dist/tagify.css";
import { createCKEditorForTextarea, getDataFromServer} from "./app";


class Company {
    constructor() {
        this.init();
    }
    init() {
        this.createTagifyForIndustryInput();
        this.createTagifyForBenefitInput();
        this.initCKEditorForDescriptionField();
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
}

document.addEventListener('DOMContentLoaded', () => new Company());
