/**
 * Examples Classes
 */
import { Dumper } from '/js/inane/dumper.js';
Dumper.dump('MODULE', 'Backbone', 'Load');

/**
 * config
 * @typedef {object} config
 * @property {string} modelName - the model name
 * @property {string} collectionName - the collection name
 * @property {string} idAttribute - the id attribute
 * @property {string} url - the url
 */
/**
 * @type {config}
 */
const config = {
    idAttribute: 'id',
    modelName: 'Example',
    get collectionName() {
        return this.modelName + 's';
    },
    get url() {
        return '/api/' + this.collectionName.toLowerCase();
    },
};

/**
 * Example Entity
 */
class Example extends Backbone.Model {

    preinitialize() {
        this.name = config.modelName;
        this.idAttribute = config.idAttribute;
        this.urlRoot = config.url;

        this.defaults = {
            id: null,
        };

        // this.on('add', () => {
        //     console.log(`Add model event got fired!`);
        // });
    }

    parse(response) {
        return response.hasOwnProperty('payload') ? response.payload : response;
    }
}

/**
 * Examples Collection
 */
class Examples extends Backbone.Collection {
    preinitialize() {
        this.name = config.collectionName;
        this.url = config.url;

        this.sortAttribute = Example.prototype.idAttribute;

        this.model = Example;
        this.options = {};

        // this.on('add', () => {
        //     console.log(`Add collection event got fired!`);
        // });
    }

    comparator(model) {
        return model.get(this.sortAttribute);
    }

    parse(response) {
        let self = this;
        if (response.hasOwnProperty('options')) Object.keys(response.options).map(key => self.options[key] = response.options[key]);

        return response.payload;
    }

    fetch(options) {
        if (options === undefined) options = { data: this.options };
        else if (options.data === undefined) options.data = this.options;
        else options = Object.assign({ data: this.options }, options);

        return Backbone.Collection.prototype.fetch.call(this, options);
    }
}

export { Example, Examples };
