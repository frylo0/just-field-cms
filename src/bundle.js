const importer = require('../env/webpack.importer');

const imported = importer([
  require.context('./Logic/', true, /\.js$/),
  require.context('./Attach/', true, /\./),
]);

import './Basic/devicer/devicer';
import './Basic/input/input';
import './Basic/button/button';
import './Basic/link/link';
import './Basic/aside/aside';
import './Basic/dropdown/dropdown';
import './Basic/arrow/arrow';
import './Source/die-if-bad/die-if-bad';
