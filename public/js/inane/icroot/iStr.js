/**
 * iStr
 * 
 * Description
 * @see https://git.inane.co.za:3000/Inane/inane-js/wiki/Inane_icRoot-iStr
 * 
 * @author Philip Michael Raab <peep@inane.co.za>
 */

/**
 * Version
 * 
 * @constant
 * @type {String}
 * @memberof iStr
 */
const VERSION = '0.4.0';

/**
* moduleName
* 
* @constant
* @type {String}
*/
const moduleName = 'iStr';

if (window.Dumper) Dumper.dump('MODULE', moduleName.concat(' v').concat(VERSION), 'LOAD');

/**
 * iStr
 * 
 * Quick string functions
 * 
 * @example
 * // returns Hello World
 * iStr.c('Hello')._().a('world').ep('s').a('example').s
 *
 * @version 0.4.0
//  * @class iStr
 */
class iStr {
    /**
     * Creates an instance of iStr
     * 
     * @constructor
     * @param {string} string
    //  * @memberof iStr
     */
    constructor(string) {
        this._string = string;
        this._i = '*';
        this._b = '__';
        this._bi = '***';
        this.prefs = 's';

        this._j = ' ';
    }

    /**
     * Version
     *
     * @readonly
     * @static
     * @returns {String}
     * @memberof iStr
     */
    static get VERSION() {
        return VERSION;
    }

    /**
     * Version
     *
     * @readonly
     * @returns {String}
     * @memberof iStr
     */
    get VERSION() {
        return VERSION;
    }

    /**
     * italic
     *
     * @static
     * @returns {String}
     * @memberof iStr
     */
    static get italic() {
        return '*';
    }

    /**
     * bold
     *
     * @static
     * @returns {String}
     * @memberof iStr
     */
    static get bold() {
        return '__';
    }

    /**
     * bolditalic
     *
     * @static
     * @returns {String}
     * @memberof iStr
     */
    static get boldItalic() {
        return '***';
    }

    /**
     * Create a new instance of iStr
     *
    //  * @constructs
     * @static
     * @param {String}
     * @returns {String}
     * @memberof iStr
     */
    static c(string = '') {
        return (new this(string));
    }

    /**
     * Check Preferences
     *
     * @param {string} pref
     * @returns
     * @memberof iStr
     */
    cp(pref) {
        return this.prefs.includes(pref.toUpperCase());
    }

    /**
     * Enable Preferences
     *
     * @param {string} pref
     * @returns
     * @memberof iStr
     */
    ep(pref) {
        if (!this.cp(pref))
            this.prefs = this.prefs.replace(pref.toLowerCase(), pref.toUpperCase());
        return this;
    }

    /**
     * Disable Preferences
     *
     * @param {string} pref
     * @returns
     * @memberof iStr
     */
    dp(pref) {
        if (this.cp(pref))
            this.prefs = this.prefs.replace(pref.toUpperCase(), pref.toLowerCase());
        return this;
    }

    /**
     * Sets joiner
     *
     * @param {string} string
     * @returns {iStr}
     * @memberof iStr
     */
    sj(joiner) {
        this._j = joiner;
        return this;
    }

    /**
     * output string
     *
     * @static
     * @returns {String}
     * @memberof iStr
     */
    get s() {
        return this._string;
    }

    /**
     * Add string
     *
     * @param {string} string
     * @returns {iStr}
     * @memberof iStr
     */
    a(string) {
        if (this.cp('s')) this._string += this._j;
        this._string += string;
        return this;
    }

    /**
     * Add bold string
     *
     * @param {string} string
     * @returns {iStr}
     * @memberof iStr
     */
    b(string) {
        this.a(this._b + string + this._b);
        return this;
    }

    /**
     * Add italic string
     *
     * @param {string} string
     * @returns {iStr}
     * @memberof iStr
     */
    i(string) {
        this.a(this._i + string + this._i);
        return this;
    }

    /**
     * Add bold italic string
     *
     * @param {string} string
     * @returns {iStr}
     * @memberof iStr
     */
    bi(string) {
        this.a(this._bi + string + this._bi);
        return this;
    }

    /**
     * Add Space
     *
     * @returns {iStr}
     * @memberof iStr
     */
    _() {
        this.a(' ');
        return this;
    }
}

export default iStr;
