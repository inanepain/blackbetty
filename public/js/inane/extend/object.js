/**
 * object.watch polyfill
 *
 * @version 1.3.0
 * @author Philip Michael Raab<peep@inane.co.za>
 *
 * Public Domain.
 * NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.
 */

/**
 * 1.3.0 (2020 Aug 06)
 *  + pick  : return new object with only the properties requested in array
 * 
 * 1.2.0 (2020 Jul 08)
 *  - New  : watch now returns a change object with properties: property, value, previous
 *  - Upd  : watch now returns a change object with properties: property, value, previous
 * 
 * 1.1.0 (2018 Nov 01)
 *  - New  : handler now only gets call if oldVal !== newVal
 * 
 * 1.0.1 (2016 Apr 08)
 *  - Fixed: oldval returns undefined after 1st change
 */

/*
let o = {p: 'yyyy'};
o.watch('p', change=>console.log(chnage));
o.p = 'la de da';
*/

// object.watch
if (!Object.prototype.watch) {
    // if ('function' == typeof window.dump) window.dump('INANE:EXTEND', 'OBJECT', 'watch');
    Object.defineProperty(Object.prototype, 'watch', {
        enumerable: false,
        configurable: true,
        writable: false,
        value: function (prop, handler) {
            var getter, setter,
                change = { property: prop, value: this[prop], previous: undefined, set update(v) { if (this.value == v) return false; this.previous = this.value; this.value = v; return true; } },
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
                    enumerable: true,
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
        configurable: true,
        writable: false,
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
        configurable: true,
        writable: false,
        value: function () {
            return JSON.stringify(this);
        }
    });
}

if (!Object.prototype.pick) {
    /**
     * Returns Object with only propsArray properties of the original
     *
     * @return {object}
     */
    Object.defineProperty(Object.prototype, 'pick', {
        enumerable: false,
        configurable: true,
        writable: false,
        value: function (propsArray) {
            if (!propsArray) return;
            const picked = {};
            propsArray.forEach(prop => picked[prop] = this[prop]);

            return picked;
        }
    });
}
