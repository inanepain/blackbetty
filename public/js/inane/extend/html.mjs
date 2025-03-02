/**
 * HTML Enhancements
 * @author Philip Michael Raab<philip@inane.co.za>
 * @version 1.0.0
 */

/**
 * Collections
 */
 for (let element of [HTMLCollection, NodeList]) {
     // test for toArray
    if (!element.prototype.toArray) {
        /**
         * toArray
         * 
         * @returns {Array}
         */
        element.prototype.toArray = function () {
            return Array.from(this);
        }
    }
}

/**
 * Items
 */
for (let element of [HTMLDocument, HTMLElement]) {
    // test for iqs
    if (!element.prototype.iqs) {
        /**
         * iqs
         * 
         * @param {DOMString} selectors selector
         * 
         * @returns HTMLElement
         */
        element.prototype.iqs = function (selectors) {
            if (this && this.querySelector) return this.querySelector(selectors);
            return window.document.querySelector(selectors);
        }
    }

    // assign global iqs
    if (!window.iqs && window.document.iqs) window.iqs = window.document.iqs;
    // test for iqsa
    if (!element.prototype.iqsa) {
        /**
         * iqsa
         * 
         * @param {DOMString} selectors selector
         * 
         * @returns NodeList
         */
        element.prototype.iqsa = function (selectors) {
            if (this && this.querySelectorAll) return this.querySelectorAll(selectors);
            return window.document.querySelectorAll(selectors);
        }
    }

    // assign global iqsa
    if (!window.iqsa && window.document.iqsa) window.iqsa = window.document.iqsa;
}
