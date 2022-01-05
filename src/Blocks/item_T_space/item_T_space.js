$(document).ready(() => {
   const pref = '.item_T_space'; // prefix for current folder
   
   /**
    * Bind event listeners for element(s) given as context of function work. According to context do bind in any cases of usage (onload, field add, etc.).
    * @param {HTMLElement | JQuery} context The context param for JQuery in $('selector', context). According to context may need to use prefix of this field type (e.g. on load when context=document) or not (e.g. on field add, when context=$newCreatedTableRow)
    * @param {boolean} usePref Param to specify use this field type selector prefix ('.item_T_space') or not. This param is closely related to context param.
    * @returns {void} Nothing
    */
   function item_T_space_handle(context, usePrefix = false) {
      $(`${usePrefix ? pref : ''} input`, context).keyup(action(`keyup: ${pref} input`));
      $(`${usePrefix ? pref : ''} .table__order`, context).on('pointerdown', action(`pointerdown: .table order`));
   }

   when(`keyup: ${pref} input`, e => {
      const valueInput = e.currentTarget;
      const label = valueInput.nextElementSibling;
      if (valueInput.value == '') label.classList.add('dn');
      else label.classList.remove('dn');
   });
   
   item_T_space_handle(document, true);
   when('rowHandle: space', tr => item_T_space_handle(tr));
   
   window.item_T_space_handle = item_T_space_handle;
});