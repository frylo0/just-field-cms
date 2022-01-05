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

         // if body is not form data but object literal
         if (!(fetchOptions.body instanceof FormData) && (Object.prototype.toString.call(fetchOptions.body) === '[object Object]')) {
            const formData = new FormData();
            for (let prop in fetchOptions.body) {
               formData.append(prop, fetchOptions.body[prop]);
            }
            fetchOptions.body = formData;
         }
         resFetch = await fetch(fetchUrl, fetchOptions);
         res = await resFetch.clone().json();
      } catch (err) {
         $statusbar.dotAnimation.stop('Error');
         console.error('On fetchJsonOk: ' + fetchUrl);
         console.error(err.message);

         let $wrapper = $(`
            <div class="fetch-json-error col">
               <div class="row jcsb aic" style="box-shadow: 0px 3px 42px -20px #000;">
                  <div style="font-size: 1.25em; margin-left: 1rem;">Fetch JSON Error</div>
                  <div 
                     class="editor-tabs__close-button box p1 box_mode_light"
                     onclick="action('click: fetchJsonOk error close button')(this)"
                  >
                     <img src="../__attach/Images/close.png"
                          style="height: 1em; width: 1em" />
                  </div>
               </div>
            </div>
         `)
            .css({
               position: 'absolute',
               left: '0',
               right: '0',
               top: '0',
               bottom: '0',
               zIndex: '10000',
               background: '#ffffffaa',
               backdropFilter: 'blur(10px)',
               overflow: 'auto',
               color: 'black',
            });
         
         when('click: fetchJsonOk error close button', el => {
            $(el).parents('.fetch-json-error').remove();
         });
            
         let pre = document.createElement('pre');
         pre.innerHTML = await resFetch.text();
         pre.className = 'php-error';
         pre.style = 'padding: 1em;';
         document.querySelectorAll('.php-error').forEach(el => el.remove());

         $(pre).appendTo($wrapper);
         $wrapper.appendTo(document.body);

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