$(document).ready(() => {
   const pref = '.item_T_field'; // prefix for current folder
   const updateLink = document.querySelector('table').dataset.updateLink;
   
   when('rowHandle: field', tr => {
      $('[colname="value"] input', tr).on('keyup', action(`keyup: ${pref} value`));
   });
   
   when(`keyup: ${pref} value`, e => {
      if ('keyUpTimeout' in e.target) { // is timeout
         clearTimeout(e.target.keyUpTimeout);
      }

      e.target.keyUpTimeout = setTimeout(() => {
         uploadTdInput(e.target);
      }, 500);
      
      async function uploadTdInput(input) {
         const td = input.parentElement;

         const colname = td.getAttribute('colname');
         const itemId = td.dataset.itemId;

         const fetchUrl = updateLink;

         const formData = new FormData();
         formData.append('item_id', itemId);
         formData.append('colname', colname);
         formData.append('value', input.value);

         const res = await fetchJsonOk('Updating', fetchUrl, {
            method: 'POST',
            body: formData,
         });
      }
   });
});