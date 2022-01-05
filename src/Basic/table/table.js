$(document).ready(() => {
   const pref = '.table'; // prefix for current folder
   const updateLink = document.querySelector('table').dataset.updateLink;
   const parentId = document.querySelector('table').dataset.parentId;
   
   window.isTableOrdering = false;
   window.tableTrsRect = [];
   when(`pointerdown: ${pref} order`, e => {
      let trs = [e.currentTarget.parentElement];

      const $selection = $(`${pref} .tr_selected`);
      if ($selection.length > 0) {
         trs = $selection.toArray();
      }
      
      for (let tr of trs) {
         tr.classList.add(`${pref}__tr_ordering`.slice(1));
      }

      const trsRect = $(`${pref} tbody tr`).toArray().filter(el => !trs.includes(el)).map(tr => {
         const rect = tr.getBoundingClientRect();
         rect.middle = {
            x: (rect.left + rect.right) / 2,
            y: (rect.top + rect.bottom) / 2,
         };
         return {tr, rect};
      });

      window.tableTrsRect = trsRect;
      window.isTableOrdering = trs;
   });
   
   when('pointer: window', async (etype, e) => {
      if (isTableOrdering) {
         if (etype == 'up') {
            const $tr = $(window.isTableOrdering);

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

            $tr.removeClass(`${pref}__tr_ordering`.slice(1));
            window.isTableOrdering = false;

            const order = $(`${pref} tbody tr`).toArray().map(el => el.dataset.itemId).join(',');
            console.log('order:', order);
            
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
            $(`${pref}__tr_possible-place-before`).removeClass(`${pref}__tr_possible-place-before`.slice(1));
            $(`${pref}__tr_possible-place-after`).removeClass(`${pref}__tr_possible-place-after`.slice(1));
            
            for (let {tr: el, rect} of window.tableTrsRect) {
               if (e.clientY < rect.middle.y) {
                  el.classList.add(`${pref}__tr_possible-place-before`.slice(1));
                  return;
               }
            }
            window.tableTrsRect[window.tableTrsRect.length - 1].tr.classList.add(`${pref}__tr_possible-place-after`.slice(1));
         }
      }
   })
   
   when('rowHandle: ')
});