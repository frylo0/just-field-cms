$(document).ready(() => {
   const pref = '.item_T_boolean'; // prefix for current folder
   const updateLink = document.querySelector('table').dataset.updateLink;
   
   function item_T_boolean_handle(context, usePrefix = false) {
      $(`${usePrefix ? pref : ''} [colname="value"] > input`, context).on('change', action(`change: ${pref} checkbox`));
   }

   when(`change: ${pref} checkbox`, async e => {
      const value = +e.currentTarget.checked;
      const itemId = $(e.currentTarget).parents('tr')[0].dataset.itemId;

      const formData = new FormData();
      formData.append('item_id', itemId);
      formData.append('colname', 'value');
      formData.append('value', value);

      let res = await fetchJsonOk('Updating', updateLink, {
         method: 'POST',
         body: formData,
      });
   });
   
   when('duplicateRow: boolean', (tr, id, typeName) => {
      $('[colname="value"] input', tr).attr('id', `item_T_boolean_${id}`);
      $('[colname="value"] label', tr).attr('for', `item_T_boolean_${id}`);
   });
   
   item_T_boolean_handle(document, true);
   when('rowHandle: boolean', tr => item_T_boolean_handle(tr));
   window.item_T_boolean_handle = item_T_boolean_handle;
});