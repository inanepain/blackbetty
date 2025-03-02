import { Dumper } from './dumper.mjs';

// Let's create out main Dumper
const logger = Dumper.get('App', {
    level: 'debug'
});

logger.log('My Level:', logger.level);

logger.log('');

// And some children and adjust their level by chaining commands.
logger.get('AreaA').log('Level', logger.get('AreaA').level);
logger.get('AreaB', {
    level: 'info'
}).log('Level', logger.get('AreaB').level);
logger.get('AreaC').setLevel('warn').log('Level', logger.get('AreaC').level);

// But this one we tell not to listen for level changes
logger.get('AreaD').optionUpdateChain = false;

// Lets set the parent level
logger.setLevel('error');

logger.log('');

// All the childeren have taken the new level
logger.get('AreaA').log('Level', logger.get('AreaA').level);
logger.get('AreaB').log('Level', logger.get('AreaB').level);
logger.get('AreaC').log('Level', logger.get('AreaC').level);

// Almost all
logger.get('AreaD').log('Level', logger.get('AreaD').level);

logger.log('');

logger.log('My Children', Object.keys(logger.children()));
