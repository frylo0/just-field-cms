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
               <div style="
                  background-image: url('${block.data.file.url}');
                  background-repeat: no-repeat;
                  background-size: ${block.data.stretched ? 'cover' : 'contain'}"
                  data-with-border="${block.data.withBorder}
                  data-with-background="${block.data.withBackground}">
               </div>
               <figcaption>${block.data.caption}</figcaption>
            </figure>
            `;
            break;
            
         default:
            console.warn(`In item_T_text_blocksToHTML, while processing, have been meet unhandled block type "${block.type}". Change function code to handle this type to html conversion.`);
            console.warn(block);
      };
   }
   console.log(blocks);
   console.log(res.replace(/\s+/g, ' '));
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
      window.item_T_text_editor.hide();
   });
   when('click: .editor-tabs single tab close button', e => {
      window.item_T_text_editor.hide();
   });

   new tippy($editor.find('[data-tip]').toArray(), {
      content: ref => ref.dataset.tip,
   });
   
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
               endpoints: {
                  byFile: '../__php/plugins/field-type_text/upload-by-file.php', // backend file uploader endpoint
                  byUrl: '../__php/plugins/field-type_text/upload-by-url.php', // endpoint that provides uploading by url
               }
            }
         }
      },

      onReady() {
         console.log('Editor.js is ready to work!');
         window.item_T_text_editor.state.ready = true;
      },
      onChange(api, event) {
         (async function () {
            let editorContent = await window.item_T_text_editor.editorjs.save();
            if (editorContent.blocks.length == 0)
               editorContent = '';

            const formData = new FormData();
            formData.append('item_id', window.item_T_text_editor.state.currentID);
            formData.append('colname', 'value');
            formData.append('value', JSON.stringify({
               value: editorContent,
               html: item_T_text_blocksToHTML(editorContent.blocks),
            }));

            let res = await fetchJsonOk('Updating', updateLink, {
               method: 'POST',
               body: formData,
            });

            console.log(res);
         }());
      },
   });
   
   window.item_T_text_editor = {
      $editor, editorjs,
      
      state: {
         currentID: null,
         ready: false,
      },

      _addTab(targetID, title) {
         let $tab = this.$editor.$tabFocused.clone();
         innerHTMLreplace($tab[0], {
            id: targetID,
            title: title,
         });
         $tab.removeClass('dn');
         $tab.appendTo(this.$editor.$tabs);
      },

      show(targetID, value, title) {
         this.$editor.removeClass('dn');
         
         this._addTab(targetID, title);
         if (value)
            this.load(JSON.parse(value));

         this.state.currentID = targetID;
      },
      hide() {
         this.$editor.addClass('dn');
      },
      
      async load(data) {
         // if no data given then don't need to load it
         if (!data) return;

         // if editor is not ready, then wait till become ready, and do same thing
         if (!window.item_T_text_editor.state.ready)
            return new Promise((res, rej) => {
               setTimeout(() => {
                  this.load(data)
                     .then(r => res(r))
                     .catch(err => rej(err));
               }, 500);
            });

         // else
         // if editor loaded and data provided, then load promise (editorjs.render)
         return new Promise((res, rej) => {
            this.editorjs.render(data)
               .then(r => res(r))
               .catch(err => rej(err));
         });
      },
      async save() {
         return new Promise((res, rej) => {
            this.editorjs.save()
               .then(outputData => res(outputData))
               .catch(error => rej(error));
         });
      },
   };
}


$(document).ready(() => {
   const pref = '.item_T_text'; // prefix for current folder
   
   /**
    * Bind event listeners for element(s) given as context of function work. According to context do bind in any cases of usage (onload, field add, etc.).
    * @param {HTMLElement | JQuery} context The context param for JQuery in $('selector', context). According to context may need to use prefix of this field type (e.g. on load when context=document) or not (e.g. on field add, when context=$newCreatedTableRow)
    * @param {boolean} usePref Param to specify use this field type selector prefix ('.item_T_text') or not. This param is closely related to context param.
    * @returns {void} Nothing
    */
   function item_T_text_handle(context, usePrefix = false) {
      $(`${usePrefix ? pref : ''} [colname="value"] button`, context).click(action(`click: ${pref} text editor button`));
   }
   
   when(`click: ${pref} text editor button`, e => {
      let $currentTarget = $(e.currentTarget);
      let $tr = $currentTarget.parents('tr');
      window.item_T_text_editor.show(
         e.currentTarget.dataset.itemId, // id
         e.currentTarget.dataset.value, // value
         $tr.find('[colname="name"] input').val() || $tr.find('[colname="key"] input').val() // editor title
      );
   });
   
   item_T_text_handle(document, true);
   item_T_text_initEditor();
   
   window.item_T_text_handle = item_T_text_handle;
});