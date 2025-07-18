/**
 * iFile
 *
 * File Attributes made easy
 *
 * @see https://git.inane.co.za:3000/Inane/inane-js/wiki/Inane_icRoot-iFile
 *
 * @author Philip Michael Raab <philip@cathedral.co.za>
 * @version 0.3.0
 */

/**
 * moduleName
 *
 * @constant
 * @type {String}
 * @memberof iFile
 */
const moduleName = 'iFile';

/**
 * iFile
 *
 * @version 0.3.0
 */
class iFile {
    /**
     * Version
     *
     * @readonly
     * @static
     * @returns {String}
     * @memberof iFile
     */
    static get VERSION() {
        return '0.3.0';
    }

    /**
     * Version
     *
     * @readonly
     * @returns {String}
     * @memberof iFile
     */
    get VERSION() {
        return this.constructor.VERSION;
    }

    /**
     * File to be enhanced with iFile
     *
     * @private
     * @type {File|null}
     * @description Represents a file object. It is initially set to null.
     */
    #file = null; // File object

    /**
     * Creates an instance of iFile.
     *
     * @param {File} file the file
     * @constructor
     */
    constructor(file) {
        this.#file = file;
    }

    /**
     * Get HTML File Object
     *
     * @readonly
     * @returns {File}
     * @memberof iFile
     */
    get file() {
        return this.#file;
    }

    /**
     * Get File size (b)
     *
     * @readonly
     * @returns {number}
     * @memberof iFile
     */
    get size() {
        return this.file.size;
    }

    /**
     * Get File size (KB)
     *
     * @readonly
     * @returns {number}
     * @memberof iFile
     */
    get KB() {
        if (!this._kb) this._kb = Math.round(this.size * 100 / 1024) / 100;
        return this._kb;
    }

    /**
     * Get File size (MB)
     *
     * @readonly
     * @returns {number}
     * @memberof iFile
     */
    get MB() {
        if (!this._mb) this._mb = Math.round(this.size * 100 / (1024 * 1024)) / 100;
        return this._mb;
    }

    /**
     * Get File name
     *
     * @readonly
     * @returns {string}
     * @memberof iFile
     */
    get name() {
        if (!this._name) this._name = this.file['name'];
        return this._name;
    }

    /**
     * Get File extension
     *
     * @readonly
     * @returns {string}
     * @memberof iFile
     */
    get ext() {
        if (!this._ext) this._ext = this.name.substring((this.name.lastIndexOf('.') + 1));
        return this._ext;
    }

    /**
     * Get File mime type
     *
     * @readonly
     * @returns {string}
     * @memberof iFile
     */
    get type() {
        if (!this._type) this._type = this.file['type'];
        return this._type;
    }

    /**
     * Get Object URL
     *
     * @readonly
     * @returns {string}
     * @memberof iFile
     */
    get objectURL() {
        return URL.createObjectURL(this.file);
    }

    /**
     * Log all properties to console
     *
     * @returns {iFile}
     * @memberof iFile
     */
    dump() {
        console.log({ 'name': this.name, 'ext': this.ext, 'size': this.size, 'KB': this.KB, 'MB': this.MB, 'type': this.type });
        return this;
    }
}

export default iFile;
