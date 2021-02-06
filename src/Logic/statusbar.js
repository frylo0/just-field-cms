$(document).ready(() => {
   const $statusbar = $('#statusbar');
   window.$statusbar = $statusbar;

   $statusbar.dotAnimation = {
      interval: null,
      start(newText) {
         $statusbar.text(newText);
         clearInterval(this.interval);
         this.interval = setInterval(() => {
            const text = $statusbar.text();
            if (text.endsWith('...')) $statusbar.text(text.slice(0, -3));
            else $statusbar.text(text + '.');
         }, 250);
      },
      stop(newText) {
         clearInterval(this.interval);
         $statusbar.text(newText);
      },
   };
});