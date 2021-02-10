import { config, updateManifest, renewPluginFiles } from './plugin-creator.mjs';
import fs from 'fs';
import path from 'path';

async function main() {
   const pluginsDirPath = path.resolve(config.pathBase, config.output);
   const pluginsDir = fs.readdirSync(pluginsDirPath);
   for (const item of pluginsDir) {
      console.log('Processing:', item);
      const stat = fs.statSync(path.resolve(pluginsDirPath, item));
      if (stat.isDirectory()) {
         updateManifest(item);
         renewPluginFiles(item);
      }
   }
}

main().then(() => process.exit());
