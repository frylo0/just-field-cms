import './__item/aside__item';
$(document).ready(() => {
   const pref = '.aside'; // prefix for current folder

   const $aside = $(pref);
   const $resizer = $(pref + '__resizer');

   $resizer
      .on('pointerdown', action('touch start: aside resizer'))
      .on('pointerup', action('touch end: aside resizer'));
   $(window).on('pointermove', e => {
      if ($resizer.length == 0) {
         console.warn('Using aside component as Basic with no aside (frity)');
         return;
      }
      if ($resizer[0].touched)
         action('move: aside resizer')(e);
   });

   when('touch start: aside resizer', e => $resizer[0].touched = true);
   when('touch end: aside resizer', e => $resizer[0].touched = false);
   when('move: aside resizer', e => {
      console.log(e);
      $aside.css('width', `${e.pageX}px`);
   });
});