$(document).ready(() => {
   const pref = '.table'; // prefix for current folder
   const updateLink = document.querySelector('table').dataset.updateLink;
   const parentId = document.querySelector('table').dataset.parentId;
   
   $(`${pref}__order`).on('pointerdown', action('pointerdown: table order'));

   window.isTableOrdering = false;
   window.tableTrsRect = [];
   when('pointerdown: table order', e => {
      /** @type {HTMLElement} */
      const tr = e.currentTarget.parentElement;
      const trRect = tr.getBoundingClientRect();
      
      tr.classList.add('table__tr_ordering');

      const trsRect = $(`${pref} tbody tr`).toArray().filter(el => el != tr).map(tr => {
         const rect = tr.getBoundingClientRect();
         rect.middle = {
            x: (rect.left + rect.right) / 2,
            y: (rect.top + rect.bottom) / 2,
         };
         return {tr, rect};
      });
      window.tableTrsRect = trsRect;
      window.isTableOrdering = [tr];
   });
   
   when('pointer: window', async (etype, e) => {
      if (isTableOrdering) {
         for (let tr of window.isTableOrdering) {

            if (etype == 'up') {
               const $tr = $(tr);

               const $placeBefore = $(`${pref}__tr_possible-place-before`);
               const $placeAfter = $(`${pref}__tr_possible-place-after`);

               if ($placeBefore.length > 0) {
                  $tr.insertBefore($placeBefore);
                  $placeBefore.removeClass(`${pref}__tr_possible-place-before`.slice(1));
               }
               else if ($placeAfter.length > 0) {
                  $tr.insertAfter($placeAfter);
                  $placeAfter.removeClass(`${pref}__tr_possible-place-after`.slice(1));
               }
               else {
                  console.warn('table.js: after tr move no possible place found.', tr);
               }

               tr.classList.remove('table__tr_ordering');
               window.isTableOrdering = false;

               const order = $(`${pref} tbody tr`).toArray().map(el => el.dataset.itemId).join(',');
               console.log(order);
               
               let res = await fetchJsonOk('Ordering', updateLink, {
                  method: 'POST',
                  body: {
                     item_id: parentId,
                     colname: 'value',
                     value: order,
                  },
               });
            } 

            else if (etype == 'move') {
               $('.table__tr_possible-place-before').removeClass('table__tr_possible-place-before');
               $('.table__tr_possible-place-after').removeClass('table__tr_possible-place-after');
               
               for (let {tr: el, rect} of window.tableTrsRect) {
                  if (e.clientY < rect.middle.y) {
                     el.classList.add('table__tr_possible-place-before');
                     return;
                  }
               }
               window.tableTrsRect[window.tableTrsRect.length - 1].tr.classList.add('table__tr_possible-place-after');
            }

         }
      }
   })
});