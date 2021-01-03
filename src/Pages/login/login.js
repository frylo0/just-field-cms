import './../../bundle';
import md5 from 'md5';

// Code libs and plugins
import { globalEventone } from '../../Plugins/eventone.js';

globalEventone();

$(document).ready(() => {
   $('form').on('submit', e => {
      const $password = $('#password');
      const $passwordView = $('#password-view');
      const password = $passwordView.val();
      $password.val(md5(password));
      return true;
   });
});