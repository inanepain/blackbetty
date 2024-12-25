import Dumper from './dumper.min.js';

Dumper.dump('MODULE', 'config', 'Load');
/**
 * Common settings & configurations
 * 
 * Does what ever setting up, configurring, instanciation that I commonly do in one place.
 */
// CONFIGURATION SETTIND
const Options = {
    Backbone: {
        Radio: {
            ChannelName: 'Inane',
            TestEvent: 'inane:test',
        },
    },
    ICRoot: {
        ChannelProperty: 'iChannel',
    },
};

// internal references
const dumper = Dumper.get?.('Config') || console;
const icroot = _icroot || {};

/**
* Backbone & Marionette
* Create a Marionette property of the Backbone object.
*/
if (Backbone) {
    if (Marionette && !Backbone.Marionette) Backbone.Marionette = Marionette;

    if (Backbone.Radio) Object.defineProperty(icroot, Options.ICRoot.ChannelProperty, {
        enumerable: false,
        configurable: false,
        writable: false,
        value: Backbone.Radio.channel(Options.Backbone.Radio.ChannelName)
    });

    if (icroot[Options.ICRoot.ChannelProperty]) icroot[Options.ICRoot.ChannelProperty].on(Options.Backbone.Radio.TestEvent, function () {
        dumper.log(`Radio channel: '${this.channelName}' test event '${Options.Backbone.Radio.TestEvent}' with arguments:`, arguments);
    });
}
