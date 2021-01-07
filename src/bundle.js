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
import './Basic/block/block';
import './Basic/logo/logo';
import './Basic/favicon/favicon';
import './Source/get-user-info/get-user-info';
import './Basic/table/table';
