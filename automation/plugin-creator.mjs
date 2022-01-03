/**
 * PLUGIN CREATOR, 12.12.2021, frity crop.
 * This script creates plugin files and help to generate manifest
 * Script don't get any params, to run, just call script with node from any pwd
 * Also script functions can be used by other scripts, so before main() call, there is check for this case
 */


import readline from './readline.mjs';
import fs from 'fs';
import path from 'path';

// Function for correct object merge. Recursively copy all props.
Object.merge = function (obj1, obj2) {
   for (var p in obj2) {
      try {
         // Property in destination object set; update its value.
         if (obj2[p].constructor == Object)
            obj1[p] = Object.merge(obj1[p], obj2[p]);
         else
            obj1[p] = obj2[p];
      } catch (e) {
         // Property in destination object not set; create it and set its value.
         obj1[p] = obj2[p];
      }
   }

   return obj1;
};


export const config = {
   pathBase: './../php/plugins/',
   output: '.',
};

// manifest file template
const manifest = {
   icon: "", // -------------- plugin icon
   description: "", // ------- plugin description
   version: '1.0.0', // ------ plugin version
   author: 'frity corp.', // - plugin author
   priority: 0, // ----------- plugin load priority
   enabled: true, // --------- plugin enabled toggle
   tags: ["built-in"], // ---- plugin tags for plugin store
   depends_on: [], // -------- plugins which this plugin depends on
   php: { // ----------------- php settings
      url_match: [], // ---------- urls on which plugin php part works
   },
   js: { // ------------------ js settings
      url_match: [], // ---------- urls on which plugin js part works
   },
   css: { // ----------------- css settings
      url_match: [], // ---------- urls on which plugin css part works
   },
   settings: { }, // --------- inner plugin settings
   readme: './_readme.md', // --- plugin tutorials and so on
};

// entry point
async function main() {
   console.log('Plugin creator for Just Field CMS'); // output script description
   const pluginName = await readline('Name: '); // input plugin name, in future plugin folder name

   // input description or use default value if free
   manifest.description = await readline('Description: ') || manifest.description;

   // input author or use default value if free
   manifest.author = await readline('Author: ') || manifest.author;
   // input version or use default value if free
   manifest.version = await readline('Version: ') || manifest.version;
   // input output path relative to config.pathBase, if free use default output path
   const outputPath = config.pathBase + (await readline('! Output: ') || config.output);

   console.log(manifest); // output generated manifest
   const pluginFolder = path.resolve(outputPath, pluginName); // generate path to plugin folder

   // check if plugin folder already exist
   const exists = fs.existsSync(pluginFolder);
   let writeMode = false;
   // if exists then need to choose what to do
   if (exists) {
      // o - fully overwrite all folder
      // m - update only manifest
      // c - cancel - do nothing
      let answer = await readline('Plugin folder EXISTS. Overwrite, update Manifest or Cancel? (o/m/c): ');
      if (answer != 'o' || answer != 'm') writeMode = false; // "c" means writeMode = false
      writeMode = answer == 'o' ? 'write' : 'update';
   } else { // if folder do not exist
      let answer = await readline('Write? (y/n): '); // ask to start write process
      writeMode = answer == 'y' ? 'write' : false;
   }

   if (writeMode) { // if write mode, means to write or to update
      if (writeMode == 'write') { // if write mode is "write" means to renew all files and folder totally
         // recreate plugin folder
         fs.rmdirSync(pluginFolder, { recursive: true }); // removing folder
         fs.mkdirSync(pluginFolder); // create free folder

         renewPluginFiles(pluginName); // creating manifest and all files in folder
      }
      else if (writeMode == 'update') {
         updateManifest(pluginName); // update only manifest file
         renewPluginFiles(pluginName); // don't modify existing files, only add new one
      }
      else return;
   } else {
      console.log('Nothing to be written.');
   }
}

// update only manifest file of plugin
export async function updateManifest(pluginName) {
   const { pluginFolder } = getPluginPaths(pluginName); // get plugin folder full path

   // get manifest content
   const oldManifestPath = path.resolve(pluginFolder, 'manifest.json');
   const oldManifest = JSON.parse(fs.readFileSync(oldManifestPath));

   // merge overwrite default values by values from oldManifest
   Object.merge(manifest, oldManifest);
   // write updated content to file
   fs.writeFileSync(oldManifestPath, JSON.stringify(manifest, 0, 3));
}

// creates all files in FREE plugin folder
export async function renewPluginFiles(pluginName) {
   // get full folder path
   const { pluginFolder } = getPluginPaths(pluginName);

   // file name: file content
   const files = {
      'manifest.json': JSON.stringify(manifest, 0, 3), // modified by input global manifest object
      '__load.php': '',
      '__load.js': '',
      '__load.css': '',
      '_inst.php': '',
      '_uninst.php': '',
      '_readme.md': '',
   };

   // for each file in creating list, if not exist, then create and write content
   for (const file in files) {
      const filePath = path.resolve(pluginFolder, file);
      if (!fs.existsSync(filePath))
         fs.writeFileSync(filePath, files[file]);
   }
}

// generate plugin full path by name
function getPluginPaths(pluginName) {
   const outputPath = config.pathBase + config.output;
   const pluginFolder = path.resolve(outputPath, pluginName);

   return {
      outputPath, pluginFolder
   };
}

import { fileURLToPath } from 'url';
import process from 'process';

// if this script was run directly, but not from other script
if (process.argv[1] === fileURLToPath(import.meta.url)) {
   // the script was run directly.
   main().then(() => process.exit()); // run main function then exit
}
// else if run from other script, then other script can reach main() function from this file and other things