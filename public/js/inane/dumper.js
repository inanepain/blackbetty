/**
 * Dumper<br/>
 * Logging with filters, Named loggers, enhanced assert, ...<br/>
 * Module version
 *
 * @author Philip Michael Raab <peep@inane.co.za>
 * @copyright 2020 Philip Michael Raab <peep@inane.co.za>
 *
 * @license MIT
 *
 * @see {@link https://dumper.inane.co.za Documentation}
 * @see {@link https://git.inane.co.za:3000/Inane/inane-js/raw/master/LICENSE MIT license}
 *
 * vscode-fold=0
 */

/**
 * Version
 *
 * @constant
 * @type {string}
 */
const version = '2.0.0-dev';

const out = console;

/**
 * _classPrivateFieldGet
 *
 * @param {*} receiver
 * @param {*} privateMap
 * @memberof LogLevel
 */
function _classPrivateFieldGet(receiver, privateMap) { var descriptor = privateMap.get(receiver); if (!descriptor) { return undefined; } if (descriptor.get) { return descriptor.get.call(receiver); } return descriptor.value; }

/**
 * @type {WeakMap} stores object private property name values
 */
var _name = new WeakMap();
/**
 * @type {WeakMap} stores object private property value values
 */
var _value = new WeakMap();

/**
 * LogLevel
 * @version 1.0.0
 */
class LogLevel {
    /**
     * Creates an instance of LogLevel.
     *
     * @param {Object} options - options
     * @param {string} options.name - LogLevel name
     * @param {number} options.value - LogLevel value
     */
    constructor(options) {
        _name.set(this, {
            writable: true,
            value: options.name
        });
        _value.set(this, {
            writable: true,
            value: options.value
        });
    }

    /**
     * name
     *
     * @readonly
     * @type {string} LogLevel name
     */
    get name() {
        return _classPrivateFieldGet(this, _name);
    }
    /**
     * value
     *
     * @readonly
     * @type {number} LogLevel value
     */
    get value() {
        return _classPrivateFieldGet(this, _value);
    }

    /**
     * allows<br>
     * If this LogLevel blocks or passes LogLevel level.<br />
     * Omit level to validate as highest. On OFF fails.
     *
     * @param {LogLevel} [level] LogLevel to test.
     *
     * @returns {boolean} block or pass
     */
    allows(level) {
        if ([defaults.level, level].includes(Dumper.OFF)) return false;
        if (level == undefined) return true;
        return this.value - level.value <= 0;
    }
}

/**
 * Dumper Data
 * @namespace
 * @property {Object} name - LogLevels by name
 * @property {LogLevel} [name.TRACE={name: 'TRACE', value: 1}] - Trace level
 * @property {LogLevel} [name.DEBUG={name: 'DEBUG', value: 2}] - Debug level
 * @property {LogLevel} [name.INFO={name: 'INFO', value: 3}] - Info level
 * @property {LogLevel} [name.TIME={name: 'TIME', value: 4}] - Time level
 * @property {LogLevel} [name.WARN={name: 'WARN', value: 5}] - Warn level
 * @property {LogLevel} [name.ERROR={name: 'ERROR', value: 8}] - Error level
 * @property {LogLevel} [name.OFF={name: 'OFF', value: 99}] - Off level
 * @property {Object} value - LogLevels by value
 * @property {LogLevel} [value.1={name: 'TRACE', value: 1}] - Trace level
 * @property {LogLevel} [value.2={name: 'DEBUG', value: 2}]  - Debug level
 * @property {LogLevel} [value.3={name: 'INFO', value: 3}]  - Info level
 * @property {LogLevel} [value.4={name: 'TIME', value: 4}]  - Time level
 * @property {LogLevel} [value.4={name: 'WARN', value: 5}]  - Warn level
 * @property {LogLevel} [value.8={name: 'ERROR', value: 8}]  - Error level
 * @property {LogLevel} [value.99={name: 'OFF', value: 99}]  - Off level
 * @property {Object} style - colours
 * @property {Object} [style.assert={color: 'Crimson'}] - assert style
 * @property {Object} [style.log={color: 'Black'}] - log style
 * @property {Object} [style.trace={color: 'DarkBlue'}] - trace style
 * @property {Object} [style.debug={color: 'LightBlue'}] - debug style
 * @property {Object} [style.info={color: 'Blue'}] - info style
 * @property {Object} [style.warn={color: 'Orange'}] - warn style
 * @property {Object} [style.error={color: 'DarkRed'}] - error style
 */
