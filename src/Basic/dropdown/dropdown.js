$(document).ready(() => {
   const pref = '.dropdown'; // prefix for current folder

   $(pref + '__title').on('click', e => {
      const dd = e.currentTarget.parentElement;
      const content = e.currentTarget.nextElementSibling;
      const svg = e.currentTarget.children[0].firstElementChild;
      const transform = svg.style.transform;

      if (dd.getAttribute('data-opened') == 'true') {
         dd.setAttribute('data-opened', 'false');
         svg.style.transform = transform.replace('rotate(0deg)', 'rotate(-90deg)');
         $(content).slideUp('fast');
      } else {
         dd.setAttribute('data-opened', 'true');
         svg.style.transform = transform.replace('rotate(-90deg)', 'rotate(0deg)');
         $(content).slideDown('fast');
      }

   });
});