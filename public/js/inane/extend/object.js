/**
 * Extend Object
 *
 * @version 1.7.0
 * @author Philip Michael Raab<peep@inane.co.za>
 *
 * Public Domain.
 * NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.
 */

/**
 * 1.7.0 (2022 Jan 12)
 *  + groupBy: Group by a property
 *
 * 1.6.0 (2022 Jan 12)
 *  + propertyRename: Rename a property
 *
 * 1.5.0 (2021 Nov 10)
 *  + sorted   : Get a sorted copy of object
 *  - pick     : Update - can also take a string if only one property required
 *  - pick     : Fix - returns undefined for invalid properties
 *
 * 1.4.0 (2021 Oct 28)
 *  + readWithPath : returns property value using a string as path
 *
 * 1.3.0 (2020 Aug 06)
 *  + pick     : return new object with only the properties requested in array
 *
 * 1.2.0 (2020 Jul 08)
 *  - New      : watch now returns a change object with properties: property, value, previous
 *  - Upd      : watch now returns a change object with properties: property, value, previous
 *
 * 1.1.0 (2018 Nov 01)
 *  - New      : handler now only gets call if oldVal !== newVal
 *
 * 1.0.1 (2016 Apr 08)
 *  - Fixed    : oldVal returns undefined after 1st change
 */

/*
let o = {p: 'yyyy'};
o.watch('p', change=>console.log(change));
o.p = 'la de da';
*/

// object.watch
if (!Object.prototype.watch) {
    // if ('function' == typeof window.dump) window.dump('INANE:EXTEND', 'OBJECT', 'watch');
    Object.defineProperty(Object.prototype, 'watch', {
        enumerable: false,
        configurable: false,
        writable: true,
        value: function (prop, handler) {
            var getter,
                setter,
                change = {
                    property: prop,
                    value: this[prop],
                    previous: undefined,
                    set update(v) {
                        if (this.value == v) return false;
                        this.previous = this.value;
                        this.value = v;
                        return true;
                    }
                },
                getter = function () {
                    return change.value;
                },
                setter = function (val) {
                    if (change.update = val) handler.call(this, change);
                    return val;
                };
            if (delete this[prop]) { // can't watch constants
                Object.defineProperty(this, prop, {
                    get: getter,
                    set: setter,
                    // enumerable: true,
                    configurable: true
                });
            }
        }
    });
}

// object.unwatch
if (!Object.prototype.unwatch) {
    // if ('function' == typeof window.dump) window.dump('INANE:EXTEND', 'OBJECT', 'unwatch');
    Object.defineProperty(Object.prototype, 'unwatch', {
        enumerable: false,
        configurable: false,
        writable: true,
        value: function (prop) {
            var val = this[prop];
            delete this[prop]; // remove accessors
            this[prop] = val;
        }
    });
}

if (!Object.prototype.jsonString) {
    // if ('function' == typeof window.dump) window.dump('INANE:EXTEND', 'OBJECT', 'jsonString');
    /**
     * Returns Object as json string, ala stringify
     *
     * @return {string}
     */
    Object.defineProperty(Object.prototype, 'jsonString', {
        enumerable: false,
        configurable: false,
        writable: true,
        value: function () {
            return JSON.stringify(this);
        }
    });
}

/**
 * Returns Object with only propsArray properties of the original
 */
if (!Object.prototype.pick) {
    /**
     * Returns Object with only propsArray properties of the original
     *
     * @since 1.3.0
     * @since 1.5.0 can also take a string if only one property required
     *
     * @param propsArray Array of properties to pick or string of a single property
     *
     * @return {object}
     */
    Object.defineProperty(Object.prototype, 'pick', {
        enumerable: false,
        configurable: false,
        writable: true,
        value: function (propsArray) {
            if (!propsArray) return;
            if (!Array.isArray(propsArray) && (typeof propsArray == "string")) propsArray = [propsArray];
            propsArray = propsArray.unique();

            const picked = {};
            propsArray.forEach(prop => {
                if (this.hasOwnProperty(prop)) picked[prop] = this[prop];
            });

            return picked;
        }
    });
}

/**
 * Read property using string path
 */
if (!Object.prototype.readPath) {
    /**
     * Get the value of a property using a string for the path
     *
     * @since 1.4.0
     *
     * @param path string as path
     * @param delimiter path delimiter if not period (.)
     *
     * @return {mixed} property value
     */
    Object.defineProperty(Object.prototype, 'readPath', {
        enumerable: false,
        configurable: false,
        writable: true,
        value: function (path, delimiter = '.') {
            if (!path) return this;

            const eP = typeof path == 'string' ? path.split(delimiter) : path;
            let t = Object.assign({}, this);

            for (let i = 0; i < eP.length; i++)
                if (t && t.hasOwnProperty(eP[i])) t = t[eP[i]];
                else t = undefined;

            return t;
        }
    });
}

/**
 * Get a sorted copy of object
 */
if (!Object.prototype.sorted) {
    /**
     * Get a sorted copy of object
     *
     * @since 1.5.0
     *
     * @return {Object} sorted object
     */
    Object.defineProperty(Object.prototype, 'sorted', {
        enumerable: false,
        configurable: false,
        writable: true,
        value: function () {
            return this.pick(Object.keys(this).sort());
        }
    });
}

/**
 * Rename property
 */
if (!Object.prototype.propertyRename) {
    /**
     * Rename property
     *
     * - if new_key exists nothing is done
     *
     * @since 1.6.0
     *
     * @param {string} old_key - property to rename
     * @param {string} new_key - new name for property
     *
     * @return {Object} this object
     */
    Object.defineProperty(Object.prototype, 'propertyRename', {
        enumerable: false,
        configurable: false,
        writable: true,
        value: function (old_key, new_key) {
            if ((old_key !== new_key) && (this.hasOwnProperty(old_key) && !this.hasOwnProperty(new_key))) {
                Object.defineProperty(this, new_key, Object.getOwnPropertyDescriptor(this, old_key));
                delete this[old_key];
            }

            return this;
        }
    });
}

/**
 * Returns object grouped by property
 */
if (!Object.prototype.groupBy) {
    /**
     * Group by property
     *
     * @since 1.7.0
     *
     * @param {string} key - property to group by
     *
     * @return {Object} object with values group by key
     */
    Object.defineProperty(Object.prototype, 'groupBy', {
        enumerable: false,
        configurable: false,
        writable: true,
        value: function (key) {
            try {
                let target = Array.isArray(this) ? this : Object.values(this);
                return target.reduce((rv, x) => {
                    (rv[x[key]] = rv[x[key]] || []).push(x);
                    return rv;
                }, {});
            } catch (error) {
                console.error('Unable to group object.');
            }
        }
    });
}

// const obj = {
//     "A": "Aye,",
//     "B": "Bee",
//     "C": {
//         "A": "CAye,",
//         "B": "CBee",
//         "C": "CCee",
//     },
// };

// console.log(obj.readPath('C.B'));
// console.log(obj.readPath(['C', 'A']));
