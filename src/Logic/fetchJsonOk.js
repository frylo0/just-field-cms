/**
 * 
 * @param {String} startMessage 
 * @param {RequestInfo} fetchUrl 
 * @param {RequestInit} fetchOptions 
 */
async function fetchJsonOk(startMessage, fetchUrl, fetchOptions = {}) {
   if (!window.$statusbar) {
      console.warn('No window.$statusbar found for fieldJsonOk.js');
      return;
   }

   return new Promise(async (resolve, reject) => {
      $statusbar.dotAnimation.start(startMessage);
      let res, resFetch;
      try {
         //window.open(fetchUrl, '_blank');
         //return;
         resFetch = await fetch(fetchUrl, fetchOptions);
         res = await resFetch.clone().json();
      } catch (err) {
         $statusbar.dotAnimation.stop('Error');
         console.error('On fetchJsonOk: ' + fetchUrl);
         console.error(err.message);

         let pre = document.createElement('pre');
         pre.innerHTML = await resFetch.text();
         pre.style = 'border: 1px solid red; background: #fff; padding: 1em; color: #000;';
         pre.className = 'php-error';
         document.querySelectorAll('.php-error').forEach(el => el.remove());
         document.body.append(pre);

         reject(err);
      }

      $statusbar.dotAnimation.stop('Ready');
      if (res.status == 'OK') {
         console.log(startMessage + ' OK');
         resolve(res);
      }
      else {
         let message = `When ${startMessage} item at URL: ${fetchUrl}`;
         console.error(message);
         reject(new Error(message));
      }
   });
}

window.fetchJsonOk = fetchJsonOk;