$(document).ready(() => {
   const pref = '.item_T_object'; // prefix for current folder
   const template = document.getElementById('template_T_object').content.cloneNode(true);
   const templateHref = $('[colname="value"] > a', template.firstElementChild).attr('href');

   function item_T_object_handle(context, usePrefix = false) {
      $(`${usePrefix ? pref : ''} [colname="key"] > input`, context).on('keyup', action(`keyup: ${pref} key input`));
   }

   when(`keyup: ${pref} key input`, e => {
      const key = e.target.value;
      $(e.target).parents(pref).find('[colname="value"] > a').attr('href', templateHref.replace(/\{key\}/g, key));
   });

   item_T_object_handle(document, true);

   window.item_T_object_handle = item_T_object_handle;
});