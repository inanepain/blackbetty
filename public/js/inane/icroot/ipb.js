const _defaults = {

};

class iPb {
    constructor(selector, {source, button} = {}) {
        if (! selector) return console.error('Error: no element given to copy from');

        let options = Object.assign({}, {
            element: selector,
        });
    }
}

export default iPb;
