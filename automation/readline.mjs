import readlineApi from "readline";
const readlineInterface = readlineApi.createInterface(process.stdin, process.stdout);

export default async function readline(question) {
   return new Promise((res, rej) => readlineInterface.question(question, res));
}