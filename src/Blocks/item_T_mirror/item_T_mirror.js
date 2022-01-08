$(document).ready(() => {
   const pref = '.item_T_mirror'; // prefix for current folder
   const updateLink = document.querySelector('table').dataset.updateLink;
   const valueRenderLink = document.querySelector('table').dataset.valueRenderLink;
   const $table = $('.table');
   
   const caretPos = {
      get(input) {
         return input.selectionStart;
      },
      set(input, caretPos) {
         var elem = input;

         if (elem != null) {
            if (elem.createTextRange) {
               var range = elem.createTextRange();
               range.move('character', caretPos);
               range.select();
            }
            else {
               if ('selectionStart' in elem) {
                  elem.focus();
                  elem.setSelectionRange(caretPos, caretPos);
               }
               else
                  elem.focus();
            }
         }
      }
   };


   when('rowHandle: mirror', tr => {
      $(`${pref}__button_select`, tr).on('click', action(`click: ${pref} select button`));
      
      if (tr.dataset.mirrorType) {
         // then check if original is on page
         const origId = $(tr).find('[colname="value"]')[0].dataset.itemId;
         const $orig = $(`.item_T_${tr.dataset.mirrorType}[data-item-id="${origId}"]`);

         if ($orig.length > 0) { // if orig have found
            $valueContent = $('[colname="value"] *', tr); // get all mirror value col content
            // bind all possible handlers to all content elements, with dispatch functionality
            const dispatch = 'pointerdown pointerup change keydown keyup click';
            $valueContent.on(dispatch, e => {
               const selector = generateSelector(e.currentTarget, 'tr');
               const $origTarget = $($orig[0].querySelectorAll(selector));
               if (e.currentTarget.tagName == 'INPUT') {
                  $origTarget.val(e.currentTarget.value);
                  $origTarget.parents('tr')[0].focusAfterRefresh = {
                     id: tr.dataset.itemId,
                     selector: selector,
                     caretPos: caretPos.get(e.currentTarget),
                  };
               }
               $origTarget.trigger(e.type);
            });
         }
         else { // no orig on page
            action(`rowHandle: ${tr.dataset.mirrorType}`)(tr);
         }
      }
      
      /** @param {HTMLElement} el */
      function generateSelector(el, until) {
         if ($(el).is(until)) return '*';
         const attrSelector = Array.from(el.attributes).map(attr => {
            if (attr.nodeName.match(/^(value|data.*value|data.*src)$/)) return '';
            return `[${attr.nodeName}="${attr.nodeValue}"]`;
         }).join('');
         return `${generateSelector(el.parentElement, until)} > ${el.tagName.toLowerCase()}${attrSelector}`;
      }
      
      window.generateSelector = generateSelector;
   });
   
   when(`click: ${pref} select button`, e => {
      e.stopPropagation();

      const isSelecting = $table[0].isMirrorSelecting;

      if (!isSelecting) {
         action(`select start: ${pref}`)(e.currentTarget);
      }
      else { // is selecting
         action(`select cancel: ${pref}`)(e.currentTarget);
      }
   });
   when(`select start: ${pref}`, button => {
      const $button = $(button);
      const itemId = $button.parents('[colname="value"]').attr('data-item-id');
      
      $table[0].isMirrorSelecting = {itemId, $tr: $button.parents('tr')};
      $button.text('Cancel');
      $table.addClass(`${pref}__selecting`.slice(1));
   });
   when(`select cancel: ${pref}`, button => {
      const $button = $(button);
      
      $table[0].isMirrorSelecting = false;
      $button.text('Select');
      $table.removeClass(`${pref}__selecting`.slice(1));
   });
   
   when(`${pref} click: tr`, async e => {
      if ($table[0].isMirrorSelecting) { // if selecting
         
         const itemId = $table[0].isMirrorSelecting.itemId;
         const targetId = e.currentTarget.dataset.itemId;

         const $mirrorTr = $table[0].isMirrorSelecting.$tr;
         const $targetTr = $(e.currentTarget);

         let res = await fetchJsonOk('Selecting', updateLink, {
            method: 'POST',
            body: {
               item_id: itemId,
               colname: 'value',
               value: targetId,
            }
         });
         
         const targetType = $targetTr.attr('data-item-type');

         const $newMirrorTr = await refreshMirror($mirrorTr, itemId, $targetTr, targetId, targetType, res.data);

         action(`select cancel: ${pref}`)($mirrorTr.find(`[colname="value"] ${pref}__button_select`)[0]);
      }
   });
   
   async function refreshMirror($mirrorTr, mirrorId, $targetTr, targetId, targetType, valueHtml) {
      let itemId = mirrorId;

      const $newMirrorTr = $(window.createRow(itemId, targetType, {
         key: $mirrorTr.find('[colname="key"] input').val(),
         name: $mirrorTr.find('[colname="name"] input').val(),
      }, false));

      $newMirrorTr.attr('data-item-type', 'mirror');
      $newMirrorTr.addClass(pref.slice(1));
      
      $newMirrorTr.find('[colname="value"]')
         .html(valueHtml)
         .attr('data-item-id', targetId)
         .attr('data-item-type', targetType);
      $newMirrorTr.find('[colname="type"]').text('mirror');
      
      $newMirrorTr.attr('data-mirror-type', targetType);

      window.rowHandle($newMirrorTr[0], 'mirror');

      $newMirrorTr.insertBefore($mirrorTr);
      $mirrorTr.remove();

      const targetTr = $targetTr[0];
      if (targetTr.focusAfterRefresh && targetTr.focusAfterRefresh.id == mirrorId) {
         const newMirrorInput = $newMirrorTr[0].querySelector(targetTr.focusAfterRefresh.selector);
         caretPos.set(newMirrorInput, targetTr.focusAfterRefresh.caretPos);
         targetTr.focusAfterRefresh = false;
      }
      
      return $newMirrorTr;
   }

   when('rowHandle defaults', tr => {
      $(tr).on('click', action(`${pref} click: tr`));
   });
   
   when('fetchJsonOk success', (url, options, res) => {
      let itemId = getOption('item_id');
      let colname = getOption('colname');

      if (url == updateLink && colname == 'value') {
         //console.log('mirror catch value update:', {updateLink, colname, itemId, res, options, url});

         $orig = $(`tr[data-item-id="${itemId}"]`);
         
         // if no original elements on page, then don't need to refresh on fetchJsonOk
         if ($orig.length == 0) return;

         // else, there is orig element on page
         // handling fetchJsonOk to refresh mirror on orig update
         $(`${pref} [colname="value"][data-item-id="${itemId}"]`).parents('tr').each(async (i, mirrorTr) => {
            let res = await fetchJsonOk('Rendering', valueRenderLink, {
               method: 'POST',
               body: {
                  item_id: itemId,
               },
            });

            refreshMirror($(mirrorTr), mirrorTr.dataset.itemId, $orig, itemId, $orig.attr('data-item-type'), res.html);
         });
      }

      function getOption(name) {
         if ('body' in options) {
            if (name in options.body)
               return options.body[name];
            else
               return '';
         }
         else
            return '';
      }
   });
});