((factory) => {
	/**
	 * Automatic Startup (AS)
	 */
	//console.log('AS:factory:line:', new Error().stack.split(':')[1], ':factory:', factory);

	if (typeof DBLayer !== 'undefined') {
		console.warn('DBLayer already installed!');
		return;
	}

	window.DBLayer = factory(console);
})(() => {
	/**
	 * Factory Function (FF)
	 */
	//console.log('FF:line:', new Error().stack.split(':')[1], ':');

	/**
	 * DBLayer: A single access point for your data
	 * @class DBLayer
	 * 
	 * let dblayer = new DBLayer()
	 */
	class DBLayer {
		constructor(options) {
			'use strict';
			_.extend(this, Backbone.Events);
			const staticDBLayer = this.constructor;

			const _version = '0.1.0';

			Object.defineProperty(this, 'VERSION', {
				enumerable: true,
				configurable: false,
				writable: false,
				value: _version
			});

			Object.defineProperty(staticDBLayer, 'VERSION', {
				enumerable: true,
				configurable: false,
				writable: false,
				value: _version
			});

			dcforms.logger.debug(staticDBLayer.name + ' v' + this.VERSION);

			this.collection = new Set();
			this.intervalID = undefined;
			this.options = _(options).defaults(staticDBLayer.defaultOptions);

			staticDBLayer._dblayer = this;
		}

		static get() {
			if (!this._dblayer) {
				this._dblayer = new this();
			}
			return this._dblayer;
		}

		static get defaultOptions() {
			return {
				interval: 10000
			};
		}

		isType(obj, type) {
			const validTypes = ['Arguments', 'Function', 'String', 'Number', 'Date', 'RegExp', 'Error', 'Map', 'WeakMap', 'Set', 'WeakSet'];
			if (!validTypes.includes(type)) return false;

			return Object.prototype.toString.call(obj) === '[object ' + type + ']';
		}

		get active() {
			return typeof this.intervalID == 'undefined' ? false : true;
		}

		get interval() {
			return this.options.interval;
		}

		set interval(delay) {
			this.options.interval = this.isNumber(delay) ? delay : this.options.interval;
		}

		/**
		 * Adds items for syncing
		 * 
		 * @param {*} fetchable 
		 */
		addFetchable(fetchable = {}) {
			// Item must:
			// * have a fetch function
			// * Not be in the collection already
			if (this.isType(fetchable.fetch, 'Function')) {
				this.collection.add(fetchable);
			}
			return this;
		}

		/**
		 * Removes item from sync collection
		 * 
		 * @param {*} fetchable 
		 */
		removeFetchable(fetchable) {
			this.collection.delete(fetchable);
			return this;
		}

		start() {
			if (typeof this.intervalID == 'undefined') {
				this.intervalID = setInterval(() => {
					for (let item of DBLayer.get().collection) item.fetch();
				}, this.interval);
			}
			return this.intervalID;
		}

		stop() {
			this.intervalID = clearInterval(this.intervalID);
			return this.intervalID;
		}
	}

	return DBLayer;
});