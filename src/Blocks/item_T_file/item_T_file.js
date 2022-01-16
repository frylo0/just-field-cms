$(document).ready(() => {
   const pref = '.item_T_file'; // prefix for current folder
   const updateLink = document.querySelector('table').dataset.updateLink;

   when('rowHandle: file', tr => {
      const row = tr, item = tr;
      const $buttonUpload = $(`${pref}__upload-button`, row);
      const $buttonDownload = $(`${pref}__download-button`, row);
      const $file = $(`${pref}__file`, row);

      $buttonUpload.on('click', () => action(`click: ${pref} button upload`)($file));
      $file.on('change', () => action(`change: ${pref} file`)($buttonDownload, $file, item));
   });

   when(`click: ${pref} button upload`, $file => {
      $file.trigger('click');
   });
   when(`change: ${pref} file`, async ($buttonDownload, $file, item) => {
      const fetchUrl = updateLink;

      const formData = new FormData();
      formData.append('item_id', $(item).find('[colname="value"]')[0].dataset.itemId);
      formData.append('colname', 'value');
      formData.append('value', $file[0].files[0]);

      let res = await fetchJsonOk('Uploading', fetchUrl, {
         method: 'POST',
         body: formData,
      });
      
      $buttonDownload.find('a').attr('href', res.data); // updating link on download button
      $buttonDownload.removeAttr('disabled');
   });
});