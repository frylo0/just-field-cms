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
import './Basic/box/box';
import './Basic/logo/logo';
import './Basic/favicon/favicon';
import './Source/get-user-info/get-user-info';
import './Basic/table/table';
import './Blocks/item_T_field/item_T_field';
import './Blocks/item_T_object/item_T_object';
import './Blocks/item_T_list/item_T_list';
import './Blocks/item_T_image/item_T_image';
import './Basic/popup/popup';
import './Blocks/item_T_space/item_T_space';
import './Blocks/item_T_text/item_T_text';
