$(document).ready(() => {
   const pref = '.item_T_audio'; // prefix for current folder
   const updateLink = document.querySelector('table').dataset.updateLink;

   when(`${pref} init`, function (i, row) {
      const item = row;
      const $buttonUpload = $(`${pref}__upload-button`, row);
      const $player = $(`audio`, row);
      const $file = $(`${pref}__file`, row);

      $buttonUpload.on('click', () => action(`click: ${pref} button upload`)($file));
      $file.on('change', () => action(`change: ${pref} file`)($player, $file, item));
      $(`${pref} .table__order`, row).on('pointerdown', action(`pointerdown: .table order`));
   });
   $(`${pref}`).each(action(`${pref} init`));

   when(`click: ${pref} button upload`, $file => {
      $file.trigger('click');
   });
   when(`change: ${pref} file`, async ($player, $file, item) => {
      const fetchUrl = updateLink;

      const formData = new FormData();
      formData.append('item_id', item.dataset.itemId);
      formData.append('colname', 'value');
      formData.append('value', $file[0].files[0]);

      let res = await fetchJsonOk('Uploading', fetchUrl, {
         method: 'POST',
         body: formData,
      });
     
      $player.find('source').attr('src', res.data + '?' + Date.now()); // updating link on download button
      $player[0].load();
   });

   window.item_T_audio_handle = function (row) {
      action(`${pref} init`)(0, row);
   };
   when('rowHandle: audio', tr => window.item_T_audio_handle(tr));
});