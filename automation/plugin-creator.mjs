import readline from './readline.mjs';
import fs from 'fs';
import path from 'path';

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

const manifest = {
   description: "",
   version: '1.0.0',
   author: 'frity corp.',
   priority: 0,
   enabled: true,
   tags: ["built-in"],
   depends_on: [],
   php: {
      url_match: [],
   },
   js: {
      url_match: [],
   },
   css: {
      url_match: [],
   },
};

async function main() {
   console.log('Plugin creator for Just Field CMS');
   const pluginName = await readline('Name: ');
   // description
   // plugin. = await readline(': ');
   manifest.description = await readline('Description: ') || manifest.description;

   manifest.author = await readline('Author: ') || manifest.author;
   manifest.version = await readline('Version: ') || manifest.version;
   const outputPath = config.pathBase + (await readline('! Output: ') || config.output);

   console.log(manifest);
   const pluginFolder = path.resolve(outputPath, pluginName);

   const exists = fs.existsSync(pluginFolder);
   let writeMode = false;
   if (exists) {
      let answer = await readline('Plugin folder EXISTS. Overwrite, update Manifest or Cancel? (o/m/c): ');
      if (answer != 'o' || answer != 'm') writeMode = false;
      writeMode = answer == 'o' ? 'write' : 'update';
   } else {
      let answer = await readline('Write? (y/n): ');
      writeMode = answer == 'y' ? 'write' : false;
   }

   if (writeMode) {
      if (writeMode == 'write') {
         // recreate plugin folder
         fs.rmdirSync(pluginFolder, { recursive: true });
         fs.mkdirSync(pluginFolder);

         renewPluginFiles(pluginName);
      }
      else if (writeMode == 'update') {
         updateManifest(pluginName);
         renewPluginFiles(pluginName);
      }
      else return;
   } else {
      console.log('Nothing to be written.');
   }
}

export async function updateManifest(pluginName) {
   const { pluginFolder } = getPluginPaths(pluginName);

   const oldManifestPath = path.resolve(pluginFolder, 'manifest.json');
   const oldManifest = JSON.parse(fs.readFileSync(oldManifestPath));

   Object.merge(manifest, oldManifest);
   fs.writeFileSync(oldManifestPath, JSON.stringify(manifest, 0, 3));
}

export async function renewPluginFiles(pluginName) {
   const { pluginFolder } = getPluginPaths(pluginName);

   const files = {
      'manifest.json': JSON.stringify(manifest, 0, 3),
      '__load.php': '',
      '__load.js': '',
      '__load.css': '',
      '_inst.php': '',
      '_uninst.php': '',
   };

   for (const file in files) {
      const filePath = path.resolve(pluginFolder, file);
      if (!fs.existsSync(filePath))
         fs.writeFileSync(filePath, files[file]);
   }
}

function getPluginPaths(pluginName) {
   const outputPath = config.pathBase + config.output;
   const pluginFolder = path.resolve(outputPath, pluginName);

   return {
      outputPath, pluginFolder
   };
}

import { fileURLToPath } from 'url';
import process from 'process';

if (process.argv[1] === fileURLToPath(import.meta.url)) {
   // The script was run directly.
   main().then(() => process.exit());
}