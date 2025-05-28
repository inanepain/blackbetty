const Workspace = Backbone.Router.extend({
    routes: {
        "help": "help",    // #help
        "search/:query": "search",  // #search/kiwis
        "search/:query/p:page": "search",   // #search/kiwis/p7
        "folder/:name":       "openFolder", // #folder/documents
    },

    help: function() {
        logRoute.debug('help');
    },

    search: function(query, page) {
        logRoute.debug('search', 'query:', query, 'page:', page);
    },

    openFolder: function(name) {
        logRoute.debug('openFolder', 'name:', name);
    },
});

const PageTemperature = Marionette.View.extend({
    // el: '#page',
    el: document.querySelector('#page'),

    ui: {
        kelvin: 'input#kelvin',
        celsius: 'input#celsius',
        fahrenheit: 'input#fahrenheit',
    },

    events: {
        'keyup input': 'update',
        'click input': 'update',
    },

    initialize(options) {
        this.mergeOptions(options, ['logger', 'channel']);
        this.logger.trace('initialize', options);

        this.tc = TemperatureThing.fromCelsius(0);
        this.model = new Backbone.Model({
            kelvin: this.tc.kelvin,
            celsius: this.tc.celsius,
            fahrenheit: this.tc.fahrenheit,
            zeroKelvin: this.tc.ZERO_KELVIN,
            zeroCelsius: this.tc.ZERO_CELSIUS,
            zeroFahrenheit: this.tc.ZERO_FAHRENHEIT,
        });

        // this.listenTo(this.channel, 'left:building', this.leftBuilding);
        // this.channel.reply('view:name', this.getViewName);
    },
    getViewName() {
        return 'Temperature';
    },
    update(event) {
        this.logger.debug('Event:', event);

        this.tc[event.target.name] = Number.parseFloat(event.target.value || 0);
        this.logger.debug('Temperature Thing:', this.tc);

        this.ui.kelvin[0].value = this.tc.kelvin;
        this.ui.celsius[0].value = this.tc.celsius;
        this.ui.fahrenheit[0].value = this.tc.fahrenheit;
    },
    template: _.template(`
        <form class="form">
            <div class="row">
                <label for="kelvin" class="label">Kelvin</label>
                <input id="kelvin" name="kelvin" type="number" class="control" min="<%- zeroKelvin %>" value="<%- kelvin %>">
            </div>
            <div class="row">
                <label for="celsius" class="label">Celsius</label>
                <input id="celsius" name="celsius" type="number" class="control" min="<%- zeroCelsius %>" value="<%- celsius %>">
            </div>
            <div class="row">
                <label for="fahrenheit" class="label">Fahrenheit</label>
                <input id="fahrenheit" name="fahrenheit" type="number" class="control" min="<%- zeroFahrenheit %>" value="<%- fahrenheit %>">
            </div>
        </form>
    `),
});

const page = new PageTemperature({
    logger: app.logger.get('Temperature', {level: 'INFO'}),
    channel: app.getChannel(),
});

// Backbone.history.navigate('folder/down', {trigger: true, replace: true})
new Workspace();
const logRoute = app.logger.get('Router', {level: 'DEBUG'});

app.showView(page);
