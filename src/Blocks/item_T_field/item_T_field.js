$(document).ready(() => {
   const pref = '.item_T_field'; // prefix for current folder
   
   when(`${pref} init`, function (i, row) {
      $('.table__order', row).on('pointerdown', action('pointerdown: .table order'));
   });
   $(`${pref}`).each(action(`${pref} init`));
   when('rowHandle: field', tr => action(`${pref} init`)(0, tr));
});