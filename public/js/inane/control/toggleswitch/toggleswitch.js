(function () {
    /**
     * Version
     */
    const version = '0.1.0';

    /**
     * @type {Object} defaults
     */
    const _defaults = {
        text: '',
        colour: 'white',
        chkColour: 'colour',
        background: '#CCC',
        chkBackground: '#2196F3',
        outline: 'transparent',
        textOn: '',
        colourOn: 'initial',
        textOff: '',
        colourOff: 'initial',
        onoffAlt: false,
    };

    /**
     * ToggleSwitch
     * 
     * @attribute size - font size
     * 
     * PS: label wins over img if both set
     *
     * @extends {HTMLElement}
     * @version 0.1.0
     */
    class ToggleSwitch extends HTMLElement {
        /**
         * Attributes that trigger an update
         * 
         * @static
         * @property
         * @readonly
         * @returns {String[]}
         */
        static get observedAttributes() {
            return ['checked', 'round', 'colour', 'chkColour', 'background', 'chkbackground', 'outline', 'text', 'texton', 'colouron', 'textoff', 'colouroff', 'onoffalt'];
        }

        /**
         * Creates an instance of ToggleSwitch
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

            const label = document.createElement('label');
            const input = document.createElement('input');
            const span = document.createElement('span');
            const text = document.createElement('span');
            const style = document.createElement('style');
            input.type = 'checked';
            label.classList.add('switch');
            span.classList.add('slider');
            text.classList.add('text');

            label.appendChild(input);
            label.appendChild(span);
            label.appendChild(text);
            shadow.appendChild(style);
            shadow.appendChild(label);
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
         * chkColour
         * 
         * @property
         * @readonly
         * @returns {string}
         */
        get chkColour() {
            let colour = this.getAttribute('chkcolour') || _defaults.chkColour;
            if (colour == 'colour') colour = this.colour;
            return colour;
        }

        /**
         * background
         * 
         * @property
         * @readonly
         * @returns {string}
         */
        get background() {
            return this.getAttribute('background') || _defaults.background;
        }

        /**
         * chkBackground
         * 
         * @property
         * @readonly
         * @returns {string}
         */
        get chkBackground() {
            return this.getAttribute('chkbackground') || _defaults.chkBackground;
        }

        /**
         * outline
         * 
         * @property
         * @readonly
         * @returns {string}
         */
        get outline() {
            return this.getAttribute('outline') || _defaults.outline;
        }

        /**
         * text
         * 
         * @property
         * @readonly
         * @returns {string}
         */
        get text() {
            return this.getAttribute('text') || this.textContent || _defaults.text;
        }

        /**
         * textOn
         * 
         * @property
         * @readonly
         * @returns {string}
         */
        get textOn() {
            return this.getAttribute('texton') || _defaults.textOn;
        }

        /**
         * colourOn
         * 
         * @property
         * @readonly
         * @returns {string}
         */
        get colourOn() {
            return this.getAttribute('colouron') || _defaults.colourOn;
        }

        /**
         * textOff
         * 
         * @property
         * @readonly
         * @returns {string}
         */
        get textOff() {
            return this.getAttribute('textoff') || _defaults.textOff;
        }

        /**
         * colourOff
         * 
         * @property
         * @readonly
         * @returns {string}
         */
        get colourOff() {
            return this.getAttribute('colouroff') || _defaults.colourOff;
        }

        /**
         * onoffAlt
         * 
         * @property
         * @readonly
         * @returns {boolean}
         */
        get onoffAlt() {
            return this.hasAttribute('onoffalt');
        }

        set checked(value) {
            const isChecked = Boolean(value);
            if (isChecked) this.setAttribute('checked', '');
            else this.removeAttribute('checked');
        }

        get checked() {
            return this.hasAttribute('checked');
        }

        get ctrlSize() {
            if (true) {
                return {
                    width: '3.75em',
                    swap: '1.625em',
                };
            } else {
                return {
                    width: '4.5em',
                    swap: '2.5em',
                };
            }
        }

        _upgradeProperty(prop) {
            if (this.hasOwnProperty(prop)) {
                let value = this[prop];
                delete this[prop];
                this[prop] = value;
            }
        }

        _onClick(event) {
            event.preventDefault();
            this._toggleChecked();
        }

        _toggleChecked() {
            this.checked = !this.checked;
            this.dispatchEvent(new CustomEvent('change', {
                detail: {
                    checked: this.checked,
                },
                bubbles: true,
            }));
        }

        /**
         * Custom element added to page
         */
        connectedCallback() {
            if (this.hasAttribute('round')) this.shadow.querySelector('.slider').classList.add('round');

            this.updateStyle();
            this.updateText();
            this._upgradeProperty('checked');
            this.addEventListener('click', this._onClick);

            this.watch('textContent', (data) => {
                this.setAttribute('text', data.value);
            });
        }

        /**
         * Custom element removed from page
         */
        disconnectedCallback() {
        }

        /**
         * Custom element moved to new page
         */
        adoptedCallback() {
        }

        /**
         * Attribute changed
         */
        attributeChangedCallback(name, oldValue, newValue) {
            const hasValue = newValue !== null;
            switch (name) {
                case 'checked':
                    this.setAttribute('aria-checked', hasValue);
                    break;
                case 'round':
                    if (hasValue) this.shadow.querySelector('.slider').classList.add('round');
                    else this.shadow.querySelector('.slider').classList.remove('round');
                    break;
                case 'text':
                    this.updateText();
                    break;
                default:
                    this.updateStyle();
            }
        }

        /**
         * Update Style
         */
        updateStyle() {
            this.shadow.querySelector('style').textContent = `
:host {
    all: initial;
    contain: content;
}
.switch {
    position: relative;
    display: inline-block;
    width: ${this.ctrlSize.width};
    height: 2em;
}
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: ${this.background};
    box-shadow: 0 0 1px 1px ${this.outline}, 0 0 1px 1px ${this.outline}, 0 0 1px 1px ${this.outline};
    -webkit-transition: .4s;
    transition: .4s;
}
:host-context(.shadow) .slider {
    box-shadow: 1px 1px 4px -1px ${this.outline};
}
.slider:after,
.slider:before {
    position: absolute;
    overflow: hidden;
    line-height: 1.5em;
    text-align: center;
    height: 1.5em;
    width: 1.5em;
    bottom: 0.25em;
    -webkit-transition: .4s;
    transition: .4s;
}
.slider:before {
    left: 0.35em;
    content: "${!this.onoffAlt ? this.textOff : _defaults.textOff}";
    color: ${!this.onoffAlt ? this.colourOff : _defaults.colourOff};
    background-color: ${this.colour};
}
.slider:after {
    right: .35em;
    content: "${this.onoffAlt ? this.textOn : _defaults.textOn}";
}
:host([checked]) .slider {
    background-color: ${this.chkBackground};
}
:host:focus .slider {
    box-shadow: 0 0 1px ${this.chkBackground};
}
:host([checked]) .slider:before {
    content: "${!this.onoffAlt ? this.textOn : _defaults.textOn}";
    color: ${!this.onoffAlt ? this.colourOn : _defaults.colourOn};
    background-color: ${this.chkColour};
    -webkit-transform: translateX(${this.ctrlSize.swap});
    -ms-transform: translateX(${this.ctrlSize.swap});
    transform: translateX(${this.ctrlSize.swap});
}
:host([checked]) .slider:after {
    content: "${this.onoffAlt ? this.textOff : _defaults.textOff}";
    color: ${this.onoffAlt ? this.colourOff : _defaults.colourOff};
    -webkit-transform: translateX(-${this.ctrlSize.swap});
    -ms-transform: translateX(-${this.ctrlSize.swap});
    transform: translateX(-${this.ctrlSize.swap});
}
.slider.round {
    border-radius: 2.125em;
}
.slider.round:before {
    border-radius: 50%;
}
.switch .text {
    position: absolute;
    right: -100%;
    left: 50%;
    top: 50%;
    font-size: 150%;
    margin: 0;
    cursor: pointer;
    white-space: nowrap;
    transform: translate(50%, -50%);
}`;
        }

        /**
         * Update Text
         */
        updateText() {
            if (this.textContent != this.text) this.textContent = this.text;
            this.shadow.querySelector('.text').textContent = this.text;
        }
    }

    // Define the new element
    customElements.define('toggle-switch', ToggleSwitch);
})();
