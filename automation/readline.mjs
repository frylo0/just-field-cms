/**
 * READLINE, 12.12.2021, frity corp.
 * Only readline interface, used by other scripts
 */

import readlineApi from "readline";
const readlineInterface = readlineApi.createInterface(process.stdin, process.stdout);

export default async function readline(question) {
   return new Promise((res, rej) => readlineInterface.question(question, res));
}