import Dumper from './inane/dumper.js';

const dumper = Dumper.get('Develop');

// dumper.time('main');

dumper.log(dumper.getLevel());
dumper.setLevel('TRACE');
dumper.time('main');
dumper.log(dumper.getLevel());
dumper.setLevel(2);
dumper.log(dumper.getLevel());


dumper.trace('trace');
dumper.dump('dump');
dumper.debug('debug');
dumper.info('info');
dumper.warn('Warn');
dumper.error('error');
dumper.log('log');

dumper.timeEnd('main');

window.dumper = dumper;

