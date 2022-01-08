import EditorJS from '@editorjs/editorjs';
import Header from 'editorjs-header-with-anchor';
import Marker from '@editorjs/marker';
import AlignmentTool from 'editorjs-text-alignment-blocktune';
import Checklist from '@editorjs/checklist';
import Underline from '@editorjs/underline';
import List from '@editorjs/list';
import Quote from '@editorjs/quote';
import RawTool from '@editorjs/raw';
import Table from '@editorjs/table';
import Delimiter from '@editorjs/delimiter';
import ImageTool from '@editorjs/image';

import tippy from 'tippy.js';


const item_T_text_uploadByFile = '../__php/plugins/field-type_text/upload-by-file.php';
const item_T_text_uploadByUrl = '../__php/plugins/field-type_text/upload-by-url.php';
const item_T_text_delete = '../__php/plugins/field-type_text/delete.php';


function item_T_text_blocksToHTML(blocks) {
   let res = '';
   let items = '';
   for (let block of blocks) {
      items = '';
      switch (block.type) {
         case 'paragraph':
            res += `<p style="text-align: ${block.tunes.alignment.alignment}">${block.data.text}</p>`;
            break;

         case 'header':
            let n = block.data.level;
            let anchor = block.data.anchor ? block.data.anchor : '';
            res += `<h${n} style="text-align: ${block.tunes.alignment.alignment}" id="${anchor}">${block.data.text}</h${n}>`;
            break;

         case 'checklist':
            for (let item of block.data.items) {
               items += `
                  <li>
                     <input 
                        type="checkbox" 
                        ${item.checked ? 'checked="checked"' : ''} 
                        onclick="return false;"
                        style="margin-left: -1.25em" />${item.text}
                  </li>`
            }
            res += `<ul style="list-style-type: none">${items}</ul>`;
            break;

         case 'list':
            for (let item of block.data.items)
               items += `<li>${item}</li>`;
            let ou = block.data.style == 'unordered' ? 'u' : 'o';
            res += `<${ou}l>${items}</${ou}l>`;
            break;
            
         case 'quote':
            res += `
               <figure style="text-align: ${block.data.alignment}">
                  <blockquote cite="#">
                     ${block.data.text}
                  </blockquote>
                  <figcaption>${block.data.caption}</figcaption>
               </figure>`;
            break;
            
         case 'raw':
            res += block.data.html;
            break;
            
         case 'table':
            res += '<table>';
            // copy content to do not spoil save data
            let content = JSON.parse(JSON.stringify(block.data.content));
            if (block.data.withHeadings) {
               res += '<thead><tr>';
               let firstRow = content.shift();
               for (let td of firstRow)
                  res += `<td>${td}</td>`;
               res += '</tr></thead>';
            }
            res += '<tbody>';
            for (let row of content) {
               res += '<tr>';
               for (let td of row) {
                  res += `<td>${td}</td>`;
               }
               res += '</tr>';
            }
            res += '</tbody>';
            res += '</table>';
            break;
            
         case 'delimiter':
            res += '<hr />';
            break;
            
         case 'image':
            res += `
            <figure>
               <img 
                  src="${block.data.file.url}" 
                  width="${block.data.stretched ? '100%' : ''}"
                  data-with-border="${block.data.withBorder}"
                  data-with-background="${block.data.withBackground}" />
               <figcaption>${block.data.caption}</figcaption>
            </figure>
            `;
            break;
            
         default:
            console.warn(`In item_T_text_blocksToHTML, while processing, have been meet unhandled block type "${block.type}". Change function code to handle this type to html conversion.`);
            console.warn(block);
      };
   }
   return res;
}