const data = {
    name: {
        TRACE: new LogLevel({ value: 1, name: 'TRACE' }),
        DEBUG: new LogLevel({ value: 2, name: 'DEBUG' }),
        INFO: new LogLevel({ value: 3, name: 'INFO' }),
        TIME: new LogLevel({ value: 4, name: 'TIME' }),
        WARN: new LogLevel({ value: 5, name: 'WARN' }),
        ERROR: new LogLevel({ value: 8, name: 'ERROR' }),
        OFF: new LogLevel({ value: 99, name: 'OFF' }),
    },
    // value: {
    //     get [1]() { return this.name.TRACE; },
    //     get [2]() { return this.name.DEBUG; },
    //     get [3]() { return this.name.INFO; },
    //     get [4]() { return this.name.TIME; },
    //     get [5]() { return this.name.WARN; },
    //     get [8]() { return this.name.ERROR; },
    //     get [99]() { return this.name.OFF; },
    // },
    style: {
        assert: { color: 'Crimson' },
        log: { color: 'Black' },
        trace: { color: 'DarkBlue' },
        debug: { color: 'LightBlue' },
        info: { color: 'Blue' },
        warn: { color: 'Orange' },
        error: { color: 'DarkRed' },
    }
};

var tmp = Object.create(null);
tmp[1]=data.name.TRACE;
tmp[2]=data.name.DEBUG;
tmp[3]=data.name.INFO;
tmp[4]=data.name.TIME;
tmp[5]=data.name.WARN;
tmp[8]=data.name.ERROR;
tmp[99]=data.name.OFF;
Object.freeze(tmp);
data.value = tmp;
Object.freeze(data);
tmp = null;

/**
 * Dumper Options
 * @typedef {Object} Dumper#Options
 * @property {boolean} [clear=false] - clears the log
 * @property {LogLevel} [level={value: 5, name: 'WARN'}] - default log level
 * @property {boolean} [updatechain=true] - accept chained updates
 * @property {number} trickle - throttle ms time
 * @property {Object} assert - options for assert
 * @property {boolean} [assert.time=false] - adds timestamp to assert log
 * @property {boolean} [assert.hhmmss=false] - changes timestamp to time string
 * @property {number} [assert.limit=0] - limits 1 assert log per limit period
 * @memberof Dumper
 */
/**
 * @type {Dumper#Options} defaults
 */
const defaults = {
    clear: false,
    level: data.name.WARN,
    updatechain: true,
    trickle: 1000,
    assert: {
        time: false,
        hhmmss: false,
        limit: 0,
    },
};

/**
 * copyObject
 * @param {Object} original object to create a copy from
 * @returns {Object} a new unref copy of original
 * @memberof Dumper
 */
const copyObject = (original) => { return JSON.parse(JSON.stringify(original)); }
/**
 * Adds ONLY missing properties from objs to target in decreasing priority
 *
 * @example
 * // copy values from defaults missing in options to options
 * mergeOptions(options, defaults);
 *
 * @param {Object} target the targe object
 * @param {...Object} objs the source objects in decreasing order of priority
 *
 * @memberof Dumper
 */
const mergeOptions = (target, ...objs) => {
    var key, i;
    for (i = 0; i < objs.length; i++)
        for (key in objs[i])
            if (!(key in target) && objs[i].hasOwnProperty(key)) target[key] = objs[i][key];
            else
                try { // If we are dealing with child objects here we simple dive into them to process the whole object
                    if (target[key].constructor === Object && objs[i][key].constructor === Object) mergeOptions(target[key], objs[i][key]);
                } catch (error) { // If target has undefined or null we catch the error and set the value
                    if (error.message.includes('target[key].constructor')) target[key] = objs[i][key];
                }
};
/**
 * Throttle Options
 *
 * @typedef {Object} ThrottleOptions
 * @property {boolean} skipfirst - False: first call is instant, True: first call delayed
 * @memberof Dumper
 */
