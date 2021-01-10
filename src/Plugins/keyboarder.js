class Keyboarder {
   constructor() {
      $(document).ready(() => {
         const self = this;

         window.addEventListener('keydown', action('keydown: window'));
         window.addEventListener('keyup', action('keyup: window'));

         when('keydown: window', e => {
            self.state[e.key] = true;
         });
         when('keyup: window', e => {
            self.state[e.key] = false;
         });

         this.state = {};
      });
   }

   isPressed(key) {
      return this.state[key];
   }
}

export {
   Keyboarder,
};