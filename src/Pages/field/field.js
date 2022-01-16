import './../../bundle';

import './../../Blocks/item_T_field/item_T_field';
import './../../Blocks/item_T_object/item_T_object';
import './../../Blocks/item_T_list/item_T_list';
import './../../Blocks/item_T_image/item_T_image';
import './../../Blocks/item_T_space/item_T_space';
import './../../Blocks/item_T_text/item_T_text';
import './../../Blocks/item_T_boolean/item_T_boolean';
import './../../Blocks/item_T_file/item_T_file';
import './../../Blocks/item_T_audio/item_T_audio';
import './../../Blocks/item_T_video/item_T_video';
import './../../Blocks/item_T_mirror/item_T_mirror';
import './../../Blocks/item_T_excel/item_T_excel';


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

// Cookies
import { setCookie, getCookie } from '../../Plugins/cookie';

globalEventone(); 

$(document).ready(() => {
   const pref = '.page_button-add';

   const templates = window.templates;

   const titleNoData = document.getElementById('title_no-data');

   const searchParams = new URLSearchParams(location.search);
   const pathVal = searchParams.get('path');
   const path = pathVal === null ? '' : pathVal;


   // STOP: ADD BUTTONS
   const $buttonAdd = $(pref);
   const $buttonAddContent = $(`${pref} .page_button__content`);
   const $buttonAddType = $(`${pref}__type`);
   const fieldAddLink = $buttonAdd.attr('data-add-link');
   
   function createRow(id, typeName, replacements = {}, isHandle = true) {
      let template = templates[typeName];
      let tr = template.content.cloneNode(true).firstElementChild;

      tr.dataset.itemId = id;
      tr.dataset.itemType = typeName;

      const repl = {
         id: id,
         key: '',
         name: '',
         type: typeName,
         subtype: '',
         value: '',
         permission: 'edit',
         path: path,
         path_i: path.split('/').length + 1,
      };
      for (let prop in replacements) {
         let val = replacements[prop];
         repl[prop] = val;
      }
      innerHTMLreplace(tr, repl);

      if (isHandle)
         rowHandle(tr, typeName);
      appendRow(tr);
      
      return tr;
   }
   window.createRow = createRow;
   
   function appendRow(tr) {
      document.querySelector('table > tbody').append(tr);
      titleNoData.classList.add('dn');
   }
   
   $('.page_button_with-content').on('click', e => {
      $(e.currentTarget).find('.page_button__content').toggleClass('dn');
   })

   $buttonAddType.on('click', async e => {
      const fetchUrl = fieldAddLink + `&type-id=${e.currentTarget.dataset.id}&path=${window.state.path}`;
      const res = await fetchJsonOk('Adding', fetchUrl);

      const typeName = e.currentTarget.querySelector('span').textContent.trim().toLowerCase();

      createRow(res.id, typeName);
   });

   function rowHandle(row, typeName) {
      const tr = row;

      $(tr).on('pointerdown', action('pointerdown: tr'));
      $('td > input', tr).on('keyup', action('keyup: td input'));
      $('.table__order', tr).on('pointerdown', action(`pointerdown: .table order`));

      action('rowHandle defaults')(tr);
      
      // factory for rowHandle: each field define own function on action with target type name
      action(`rowHandle: ${typeName}`)(tr);
   }
   window.rowHandle = rowHandle;
   $('.table tbody tr').each((i, row) => rowHandle(row, row.dataset.itemType));

   // STOP: INPUT UPDATE
   const updateLink = document.querySelector('table').dataset.updateLink;
   const renderLink = document.querySelector('table').dataset.renderLink;

   $('td:not([colname="value"]) > input').on('keyup', action('keyup: td input', e => {
      if ('keyUpTimeout' in e.target) { // is timeout
         clearTimeout(e.target.keyUpTimeout);
      }

      e.target.keyUpTimeout = setTimeout(() => {
         uploadTdInput(e.target);
      }, 500);
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

   const $buttonMoveCount = $('#button-move-count');
   const $buttonMove = $('.page_button-move');
   const $buttonMoveControlsCount = $('#button-move-controls-count');
   const $buttonMoveControls = $('.page_button-move-controls');
   const $buttonMoveHere = $('.page_button-move-here');
   const $buttonMoveCancel = $('.page_button-move-cancel');

   const tip = new tippy([$buttonDelete[0], $buttonDuplicate[0], $buttonMove[0]], {
      content: 'No items selected. Use Ctrl+Click to select row',
   });
   const tips = {
      delete: tip[0],
      duplicate: tip[1],
      move: tip[2],
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
         <button class="box box_mode_dark cup" onclick="action('click: delete confirm delete button')()">Delete</button>
         <button class="box box_mode_light cup" onclick="action('click: delete confirm cancel button')()">Cancel</button>
      </center>`,
      onShow(instance) {
         return tipDelConfirm_visible;
      }
   });

   when('pointerdown: tr', e => {
      if (!(/*keyboarder.isPressed('Shift') || */keyboarder.isPressed('Control'))) {
         //console.warn('tr pointer down with no /*Shift or*/ Control pressed');
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
      renderButton($buttonMoveCount, tips.move);
   });

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
      renderButton($buttonMoveCount, tips.move);
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
      const fetchUrl = duplicateLink + `&item_id=${row.dataset.itemId}`;
      const res = await fetchJsonOk('Duplicating', fetchUrl); // sending query to duplicate values in DB

      const rowCopy = row.cloneNode(true); // clone target node
      rowCopy.dataset.itemId = res.id; // changing tr(data-item-id) to new one
      $(rowCopy).find('[colname="value"]').attr('data-item-id', res.id); // update td value item id
      $('[colname="id"]', rowCopy).html(res.id); // updating visible id
      
      const typeName = rowCopy.querySelector('[colname="type"]').textContent.trim(); // taking typeName for rowHandle
      rowHandle(rowCopy, typeName); // handling all events for new row, according to it type
      rowCopy.classList.remove('tr_selected'); // removing row selection

      // any type can handle to target type action, e.g. boolean update id in label(for) attribute
      action(`duplicateRow: ${typeName}`)(rowCopy, res.id, typeName, res);

      // adding new row to table
      row.parentElement.append(rowCopy);
   }
   
   // STOP: ROW MOVE
   const moveLink = $buttonMove[0].dataset.moveLink;
   $buttonMove.on('click', e => {
      // If no rows selected, then exit
      if ($buttonMoveCount.hasClass('dn')) return;

      // Taking selected rows ids
      let moveIds = [];
      for (const row of selectedRows)
         moveIds.push(row.dataset.itemId);

      // Adding move rows to local storage
      setCookie('-jf_move', moveIds.join(','), 10000000);
      
      // Hide move button & show move controls
      $buttonMove.addClass('dn');
      $buttonMoveControls.removeClass('dn');
      
      // Update move controls count
      $buttonMoveControlsCount.text($buttonMoveCount.text());
   });
   function returnMoveButton() {
      // Hide controls & Show simple move button
      $buttonMoveControls.addClass('dn');
      $buttonMove.removeClass('dn');
      
      // Clearing cookie
      setCookie('-jf_move', '', 10000000);
   }
   // Handle move cancel button
   $buttonMoveCancel.on('click', e => {
      returnMoveButton();
   });
   // Handle move here button
   $buttonMoveHere.on('click', async e => {
      const moveLink = e.currentTarget.dataset.moveLink;
      const targetParentId = $('table.table').attr('data-parent-id');

      let moveIds = getCookie('-jf_move', '', 10000000);
      // if no ids in cookie, then exit function
      if (!moveIds) return;
      // else, moving here
      moveIds = moveIds.split(',');
      
      const trs = {};
      const $trIds = $('.page_content .table tr').toArray().forEach(el => { trs[el.dataset.itemId] = el; });
      // for each id, sending to scripts/index.php
      for (let id of moveIds) {
         // if page has tr with suchid, then skip (same place move)
         if (id in trs) continue;
         // send query to backend
         let res;
         res = await fetchJsonOk('Moving', moveLink, {
            method: 'POST',
            body: {
               item_id: id,
               target_parent_id: targetParentId,
            },
         });
         const targetType = res.type;
         res = await fetchJsonOk('Rendering', renderLink, {
            method: 'POST',
            body: {
               item_id: id,
            },
         });

         // add new tr to table
         const tr = $(res.html)[0];
         appendRow(tr);
         
         rowHandle(tr, targetType);
      }
      
      returnMoveButton();
   });
});