/**
 * Throttles and debounces a function
 *
 * @param {Function} func the function to restrict
 * @param {number} limitDelay the milliseconds between calls and delay to wait for last call
 * @param {ThrottleOptions} options extra options for throttle
 *
 * @returns {Function} the restricted function
 *
 * @memberof Dumper
 */
const throttle = (func, limitDelay = 1000, options = {}) => {
    mergeOptions(options, {
        skipfirst: false
    });
    let inThrottle = options.skipfirst;
    let inDebounce;
    return function () {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            inThrottle = true;
            func.apply(context, args);
            inThrottle = setTimeout(() => inThrottle = undefined, limitDelay);
        } else {
            clearTimeout(inDebounce);
            inDebounce = setTimeout(() => func.apply(context, args), limitDelay);
        }
    }
};
/**
 * formatMessage</br>
 * Create context string and prepend it to messages with applied style.<br>
 * The original messages object is modified, thus nothing is returned.
 *
 * @param {string[]} messages - the messages to apply context too
 * @param {Object} [context] - the dumper's context
 * @param {string[]} [context.name=[]] - context name array
 * @param {Dumper} [context.parent] - context parent Dumper
 * @param {Object|boolean} [style=false] - the style properties to apply to the context
 */
const formatMessage = (messages, context, style = false) => {
    if (typeof context !== 'undefined' && Array.isArray(context.name) && context.name.length > 0) {
        const name = '['.concat(context.name.join(' - ')).concat(']');
        if (style) messages.unshift(Object.entries(style).join('; ').replaceAll(',', ': ').concat(';'));
        messages.unshift((style ? '%c' : '').concat(name));
    }
};
/**
 * Returns valid LogLevel
 *
 * @param {LogLevel|string|number|Object} level name, value (as number or string), object with only name or value (as object or string)
 * @returns {LogLevel}
 * @memberof Dumper
 */
const validateLogLevel = (level) => {
    if (Object.values(data.name).includes(level)) return level;
    else if (typeof level === 'string' && Dumper[level.toUpperCase()]) return Dumper[level.toUpperCase()];
    else if (typeof level === 'number') return data.value[level];
    else if (!isNaN(level) && data.value[Number.parseInt(level)]) return data.value[Number.parseInt(level)];
    else if (typeof level === 'object' && typeof level.name === 'string' && Dumper[level.name.toUpperCase()]) return Dumper[level.name.toUpperCase()];
    else if (typeof level === 'object' && !isNaN(level.value) && data.level[Number.parseInt(level.value)]) return data.level[Number.parseInt(level.value)];
    return defaults.level;
};

/**
 * @type {Map} Children of Linked dumpers in Global
 */
const Children = new Map();

/**
 * @type {WeakMap} stores instance private property children/context values
 */
const _children = new WeakMap(), _context = new WeakMap();

/**
 * Dumper</br>
 * Logging with filters, Named loggers, enhanced assert, ...
 *
 * @version 2.0.0
 *
 * @author Philip Michael Raab <peep@inane.co.za>
 * @copyright 2020 Philip Michael Raab <peep@inane.co.za>
 *
 * @license MIT
 *
 * @see {@link https://dumper.inane.co.za Documentation}
 * @see {@link https://git.inane.co.za:3000/Inane/inane-js/raw/master/LICENSE MIT license}
 */
