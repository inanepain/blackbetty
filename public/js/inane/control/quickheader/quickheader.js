(function () {
    /**
     * Version
     */
    const version = '0.3.1';

    /**
     * @type {Object} defaults
     */
    const _defaults = {
        text: 'Quick Header',
        textAlign: 'center',
        size: 48,
        weight: 400,
        top: '0rem',
        right: '.5rem',
        bottom: '.25rem',
        left: '.5rem',
        colour: '#000',
        lineColour: '#000',
        lineWidth: '100%',
        lineAlign: 'center',
    };

    /**
     * Verifies that a string is a number and unit
     *
     * @param {string|number} value - the string to check
     * @param {string} unit - the unit to use if non found
     *
     * @return {string}
     */
    const numberUnit = (value, unit) => {
        value = value.toString();
        let sizeNumber = value.match(/[\.]?[\d,]+\.?\d?/)?.[0] || '';
        let sizeUnit = value.replace(/\d+/g, '').replace('.','') || unit;

        return sizeNumber.concat(sizeUnit);
    }

    /**
     * QuickHeader
     *
     * @attribute text - header text
     * @attribute textAlign - text alignment
     * @attribute size - text size
     * @attribute weight - font weight
     * @attribute colour - text colour
     * @attribute top - top margin
     * @attribute right - right margin
     * @attribute bottom - bottom margin
     * @attribute left - left margin
     * @attribute underline - underline header
     * @attribute inline - display header inline
     * @attribute lineColour - line colour
     * @attribute lineWidth - line width
     * @attribute lineAlign - line alignment
     *
     * PS: label wins over img if both set
     *
     * @extends {HTMLElement}
     * @version 0.3.1
     */
    class QuickHeader extends HTMLElement {
        /**
         * Attributes that trigger an update
         *
         * @static
         * @property
         * @readonly
         * @returns {String[]}
         */
        static get observedAttributes() {
            return ['text', 'textalign', 'size', 'colour', 'weight', 'top', 'right', 'bottom', 'left', 'underline', 'linecolour', 'linewidth', 'linealign', 'inline'];
        }

        /**
         * Creates an instance of QuickHeader
         * @constructor
         */
        constructor() {
            // Always call super first in constructor
            super();

            /**
             * Version
             */
            Object.defineProperty(this, 'VERSION', {
                value: version,
                writable: false
            });

            /**
             * Version
             * @static
             */
            Object.defineProperty(this.constructor, 'VERSION', {
                value: version,
                writable: false
            });

            // Create a shadow root
            let shadow = this.attachShadow({ mode: 'closed' });
            this.shadow = shadow;

            const text = document.createElement('div');
            const line = document.createElement('hr');
            const style = document.createElement('style');
            text.classList.add('qh-text');
            line.classList.add('qh-line');

            shadow.appendChild(style);
            shadow.appendChild(text);
            shadow.appendChild(line);

            this.watch('textContent', (data) => {
                // {property: "textContent", value: "xxx", previous: "ggg"}
                this.setAttribute('text', data.value);
            });
        }

        /**
         * text
         *
         * @property
         * @readonly
         * @returns {string}
         */
        get text() {
            // return this.textContent || _defaults.text;
            return this.getAttribute('text') || this.textContent || _defaults.text;
        }

        /**
         * text align
         *
         * @property
         * @readonly
         * @returns {String}
         */
        get textAlign() {
            let align = this.getAttribute('textalign');
            if (!['left', 'right', 'initial'].includes(align)) align = _defaults.textAlign;
            return align;
        }

        /**
         * size
         *
         * @property
         * @readonly
         * @returns {number}
         */
        get size() {
            return numberUnit(this.getAttribute('size') || _defaults.size, 'px');
        }

        /**
         * weight
         *
         * @property
         * @readonly
         * @returns {string|number}
         */
        get weight() {
            let weight = this.getAttribute('weight') || _defaults.weight;
            if (!['bold', 'bolder', 'lighter', 'normal', '100', '200', '300', '400', '500', '600', '700', '800', '900'].includes(weight)) weight = _defaults.weight;

            return weight;
        }

        /**
         * colour
         *
         * @property
         * @readonly
         * @returns {string}
         */
        get colour() {
            return this.getAttribute('colour') || _defaults.colour;
        }

        /**
         * Padding Top
         *
         * @property
         * @readonly
         * @returns {String}
         */
        get top() {
            return numberUnit(this.getAttribute('top') || _defaults.top, 'rem');
        }

        /**
         * Padding Right
         *
         * @property
         * @readonly
         * @returns {String}
         */
        get right() {
            return numberUnit(this.getAttribute('right') || _defaults.right, 'rem');
        }

        /**
         * Padding Bottom
         *
         * @property
         * @readonly
         * @returns {String}
         */
        get bottom() {
            return numberUnit(this.getAttribute('bottom') || _defaults.bottom, 'rem');
        }

        /**
         * Padding Left
         *
         * @property
         * @readonly
         * @returns {String}
         */
        get left() {
            return numberUnit(this.getAttribute('left') || _defaults.left, 'rem');
        }

        /**
         * Use underline
         *
         * @property
         * @readonly
         * @returns {String}
         */
        get underline() {
            return this.hasAttribute('underline') ? 'block' : 'none';
        }

        /**
         * Display inline-block
         *
         * @property
         * @readonly
         * @returns {String}
         */
        get inline() {
            return this.hasAttribute('inline') ? 'inline-block' : 'block';
        }

        /**
         * line colour
         *
         * @property
         * @readonly
         * @returns {String}
         */
        get lineColour() {
            return this.getAttribute('linecolour') || _defaults.lineColour;
        }

        /**
         * line width
         *
         * @property
         * @readonly
         * @returns {String}
         */
        get lineWidth() {
            return numberUnit(this.getAttribute('linewidth') || _defaults.lineWidth, '%');
        }

        /**
         * line align
         *
         * @property
         * @readonly
         * @returns {String}
         */
        get lineAlign() {
            let align = this.getAttribute('linealign');
            if (!['left', 'right', 'initial'].includes(align)) align = _defaults.lineAlign;
            return align;
        }

        /**
         * Custom element added to page
         */
        connectedCallback() {
            // console.log('connectedCallback');
            if (!this.hasAttribute('linealign')) this.setAttribute('linealign', _defaults.lineAlign);
            if (!this.hasAttribute('linecolour')) this.setAttribute('linecolour', _defaults.lineColour);

            this.updateStyle();
            this.updateText();
        }

        /**
         * Custom element removed from page
         */
        disconnectedCallback() {
            // console.log('disconnectedCallback');
        }

        /**
         * Custom element moved to new page
         */
        adoptedCallback() {
            // console.log('adoptedCallback');
        }

        /**
         * Attribute changed
         */
        attributeChangedCallback(name, oldValue, newValue) {
            // console.log('attributeChangedCallback', name, oldValue, newValue);
            if (name == 'text') this.updateText();
            else this.updateStyle();
        }

        /**
         * Update Style
         */
        updateStyle() {
            this.shadow.querySelector('style').textContent = `
:host {
    all: initial;
    display: ${this.inline};
    font-family: inherit;
    contain: content;
}
:host-context(i) .qh-text {
    font-style: italic;
}
:host-context(.theme) .qh-text {
    font-style: italic;
}
.qh-text {
    margin: ${this.top} ${this.right} ${this.bottom} ${this.left};
    font-size: ${this.size};
    font-weight: ${this.weight};
    color: ${this.colour};
    text-align: ${this.textAlign};
    cursor: default;
    // -webkit-user-select: none;
    // -moz-user-select: none;
    // -ms-user-select: none;
    // user-select: none;
}
.qh-line {
    display: ${this.underline};
    float: ${this.lineAlign};
    height: 1px;
    width: ${this.lineWidth};
    margin-top: 0px;
    color: ${this.lineColour};
    background: ${this.lineColour};
}`;
        }

        /**
         * Update Text
         */
        updateText() {
            if (this.textContent != this.text) this.textContent = this.text;
            this.shadow.querySelector('div').textContent = this.text;
        }
    }

    // Define the new element
    customElements.define('quick-header', QuickHeader);
})();
