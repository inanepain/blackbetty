import { Users } from "./user.mjs";

const users = new Users();
users.fetch();
window.users = users;
// users.fetch().then(() => {
//     dumper.debug(users);
// });


const Basics = Marionette.Behavior.extend({
    options: {
        logger: null,
        channel: null,
    },

    // channelName: 'develop',
    // initialize(options) {
    //     // this.mergeOptions(options, ['logger']);
    //     dumper.debug('Behavior', 'initialize', options);
    // },
    // onRender() {
    //     this.logger.debug('onRender');
    // },
    onAttach() {
        this.logger.debug('onAttach');
    },
    onBeforeDestroy() {
        this.logger.debug('onBeforeDestroy');
    },
    onDestroy() {
        this.logger.debug('onDestroy');
    },
});

const PageDevelop = Marionette.View.extend({
    // id: 'page',
    el: '#page',
    // channelName: 'develop', njuhnm,

    behaviors: [Basics],

    ui: {
        button: 'button#btn-1'
    },

    events: {
        'click #btn-1': 'logSomething',
    },

    initialize(options) {
        this.mergeOptions(options, ['logger', 'channel']);
        this.logger.trace('initialize', options);

        this.listenTo(this.channel, 'left:building', this.leftBuilding);
        this.channel.reply('view:name', this.getViewName);
    },
    getViewName() {
        return 'PageDevelop';
    },
    leftBuilding(person) {
        this.logger.debug(' has left the building!');
    },
    logSomething() {
        this.logger.debug('Something');
    },
    template: _.template(`
        <h1>Develop</h1>
        <p>Develop view</p>
        <button id="btn-1">Log Something</button>
    `),
});

const page = new PageDevelop({
    logger: app.logger.get('PageDevelop', {level:1}),
    channel: app.getChannel(),
});
app.showView(page);

window.page = page;