class Dumper {
    /**
     * Creates an instance of Dumper.
     *
     * @param {Dumper#Options} options - options {@link Dumper#Options}
     */
    constructor(options) {
        options = options || {};
        mergeOptions(options, defaults);

        if (options.linked === true) this.get = Dumper.get.bind(this);
        else this.get = Dumper.get.bind(Dumper);
        delete options.linked;

        this.log = Dumper.log.bind(this);
        this.trace = Dumper.trace.bind(this);
        this.debug = Dumper.debug.bind(this);
        this.info = Dumper.info.bind(this);
        this.warn = Dumper.warn.bind(this);
        this.error = Dumper.error.bind(this);

        this.time = Dumper.time.bind(this);
        this.timeEnd = Dumper.timeEnd.bind(this);
        this.timeLog = Dumper.timeLog.bind(this);

        this.count = Dumper.count.bind(this);
        this.countReset = Dumper.countReset.bind(this);

        this.getLevel = Dumper.getLevel.bind(this);
        this.setLevel = Dumper.setLevel.bind(this);

        this.group = out.group.bind(this);
        this.groupCollapsed = out.groupCollapsed.bind(this);
        this.groupEnd = out.groupEnd.bind(this);
        this.clear = out.clear.bind(this);

        this.trickle = throttle(this.debug, options.trickle);
        if (!this.dump) this.dump = () => { };

        Object.defineProperty(this, Dumper.TRACE.name, {
            value: Dumper.TRACE,
            writable: false
        });
        Object.defineProperty(this, Dumper.DEBUG.name, {
            value: Dumper.DEBUG,
            writable: false
        });
        Object.defineProperty(this, Dumper.INFO.name, {
            value: Dumper.INFO,
            writable: false
        });
        Object.defineProperty(this, Dumper.TIME.name, {
            value: Dumper.TIME,
            writable: false
        });
        Object.defineProperty(this, Dumper.WARN.name, {
            value: Dumper.WARN,
            writable: false
        });
        Object.defineProperty(this, Dumper.ERROR.name, {
            value: Dumper.ERROR,
            writable: false
        });
        Object.defineProperty(this, Dumper.OFF.name, {
            value: Dumper.OFF,
            writable: false
        });

        if (options.clear) this.clear();
        this.options = options;
    }

    /**
     * Gets a Named Dumper instance</br>
     * - If an instance by name exist it will be returned and NOT a new instance created.
     *
     * @static
     * @param {string} name
     * @param {Dumper#Options} [options={}]
     *
     * @returns {Dumper}
     */
    static get(name, options = {}) {
        const children = _classPrivateFieldGet(this, _children) || Children;
        if (!children.has(name)) {
            if (this.options) mergeOptions(options, this.options);
            if (options.level && options.level.name) options.level = options.level.name;

            options = copyObject(options);
            options.level = validateLogLevel(options.level);

            options.linked = true;
            const child = new Dumper(options);
            child.name = name;

            let context = copyObject(_classPrivateFieldGet(this, _context) || { name: [] });
            context.parent = this;
            context.name.push(name);

            _context.set(child, {
                writable: true,
                value: context
            });
            _children.set(child, {
                writable: true,
                value: new Map()
            });
            children.set(name, child);
        }
        return children.get(name);
    }

    /**
     * Version
     *
     * @readonly
     * @static
     * @type {string}
     */
    static get VERSION() {
        return version;
    }
    /**
     * Version
     *
     * @readonly
     * @type {string}
     */
    get VERSION() {
        return version;
    }

    /**
     * Level: TRACE
     * @example
     * { value: 1, name: 'TRACE' }
     *
     * @readonly
     * @static
     * @type {LogLevel}
     */
    static get TRACE() {
        return data.name.TRACE;
    }
    /**
     * Level: DEBUG
     * @example
     * { value: 2, name: 'DEBUG' }
     *
     * @readonly
     * @static
     * @type {LogLevel}
     */
    static get DEBUG() {
        return data.name.DEBUG;
    }
    /**
     * Level: INFO
     * @example
     * { value: 3, name: 'INFO' }
     *
     * @readonly
     * @static
     * @type {LogLevel}
     */
    static get INFO() {
        return data.name.INFO;
    }
    /**
     * Level: TIME
     * @example
     * { value: 4, name: 'TIME' }
     *
     * @readonly
     * @static
     * @type {LogLevel}
     */
    static get TIME() {
        return data.name.TIME;
    }
    /**
     * Level: WARN
     * @example
     * { value: 5, name: 'WARN' }
     *
     * @readonly
     * @static
     * @type {LogLevel}
     */
    static get WARN() {
        return data.name.WARN;
    }
    /**
     * Level: ERROR
     * @example
     * { value: 8, name: 'ERROR' }
     *
     * @readonly
     * @static
     * @type {LogLevel}
     */
    static get ERROR() {
        return data.name.ERROR;
    }
    /**
     * Level: OFF
     * @example
     * { value: 99, name: 'OFF' }
     *
     * @readonly
     * @static
     * @type {LogLevel}
     */
    static get OFF() {
        return data.name.OFF;
    }

