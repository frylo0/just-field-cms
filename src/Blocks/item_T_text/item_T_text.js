import EditorJS from '@editorjs/editorjs';
import tippy from 'tippy.js';


function item_T_text_initEditor() {
   const $editor = $($('#template_T_text_editor')[0].content.firstElementChild);
   $editor.appendTo('main');
   
   $editor.find('.editor-tabs__close-button').click(action('click: .editor-tabs close button'));
   $editor.find('.editor-tab__close-button').click(action('click: .editor-tabs single tab close button'));

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
      tools: {
         paragraph: {
            config: {
               placeholder: 'Type something...',
            }
         }
      }
   });
   
   window.item_T_text_editor = {
      $editor, editorjs,

      show() {
         this.$editor.removeClass('dn');
      },
      hide() {
         this.$editor.addClass('dn');
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
      window.item_T_text_editor.show();
   });
   
   item_T_text_handle(document, true);
   item_T_text_initEditor();
   
   window.item_T_text_handle = item_T_text_handle;
});