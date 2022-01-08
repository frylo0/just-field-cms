$(document).ready(() => {
   const pref = '.item_T_object'; // prefix for current folder
   const template = document.getElementById('template_T_object').content.cloneNode(true);
   const templateHref = $('[colname="value"] > a', template.firstElementChild).attr('href');

   when('rowHandle: object', tr => {
      if (!tr.classList.contains('item_T_mirror')) { // if not mirror
         $('[colname="key"] > input', tr).on('keyup', action(`keyup: ${pref} key input`));
      }
   });

   when(`keyup: ${pref} key input`, e => {
      const key = e.target.value;
      let pathI = window.state.path.split('/').length + 1;
      if (window.state.path == '')
         pathI = 1;
      const targetHref = templateHref
         .replace(/\{key\}/g, key)
         .replace(/\{path\}/g, (window.state.path == '' ? '' : window.state.path + '/'))
         .replace(/\{path_i\}/g, pathI);
      $tr = $(e.target).parents(pref)
      $tr.find('[colname="value"] > a').attr('href', targetHref);
      // same page mirrors update
      $(`.item_T_mirror [colname="value"][data-item-id="${$tr.attr('data-item-id')}"] > a`).attr('href', targetHref);
   });
});