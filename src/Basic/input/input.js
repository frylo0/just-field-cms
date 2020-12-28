$(document).ready(() => {
   const pref = '.input'; // prefix for current folder

   when('update: input', e => {
      e.target.parentElement.classList[e.target.value != '' ? 'add' : 'remove']('input_not-free');
   });

   $(pref + ' input')
      .on('keyup', action('update: input'))
      .each((i, inp) => action('update: input')({ target: inp }));
});