    /**
     * Level
     *
     * @static
     * @returns {LogLevel} current LogLevel
     */
    static getLevel() {
        return (this.options || defaults).level;
    }
    /**
     * Set Level</br>
     * - Accepts: name, value (as number or string), object with only name or value (as object or string)
     * @example
     * // All valid: All the same
     * dumper.setLevel(Dumper.INFO);
     * dumper.setLevel('info');
     * dumper.setLevel(3);
     * dumper.setLevel('3');
     * dumper.setLevel({ name: 'info' });
     * dumper.setLevel({ value: 3 });
     * dumper.setLevel({ value: '3' });
     *
     * @static
     * @param {LogLevel|string|number} level name, value (as number or string), object with only name or value (as object or string)
     * @param {boolean} [chained=false] should not be set manually, true if update called from parent
     */
    static setLevel(level, chained = false) {
        const options = this.options || defaults;
        if (!(level instanceof LogLevel)) level = validateLogLevel(level);
        if (!chained || options.updatechain) options.level = level;

        // Global Dumper & LogLevel.OFF: We don't chain Level since Global.OFF stops all logging as is.
        if (!this.options && level == this.OFF) return;
        // Single Instance Dumper: Has no children so we stop here to prevent a Global setLevel call.
        else if (this.options && !(_classPrivateFieldGet(this, _children))) return this;

        for (let child of (_classPrivateFieldGet(this, _children) || Children).values()) child.setLevel(level, true);
        return this;
    }

    /**
     * Debug Dump
     *
     * @static
     * @param  {...any} vars
     */
    static dump(...vars) {
        if (out.dump) return out.dump.apply(this, vars);
    }

    /**
     * trace
     *
     * @static
     * @param  {...any} messages log messages
     */
    static trace(...messages) {
        formatMessage(messages, _classPrivateFieldGet(this, _context), data.style.trace);
        if (this.getLevel().allows(Dumper.TRACE)) return out.trace.apply(this, messages);
    }
    /**
     * debug
     *
     * @static
     * @param  {...any} messages log messages
     */
    static debug(...messages) {
        formatMessage(messages, _classPrivateFieldGet(this, _context), data.style.debug);
        if (this.getLevel().allows(Dumper.DEBUG)) return out.debug.apply(this, messages);
    }
    /**
     * info
     *
     * @static
     * @param  {...any} messages log messages
     */
    static info(...messages) {
        formatMessage(messages, _classPrivateFieldGet(this, _context), data.style.info);
        if (this.getLevel().allows(Dumper.INFO)) return out.info.apply(this, messages);
    }
    /**
     * warn
     *
     * @static
     * @param  {...any} messages log messages
     */
    static warn(...messages) {
        formatMessage(messages, _classPrivateFieldGet(this, _context), data.style.warn);
        if (this.getLevel().allows(Dumper.WARN)) return out.warn.apply(this, messages);
    }
    /**
     * error
     *
     * @static
     * @param  {...any} messages log messages
     */
    static error(...messages) {
        formatMessage(messages, _classPrivateFieldGet(this, _context), data.style.error);
        if (this.getLevel().allows(Dumper.ERROR)) return out.error.apply(this, messages);
    }
    /**
     * log
     *
     * @static
     * @param  {...any} messages log messages
     */
    static log(...messages) {
        formatMessage(messages, _classPrivateFieldGet(this, _context), data.style.log);
        if (this.getLevel().allows()) return out.log.apply(this, messages);
    }

