import './__item/aside__item';
$(document).ready(() => {
   const pref = '.aside'; // prefix for current folder

   const $aside = $(pref);
   const $resizer = $(pref + '__resizer');

   $resizer
      .on('pointerdown', action('start: aside resizer'));

   $(window)
      .on('pointermove', e => action('pointer: window')('move', e))
      .on('pointerup', e => action('pointer: window')('up', e));

   when('pointer: window', (etype, e) => {
      //e => {

      //   if ($resizer[0].touched)
      //      action('move: aside resizer')(e);
      //}
      if ($resizer.length == 0) {
         console.warn('Using aside component as Basic with no aside (frity)');
         return;
      }

      if (etype == 'move' && $resizer[0].touched) action('move: aside resizer')(e);
      else if (etype == 'up') action('end: aside resizer')(e);
   });
   when('start: aside resizer', e => $resizer[0].touched = true);
   when('end: aside resizer', e => $resizer[0].touched = false);
   when('move: aside resizer', e => {
      $aside.css('width', `${e.pageX}px`);
   });
});