/**
 * Users Classes
 */
import { Dumper } from '/js/inane/dumper.mjs';

const dumper = Dumper.get('API');

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
    modelName: 'User',
    get collectionName() {
        return this.modelName + 's';
    },
    get url() {
        // return '/api/' + this.collectionName.toLowerCase();
        return '/api/' + this.modelName.toLowerCase();
    },
    logLevel: {
        model: dumper.level,
        collection: dumper.level,
    },
};

/**
 * User Entity
 */
class User extends Backbone.Model {

    preinitialize() {
        this.logger = dumper.get(config.modelName, { level: config.logLevel.model });

        this.name = config.modelName;
        this.idAttribute = config.idAttribute;
        this.urlRoot = config.url;

        this.defaults = {
            id: null,
        };

        this.on('add', (model, collection, changes) => {
            this.logger.debug(`Add model event got fired!`, model.attributes);
        });
    }

    parse(response) {
        this.logger.trace(response);
        return response.hasOwnProperty('payload') ? response.payload : response;
    }
}

/**
 * Users Collection
 */
class Users extends Backbone.Collection {
    preinitialize() {
        this.logger = dumper.get(config.collectionName, { level: config.logLevel.collection });

        this.name = config.collectionName;
        this.url = config.url;

        this.sortAttribute = User.prototype.idAttribute;

        this.model = User;
        this.options = {};

        this.on('add', (model, collection, changes) => {
            this.logger.debug(`Add collection event got fired!`, model.attributes);
        });
    }

    comparator(model) {
        return model.get(this.sortAttribute);
    }

    parse(response) {
        let self = this;
        if (response.hasOwnProperty('options')) Object.keys(response.options).map(key => self.options[key] = response.options[key]);

        return response.payload || response;
    }

    fetch(options) {
        if (options === undefined) options = { data: this.options };
        else if (options.data === undefined) options.data = this.options;
        else options = Object.assign({ data: this.options }, options);

        return Backbone.Collection.prototype.fetch.call(this, options);
    }
}

export { User, Users };