    /**
     * assert
     *
     * @param  {...any} messages log messages
     */
    assert(assertion, ...messages) {
        formatMessage(messages, _classPrivateFieldGet(this, _context), data.style.assert);
        const new_ts = Date.now();
        const old_ts = this._last_assert || 0;
        // Stop here if limit not reached
        if (this.options.assert.limit && old_ts && new_ts - old_ts < this.options.assert.limit) return;
        if (this.options.assert.time) {
            messages.push(new_ts);
            const gap_ts = new_ts - old_ts;
            // Add date string to message if option set
            if (this.options.assert.hhmmss) messages.push((new Date(gap_ts).toISOString().substr(11, 8)).replace(new RegExp('^(00:)+', 'gm'), ''));
            else messages.push(gap_ts); // Add timestamp to message
        }
        this._last_assert = new_ts;
        messages.unshift(assertion);
        if (this.getLevel().allows()) return out.assert.apply(this, messages);
    }

    /**
     * time
     *
     * @static
     * @param  {string} [label=default]
     */
    static time(label = 'default') {
        let messages = [label];
        formatMessage(messages, _classPrivateFieldGet(this, _context));
        if (this.getLevel().allows(Dumper.TIME)) return out.time.call(this, messages.join(' - '));
    }

    /**
     * timeEnd
     *
     * @static
     * @param  {string} [label=default]
     */
    static timeEnd(label = 'default') {
        let messages = [label];
        formatMessage(messages, _classPrivateFieldGet(this, _context));
        if (this.getLevel().allows(Dumper.TIME)) return out.timeEnd.call(this, messages.join(' - '));
    }

    /**
     * timeLog
     *
     * @static
     * @param  {string} [label=default]
     */
    static timeLog(label = 'default') {
        let messages = [label];
        formatMessage(messages, _classPrivateFieldGet(this, _context));
        if (this.getLevel().allows(Dumper.TIME)) return out.timeLog.call(this, messages.join(' - '));
    }

    /**
     * count
     *
     * @static
     * @param  {string} [label=default]
     */
    static count(label = 'default') {
        let messages = [label];
        formatMessage(messages, _classPrivateFieldGet(this, _context));
        if (this.getLevel().allows(Dumper.TIME)) return out.count.call(this, messages.join(' - '));
    }

    /**
     * countReset
     *
     * @static
     * @param  {string} [label=default]
     */
    static countReset(label = 'default') {
        let messages = [label];
        formatMessage(messages, _classPrivateFieldGet(this, _context));
        if (this.getLevel().allows(Dumper.TIME)) return out.countReset.call(this, messages.join(' - '));
    }

    /**
     * Assert Time logging option
     *
     * @type {boolean} Assert Time enabled
     */
    get optionAssertTime() {
        return this.options.assert.time;
    }

    set optionAssertTime(assertTime) {
        assertTime = new Boolean(assertTime);
        this.options.assert.time = assertTime.valueOf();
        return this;
    }

    /**
     * Assert Limit option: ms between assert calls
     *
     * @type {number} Assert Limit: ms between assert calls
     */
    get optionAssertLimit() {
        return this.options.assert.limit;
    }

    set optionAssertLimit(assertLimit) {
        assertLimit = assertLimit * 1;
        this.options.assert.limit = assertLimit.toString() == 'NaN' ? 0 : assertLimit;
        return this;
    }

    /**
     * Update level from chained changes
     *
     * @type {boolean} Update level if chained change
     */
    get optionUpdatechain() {
        return this.options.updatechain;
    }

    set optionUpdatechain(update) {
        update = new Boolean(update);
        this.options.updatechain = update.valueOf();
        return this;
    }
}

let ExportDumper = Dumper;

if (typeof window.Dumper == 'undefined') {
    window.Dumper = ExportDumper;
    ExportDumper.dump('DUMPER:', 'set');
} else if (ExportDumper !== window.Dumper) {
    ExportDumper = window.Dumper;
    ExportDumper.dump('DUMPER:', 'current');
} else {
    ExportDumper.dump('DUMPER:', 'match');
}

export default ExportDumper;
