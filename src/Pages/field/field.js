import './../../bundle';

// Code libs and plugins
import { globalEventone } from '../../Plugins/eventone.js';
import { Keyboarder } from '../../Plugins/keyboarder';

// Tippy
import tippy, { followCursor } from 'tippy.js';
import 'tippy.js/dist/tippy.css';
import 'tippy.js/dist/backdrop.css';
import 'tippy.js/dist/border.css';
import 'tippy.js/themes/light-border.css';
import 'tippy.js/animations/shift-away-subtle.css';

globalEventone(); 

$(document).ready(() => {
   const pref = '.page_button-add';

   const templates = {
      object: document.getElementById('template_T_object'),
      list: document.getElementById('template_T_list'),
      field: document.getElementById('template_T_field'),
      image: document.getElementById('template_T_image'),
   };

   const titleNoData = document.getElementById('title_no-data');

   const searchParams = new URLSearchParams(location.search);
   const pathVal = searchParams.get('path');
   const path = pathVal === null ? '' : pathVal;


   // STOP: ADD BUTTONS
   const $buttonAdd = $(pref);
   const $buttonAddContent = $(`${pref}__content`);
   const $buttonAddType = $(`${pref}__type`);
   const fieldAddLink = $buttonAdd.attr('data-add-link');

   $buttonAdd.on('click', e => {
      $buttonAddContent.toggleClass('dn');
   });
   $buttonAddType.on('click', async e => {
      const fetchUrl = fieldAddLink + `&type-id=${e.target.dataset.id}&path=${window.state.path}`;
      const res = await fetchJsonOk('Adding', fetchUrl);

      const typeName = e.target.textContent.trim();

      let template = templates[typeName];
      let tr = template.content.cloneNode(true).firstElementChild;

      tr.dataset.itemId = res.id;
      innerHTMLreplace({
         key: '',
         name: '',
         type: typeName,
         subtype: '',
         value: '',
         permission: 'edit',
      });

      $(tr).on('pointerdown', action('pointerdown: tr'));
      $('td > input', tr).on('keyup', action('keyup: td input'));

      if (typeName == 'object') item_T_object_handle(tr);
      else if (typeName == 'image') item_T_image_handle(tr);

      document.querySelector('table > tbody').append(tr);

      titleNoData.classList.add('dn');

      function innerHTMLreplace(descriptor) {
         for (let prop in descriptor) {
            tr.innerHTML = tr.innerHTML.replace('{' + prop + '}', descriptor[prop]);
         }
      }
   });

   // STOP: INPUT UPDATE
   const updateLink = document.querySelector('table').dataset.updateLink;

   $('td > input').on('keyup', action('keyup: td input', e => {
      if ('keyUpTimeout' in e.target) { // is timeout
         clearTimeout(e.target.keyUpTimeout);
      }

      e.target.keyUpTimeout = setTimeout(() => {
         uploadTdInput(e.target);
      }, 1000);
   }));

   /** @param {HTMLElement} input */
   async function uploadTdInput(input) {
      const td = input.parentElement;
      const tr = td.parentElement;

      const colname = td.getAttribute('colname');
      const itemId = tr.dataset.itemId;

      const fetchUrl = updateLink;

      const formData = new FormData();
      formData.append('item_id', itemId);
      formData.append('colname', colname);
      formData.append('value', input.value);

      const res = await fetchJsonOk('Updating', fetchUrl, {
         method: 'POST',
         body: formData,
      });
   }

   // STOP: ROW SELECT
   const $trs = $('tr');
   const keyboarder = new Keyboarder();
   const selectedRows = [];

   const $buttonDeleteCount = $('#button-delete-count');
   const $buttonDelete = $('.page_button-delete');

   const $buttonDuplicateCount = $('#button-duplicate-count');
   const $buttonDuplicate = $('.page_button-duplicate');

   const tip = new tippy([$buttonDelete[0], $buttonDuplicate[0]], {
      content: 'No items selected. Use Ctrl+Click to select row',
   });
   const tips = {
      delete: tip[0],
      duplicate: tip[1],
   };

   let tipDelConfirm_visible = false;
   const tipDelConfirm = new tippy($buttonDelete[0], {
      allowHTML: true,
      interactive: true,
      hideOnClick: true,
      content: `
      <center><small>
         You are trying to delete List or Object.<br>
         This action will delete all inner content.<br></small>
         <big class="db mtbo5">Are you sure?</big>
         <button class="block block_mode_dark cup" onclick="action('click: delete confirm delete button')()">Delete</button>
         <button class="block block_mode_light cup" onclick="action('click: delete confirm cancel button')()">Cancel</button>
      </center>`,
      onShow(instance) {
         return tipDelConfirm_visible;
      }
   });

   $trs.on('pointerdown', action('pointerdown: tr', e => {
      if (!(/*keyboarder.isPressed('Shift') || */keyboarder.isPressed('Control'))) {
         console.warn('tr pointer down with no /*Shift or*/ Control pressed');
         return;
      }

      e.preventDefault();

      const $tr = $(e.currentTarget);
      $tr.toggleClass('tr_selected');
      if ($tr.hasClass('tr_selected')) {
         selectedRows.push($tr[0]);
      } else { // remove tr from selected
         selectedRows.splice(selectedRows.findIndex(v => v == $tr[0]), 1);
      }

      renderButton($buttonDeleteCount, tips.delete);
      renderButton($buttonDuplicateCount, tips.duplicate);
   }));

   function renderButton($buttonCount, tip) {
      $buttonCount.text(` (${selectedRows.length})`);
      if (selectedRows.length == 0) {
         $buttonCount.addClass('dn');
         tip.enable();
      } else {
         $buttonCount.removeClass('dn');
         tip.disable();
      }
   }

   // STOP: ROW DELETE
   const deleteLink = $buttonDelete[0].dataset.deleteLink;
   let deleteConfirmResolve;
   when('click: delete confirm delete button', e => deleteConfirmResolve('delete'));
   when('click: delete confirm cancel button', e => deleteConfirmResolve('cancel'));
   $buttonDelete.on('click', async e => {
      if ($buttonDeleteCount.hasClass('dn')) return;

      let hasObjectOrList = selectedRows.some(row => row.dataset.itemType.match(/^(object|list)$/));
      if (hasObjectOrList) {
         tipDelConfirm_visible = true;
         tipDelConfirm.show();

         const answ = await new Promise(res => {
            deleteConfirmResolve = res;
         });

         if (answ == 'cancel') {
            tipDelConfirm_visible = false;
            tipDelConfirm.hide();

            return;
         }
      }

      for (const row of selectedRows)
         await deleteRow(row);

      tipDelConfirm_visible = false;
      tipDelConfirm.hide();

      selectedRows.splice(0, selectedRows.length); // clear selectedRows
      renderButton($buttonDeleteCount, tips.delete);
      renderButton($buttonDuplicateCount, tips.duplicate);
   });

   async function deleteRow(row) {
      const keyEl = row.querySelector('[colname="key"] > input');
      const key = keyEl ? keyEl.value : '';

      const fetchUrl = deleteLink + `&item_id=${row.dataset.itemId}`;
      const res = await fetchJsonOk('Deleting', fetchUrl);
      row.remove();

      const isRows = document.querySelectorAll('table > tbody > tr').length;
      titleNoData.classList[isRows ? 'add' : 'remove']('dn');

      if (key == state.pathNext) {
         let url = window.location.origin + window.location.pathname;
         let query = new URLSearchParams(window.location.search);
         query.set('path', state.path);

         url += '?' + query.toString();
         window.history.pushState({}, document.title, url);

         let currPathPart = document.querySelector('.page_path__part_curr').nextElementSibling, prevPathPart;
         while (currPathPart) {
            prevPathPart = currPathPart;
            currPathPart = currPathPart.nextElementSibling;
            prevPathPart.remove();
         }
      }
   }

   // STOP: ROW DUPLICATE
   const duplicateLink = $buttonDuplicate[0].dataset.duplicateLink;
   $buttonDuplicate.on('click', async e => {
      if ($buttonDuplicateCount.hasClass('dn')) return;

      for (const row of selectedRows)
         await duplicateRow(row);
   });

   async function duplicateRow(row) {
      const keyEl = row.querySelector('[colname="key"] > input');
      const key = keyEl ? keyEl.value : '';

      const fetchUrl = duplicateLink + `&item_id=${row.dataset.itemId}`;
      const res = await fetchJsonOk('Duplicating', fetchUrl);

      const rowCopy = row.cloneNode(true);
      item_T_image_handle(rowCopy);
      rowCopy.classList.remove('tr_selected');
      row.parentElement.append(rowCopy);
   }
});