function item_T_text_initEditor() {
   const updateLink = document.querySelector('table').dataset.updateLink;

   const $editor = $($('#template_T_text_editor')[0].content.firstElementChild);
   $editor.appendTo('main');
   
   $editor.find('.editor-tabs__close-button').click(action('click: .editor-tabs close button'));
   $editor.find('.editor-tab__close-button').click(action('click: .editor-tabs single tab close button'));

   $editor.$tabs = $editor.find('.editor-tabs__tabs');
   $editor.$tabFocused = $editor.find('.editor-tabs__tab_focused');
   $editor.$tabUnfocused = $editor.find('.editor-tabs__tab_unfocused');

   when('click: .editor-tabs close button', e => {
      window.item_T_text_editor.close();
   });
   when('click: .editor-tabs single tab close button', e => {
      window.item_T_text_editor.close();
   });

   let tips = {
      tippy: null,
      init() {
         this.tippy = new tippy($editor.find('[data-tip]').toArray(), {
            content: ref => ref.dataset.tip,
         });
      },
      destroy() {
         this.tippy.forEach(instance => instance.destroy());
      }
   };
   
   const editorjs = new EditorJS({
      holder: 'editorjs',
      placeholder: 'Type something...',
      
      tools: {
         paragraph: {
            tunes: ['alignment'],
         },
         header: {
            class: Header,
            shortcut: 'CMD+SHIFT+H',
            config: {
               placeholder: 'Enter a header',
               levels: [1,2,3,4,5,6],
               defaultLevel: 3,
               allowAnchor: true,
               anchorLength: 100,
            },
            tunes: ['alignment'],
         },
         marker: {
            class: Marker,
            shortcut: 'CMD+SHIFT+M',
         },
         alignment: {
            class: AlignmentTool,
            config: {
               default: 'left',
               blocks: {
                  header: 'left',
                  list: 'left',
               }
            }
         },
         checklist: {
            class: Checklist,
            inlineToolbar: true,
            tunes: ['alignment'],
         },
         underline: {
            class: Underline,
         },
         list: {
            class: List,
            inlineToolbar: true,
         },
         quote: {
            class: Quote,
            inlineToolbar: true,
            shortcut: 'CMD+SHIFT+O',
            config: {
               quotePlaceholder: 'Enter a quote',
               captionPlaceholder: 'Quote\'s author',
            }
         },
         raw: {
            class: RawTool,
         },
         table: {
            class: Table,
            inlineToolbar: true,
            config: {
               rows: 2,
               cols: 3,
            }
         },
         delimiter: {
            class: Delimiter,
         },
         image: {
            class: ImageTool,
            config: {
               uploader: {
                  /**
                    * Upload file to the server and return an uploaded image data
                    * @param {File} file - file selected from the device or pasted by drag-n-drop
                    * @return {Promise.<{success, file: {url}}>}
                    */
                  async uploadByFile(file) {
                     let id = window.item_T_text_editor.state.editorLastChangeId;
                     console.log('Last change id is:', id);

                     let url = window.location.href;
                     url = url.split('/');
                     while (url.pop() != 'field'); // pop until remove 'field'
                     url = url.join('/'); // now url is host of JustField CMS

                     const formData = new FormData();
                     formData.append('item-id', item_T_text_editor.state.currentID);
                     formData.append('id', id);
                     formData.append('image', file);
                     formData.append('host', url);

                     let res = await fetchJsonOk('Uploading image', item_T_text_uploadByFile, {
                        method: 'POST',
                        body: formData,
                     });
                     
                     return res;
                  },
                  /**
                    * Send URL-string to the server. Backend should load image by this URL and return an uploaded image data
                    * @param {string} url - pasted image URL
                    * @return {Promise.<{success, file: {url}}>}
                    */
                  async uploadByUrl(file) {
                     let id = window.item_T_text_editor.state.editorLastChangeId;

                     let url = window.location.href;
                     url = url.split('/');
                     while (url.pop() != 'field'); // pop until remove 'field'
                     url = url.join('/'); // now url is host of JustField CMS

                     const formData = new FormData();
                     formData.append('id', id);
                     formData.append('image', file);
                     formData.append('host', url);

                     let res = await fetchJsonOk('Uploading image', item_T_text_uploadByUrl, {
                        method: 'POST',
                        body: formData,
                     });
                     
                     return res;
                  }
               }
            }
         }
      },

      onReady() {
         console.log('Editor.js is ready to work!');
         window.item_T_text_editor.state.ready = true;
      },
      onChange(api, event) {
         window.item_T_text_editor.state.editorLastChangeId = event.id;
         //console.log('Editor.js change, with api:', api, 'and event:', event);
         (async function () {

            let editorContent = await window.item_T_text_editor.editorjs.save();

            const formData = new FormData();
            formData.append('item_id', window.item_T_text_editor.state.currentID);
            formData.append('colname', 'value');
            formData.append('value', JSON.stringify({
               value: editorContent.blocks.length == 0 ? '' : editorContent, // free value if editor free
               html: item_T_text_blocksToHTML(editorContent.blocks),
            }));

            let res = await fetchJsonOk('Updating', updateLink, {
               method: 'POST',
               body: formData,
            });
            
            // updating data-value on target row button, to render changed value on new editor open on same row
            const $targetRow = $($('[colname="id"]').toArray().find(col => col.textContent == this.state.currentID)).parents('tr');
            $targetRow.find('[colname="value"] button').attr('data-value', res.data.replace(/\\"/g, '"'));
            

            // if !lastBlocks, then editor just loaded and don't need to do anything, so exit
            if (!window.item_T_text_editor.state.lastBlocks) return;

            // after change handlers (e.g. some stuff after delete or after add)
            const lastBlocks = window.item_T_text_editor.state.lastBlocks.blocks;

            let targetBlockFromLast = null;
            for (let block of lastBlocks) 
               if (block.id == event.id) {
                  targetBlockFromLast = block;
                  break;
               }

            if (lastBlocks.length > editorContent.blocks.length) {
               // on delete
               this.onBlockDelete(targetBlockFromLast);
            } else if (lastBlocks.length < editorContent.blocks.length) {
               // on add
               this.onBlockAdd(targetBlockFromLast);
            } else {
               // on update (block value change)
               this.onBlockUpdate(targetBlockFromLast);
            }
            window.item_T_text_editor.state.lastBlocks = editorContent;

         }.bind(window.item_T_text_editor)());
      },
   });
   
   window.item_T_text_editor = {
      $editor, editorjs, tips,
      
      state: {
         currentID: null,
         ready: false,
         editorLastChangeId: null,
         lastBlocks: {
            blocks: [],
         },
      },

      _addTab(targetID, title) {
         let $tab = this.$editor.$tabFocused.clone();
         
         $tab[0].dataset.id = targetID;
         innerHTMLreplace($tab[0], {
            id: targetID,
            title: title,
         });

         $tab.find('.editor-tab__close-button').click(action('click: .editor-tabs single tab close button'));
         
         $tab.removeClass('dn');
         $tab.appendTo(this.$editor.$tabs);
      },

      show() {
         this.$editor.removeClass('dn');
      },
      hide() {
         this.$editor.addClass('dn');
      },
      
      open(targetID, value, title) {
         this._addTab(targetID, title);
         this.load(value ? JSON.parse(value) : null);

         this.state.currentID = targetID;
         this.tips.init();
      
         this.show();
      },
      close() {
         this.$editor.$tabs.find('.editor-tabs__tab:not(.dn)').remove();
         this.tips.destroy();
         this.state.lastBlocks = { blocks: [] };
         this.hide();
      },
      
      async load(data) {
         // if editor is not ready, then wait till become ready, and do same thing
         if (!window.item_T_text_editor.state.ready)
            return new Promise((res, rej) => {
               setTimeout(() => {
                  // if no data given then don't need to load it
                  if (!data) {
                     window.item_T_text_editor.editorjs.clear(); // clear editorjs because of remove-add bug - if no data, then editor should be cleared
                  }
                  else {
                     this.load(data)
                        .then(r => {

                           window.item_T_text_editor.state.lastBlocks = data;
                           res(r);
                        })
                        .catch(err => rej(err));
                  }
               }, 500);
            });

         // else
         // if editor loaded, then load promise (editorjs.render)
         // if no data given then don't need to load it
         if (!data) {
            window.item_T_text_editor.editorjs.clear(); // clear editorjs because of remove-add bug - if no data, then editor should be cleared
         }
         else {
            return new Promise((res, rej) => {
               this.editorjs.render(data)
                  .then(r => res(r))
                  .catch(err => rej(err));
            });
         }
      },
      async save() {
         return new Promise((res, rej) => {
            this.editorjs.save()
               .then(outputData => res(outputData))
               .catch(error => rej(error));
         });
      },

      async onBlockAdd(block) {
         // on editor add block
      },
      async onBlockDelete(block) {
         // on editor delete block
         switch (block.type) {
            case 'image':
               const fileUrl = block.data.file.url;

               // if file not in T_text folder, then image was pasted by url and don't need to delete from server
               if (!fileUrl.match(/__assets\/T_text/)) return; // so exit function
               // else file on server and need to delete

               const fileName = fileUrl.split('/').slice(-2).join('/');

               const formData = new FormData();
               formData.append('file-name', fileName);
               let res = await fetchJsonOk('Deleting image', item_T_text_delete, {
                  method: 'POST',
                  body: formData,
               });
               break;

            default:
               console.warn(`onBlockDelete: block.type "${block.type}" has no handler. (block:`, block, ').');
         }
      },
      async onBlockUpdate(block) {
         // on editor update block
      },
   };
}


$(document).ready(() => {
   const pref = '.item_T_text'; // prefix for current folder
   
   when('rowHandle: text', tr => {
      $('[colname="value"] button', tr).click(action(`click: ${pref} text editor button`));
   });
   
   when(`click: ${pref} text editor button`, e => {
      let $currentTarget = $(e.currentTarget);
      let $tr = $currentTarget.parents('tr');
      window.item_T_text_editor.open(
         e.currentTarget.dataset.itemId, // id
         e.currentTarget.dataset.value, // value
         $tr.find('[colname="name"] input').val() || $tr.find('[colname="key"] input').val() // editor title
      );
   });
   
   when('duplicateRow: text', (tr, id, typeName) => {
      $('[colname="value"] button', tr).attr('data-item-id', id);
   });

   item_T_text_initEditor();
});