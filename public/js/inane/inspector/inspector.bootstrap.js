/*
 * The Inspector Bootstrap Script is guaranteed to be the first script evaluated in any page, as well as any sub-frames.
 * It is evaluated immediately after the global object is created, before any other content has loaded.
 * 
 * Modifications made here will take effect on the next load of any page or sub-frame.
 * The contents and enabled state will be preserved across Web Inspector sessions.
 * 
 * Some examples of ways to use this script include (but are not limited to):
 *  - overriding built-in functions to log call traces or add `debugger` statements
 *  - ensuring that common debugging functions are available on every page via the Console
 * 
 * More information is available at <https://webkit.org/web-inspector/inspector-bootstrap-script/>.
 */
((root, _log, level) => {
    const id = `za.co.inane.inspector.bootstrap`;
    /**
     * @var {number} VERSION interceptor bootstrap version
     */
    const VERSION = 8;
    const loglevel = level.TRACE;
    const enableAugmentation = true;

    const msgThemes = {
        system: [`LavenderBlush`, `Crimson`],
        first: [`red`, `cornflowerblue`],
        second: [`Red`, `AliceBlue`],
        third: [`MediumPurple`, `AliceBlue`],
    };

    /**
     * Prototype enhancements
     */
    function augmentPrototypes() {
        /**
         * Add iqs to HTMLElement prototype
         */
        if (!HTMLElement.prototype.iqs) {
            /**
             * iqs<br />
             * Shorter version of QuerySelector
             * 
             * @param {string} selectors
             */
            HTMLElement.prototype.iqs = function (selectors) {
                if (this && this.querySelector) return this.querySelector(selectors);
                return root.document.querySelector(selectors);
            }
        }

        /**
         * Add iqsa to HTMLElement prototype
         */
        if (!HTMLElement.prototype.iqsa) {
            /**
             * iqsa<br />
             * Shorter version of QuerySelectorAll
             * 
             * @param {string} selectors
             */
            HTMLElement.prototype.iqsa = function (selectors) {
                if (this && this.querySelectorAll) return this.querySelectorAll(selectors);
                return root.document.querySelectorAll(selectors);
            }
        }

        if (!root.iqs) {
            root.iqs = function (selectors) {
                return root.document.querySelector(selectors);
            }
        }

        if (!root.iqsa) {
            root.iqsa = function (selectors) {
                return root.document.querySelectorAll(selectors);
            }
        }

        if (!root.document.iqs) {
            root.document.iqs = function (selectors) {
                return root.document.querySelector(selectors);
            }
        }

        if (!root.document.iqsa) {
            root.document.iqsa = function (selectors) {
                return root.document.querySelectorAll(selectors);
            }
        }
    }

    /**
     * Object with custom actions for host & page combinations
     */
    const customConfig = {
        digitalcabinetlocal: {
            mailboxphp: () => {
                dump(`AUTOMATION`, `Sharehub`, `mailboxphp`);
                iqs(`input[name="email"]`).value = `jse@local`;
                iqs(`input[name="password"]`).value = `password`;
            },
            indexjsephp: () => {
                dump(`AUTOMATION`, `Sharehub`, `indexjsephp`);
            },
        },
        raidlocal8701: {
            default: () => {
                const data = document.querySelector('#primary article .entry-content');
                if (data) {
                    document.body.replaceChildren(data);
                    let videos = headings = document.evaluate("//h2[contains(., ' Videos')]", document, null, XPathResult.ANY_TYPE, null ).iterateNext();
                    if (videos != null) {
                        while (videos?.nextElementSibling?.tagName == 'P') videos.nextElementSibling.remove();
                        videos.remove();
                    }
                }
            },
        },
    };

    /**
     * Uses the location to start any code for current host
     * 
     * @param loc location
     */
    const initialiseAutomation = (loc) => customConfig?.[loc.host.replaceAll(`.`, ``).replaceAll(`:`, ``)]?.[loc.pathname.split(`/`).pop().split(`?`).shift().replace(`.`, ``) || 'default']?.();

    /**
     * Create css for logging output
     * 
     * @param {string} colour text colour
     * @param {string} background background colour
     */
    const createStyle = (colour = `unset`, background = `unset`) => `color: ${colour}; font-weight: 500; background: ${background};padding: 2px; border-radius:5px;`;

    /**
     * Logging method
     * 
     * @param  {...any} msgs log message(s)
     */
    function dump(...msgs) {
        const messageCount = msgs.length;
        let msg1, msg2, msgType = 4;

        if (msgs[0] === id) {
            msgs.shift();
            msgType = 1;
        } else if (typeof msgs[0] == `string` && msgs[0].toUpperCase().startsWith(`MODULE`)) msgType = 2;

        msg1 = `%cDUMP:${VERSION}%c %c${msgs.shift()}`;
        if (messageCount > 1 && typeof msgs[0] == `string`) {
            msg2 = `${msg1}%c %c${msgs.shift()}`;
            msgs.unshift(createStyle(`Blue`, `Azure`));
            msgs.unshift(createStyle());
        }

        if (msgType == 2) msgs.unshift(createStyle.apply(null, msgThemes.third));
        else msgs.unshift(createStyle.apply(null, msgThemes.second));

        msgs.unshift(createStyle());
        if (msgType == 1) msgs.unshift(createStyle.apply(null, msgThemes.system));
        else msgs.unshift(createStyle.apply(null, msgThemes.first));

        if (msg2) msgs.unshift(msg2);
        else msgs.unshift(msg1);

        return _log.log.apply(_log, msgs);
    }

    if (loglevel !== level.OFF) {
        root.debug = true;
        root.logLevel = loglevel;
        root.dump = dump;
        _log.dump = dump;
    }

    /**
     * Augment Prototypes if enabled
     */
    if (enableAugmentation) augmentPrototypes();

    /**
     * Listen for when dom loaded
     */
    root.document.addEventListener(`readystatechange`, event => {
        switch (event.target.readyState) {
            case `loading`:
                dump(`Inspector:Bootstrap:${VERSION}`, `${enableAugmentation ? 'augmented:' : ''}document:state`, `LOADING`);
                break;
            case `interactive`:
                dump(id, `Inspector:Bootstrap:${VERSION}`, `${enableAugmentation ? 'augmented:' : ''}document:state`, `INTERACTIVE`);
                if (enableAugmentation) initialiseAutomation(root.location);
                break;
            case `complete`:
                dump(id, `Inspector:Bootstrap:${VERSION}`, `${enableAugmentation ? 'augmented:' : ''}document:state`, `READY`);
                break;
        }
    }, false);
})(window, console, {
    OFF: `OFF`,
    TRACE: `TRACE`,
    DEBUG: `DEBUG`,
    INFO: `INFO`,
    TIME: `TIME`,
    WARN: `WARN`,
    ERROR: `ERROR`
});
