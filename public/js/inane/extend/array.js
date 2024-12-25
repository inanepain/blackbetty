/**
 * Array Enhancements
 * @author Philip Michael Raab<philip@inane.co.za>
 * @version 1.1.0
 */

/**
 * Adds getWeekNumber to date objects
 * The ISO-8601 week of year number if the date
 * 
 * @return int 
 */
if (!Array.prototype.unique) {
    Array.prototype.unique = function () {
        var unique = [];
        for (var i = 0; i < this.length; i++) if (!unique.includes(this[i])) unique.push(this[i]);
        return unique;
    };
}

/**
 * Search items for key ?and value and returns matches
 * 
 * @return Array 
 */
if (!Array.prototype.searchObject) {
    Array.prototype.searchObject = function (nameKey, keyValue) {
        return this.filter(item => item.hasOwnProperty(nameKey) && (keyValue == undefined) && true || (item[nameKey] == keyValue));
    };
}

/**
 * Returns object grouped by property
 * 
 * @return Object 
 */
if (!Array.prototype.groupBy) {
    Array.prototype.groupBy = function (key) {
        return this.reduce((rv, x) => {
            (rv[x[key]] = rv[x[key]] || []).push(x);
            return rv;
        }, {});
    };
}

/**
 * Logs Debug output
 */
if (!Array.prototype.log) {
    Array.prototype.log = function () {
        console.log(JSON.stringify(this));
    };
}
