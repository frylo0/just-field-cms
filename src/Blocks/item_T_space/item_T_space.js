$(document).ready(() => {
   const pref = '.item_T_space'; // prefix for current folder
   
   when('rowHandle: space', tr => {
      $('input', tr).keyup(action(`keyup: ${pref} input`));
   });

   when(`keyup: ${pref} input`, e => {
      const valueInput = e.currentTarget;
      const label = valueInput.nextElementSibling;
      if (valueInput.value == '') label.classList.add('dn');
      else label.classList.remove('dn');
   });
});