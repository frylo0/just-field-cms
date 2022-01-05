$(document).ready(() => {
   const pref = '.item_T_file'; // prefix for current folder
   const updateLink = document.querySelector('table').dataset.updateLink;

   when(`${pref} init`, function (i, row) {
      const item = row;
      const $buttonUpload = $(`${pref}__upload-button`, row);
      const $buttonDownload = $(`${pref}__download-button`, row);
      const $file = $(`${pref}__file`, row);

      $buttonUpload.on('click', () => action(`click: ${pref} button upload`)($file));
      $file.on('change', () => action(`change: ${pref} file`)($buttonDownload, $file, item));
      $('.table__order', row).on('pointerdown', action('pointerdown: .table order'));
   });
   $(`${pref}`).each(action(`${pref} init`));

   when(`click: ${pref} button upload`, $file => {
      $file.trigger('click');
   });
   when(`change: ${pref} file`, async ($buttonDownload, $file, item) => {
      const fetchUrl = updateLink;

      const formData = new FormData();
      formData.append('item_id', item.dataset.itemId);
      formData.append('colname', 'value');
      formData.append('value', $file[0].files[0]);

      let res = await fetchJsonOk('Uploading', fetchUrl, {
         method: 'POST',
         body: formData,
      });
      
      $buttonDownload.find('a').attr('href', res.data); // updating link on download button
      $buttonDownload.removeAttr('disabled');
   });

   window.item_T_file_handle = function (row) {
      action(`${pref} init`)(0, row);
   };
   when('rowHandle: file', tr => window.item_T_file_handle(tr));
});