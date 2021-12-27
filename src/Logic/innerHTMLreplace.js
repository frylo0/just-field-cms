function innerHTMLreplace(el, descriptor) {
   for (let prop in descriptor) {
      el.innerHTML = el.innerHTML.replace(new RegExp('{' + prop + '}', 'g'), descriptor[prop]);
   }
}

window.innerHTMLreplace = innerHTMLreplace;