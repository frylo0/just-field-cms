$(document).ready(() => {
   const pref = '.item_T_boolean'; // prefix for current folder
   const updateLink = document.querySelector('table').dataset.updateLink;
   
   when('rowHandle: boolean', tr => {
      $('[colname="value"] > label', tr).on('click', action(`click: ${pref} checkbox`));
   });

   when(`click: ${pref} checkbox`, async e => {
      const input = e.currentTarget.previousElementSibling;
      input.checked = !input.checked;
      action(`change: ${pref} checkbox`)(input);
   });
   when(`change: ${pref} checkbox`, async input => {
      const value = +input.checked;
      const itemId = $(input).parents('[colname="value"]')[0].dataset.itemId;

      const formData = new FormData();
      formData.append('item_id', itemId);
      formData.append('colname', 'value');
      formData.append('value', value);

      let res = await fetchJsonOk('Updating', updateLink, {
         method: 'POST',
         body: formData,
      });
   });
});