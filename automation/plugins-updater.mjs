/**
 * PLUGINS UPDATER, 12.12.2021, frity crop.
 * This plugin update all plugins in basic plugin folder (to check path of it open plugin-creator.mjs script).
 * After script work, all plugins manifest files receive new props, old props won't be changed.
 * Also new files could be added, but old files untouchable.
 */

// Load basic functionality from plugin-creator.mjs script
// Config object has info about basic plugin folder
// Update manifest function update only manifest file of single script
// Renew plugin files by adding new files in plugin folder old files untouchable.
import { config, updateManifest, renewPluginFiles } from './plugin-creator.mjs';
import fs from 'fs';
import path from 'path';

async function main() {
   // get all plugins directories
   const pluginsDirPath = path.resolve(config.pathBase, config.output);
   const pluginsDir = fs.readdirSync(pluginsDirPath);
   // iterate through them
   for (const item of pluginsDir) { // each plugin directory
      console.log('Processing:', item);
      // get plugin info (there are loaders and other files, so we need just folders)
      const stat = fs.statSync(path.resolve(pluginsDirPath, item));
      // if current item is folder
      if (stat.isDirectory()) {
         updateManifest(item); // updating only manifest file, by adding new props, old props untouchable
         renewPluginFiles(item); // updating other files, by adding new, old untouchable
      }
   }
}

// run main function then stop program
main().then(() => process.exit());
