$(document).ready(() => {
   const pref = '.item_T_video'; // prefix for current folder
   const updateLink = document.querySelector('table').dataset.updateLink;

   when(`${pref} init`, function (i, row) {
      const item = row;
      const $buttonUpload = $(`${pref}__upload-button`, row);
      const $buttonShow = $(`${pref}__show-button`, row);
      const $thumbnail = $(`${pref}__thumbnail`, row);
      const $file = $(`${pref}__file`, row);

      $buttonShow.on('click', action(`click: ${pref} button show`));
      $buttonUpload.on('click', () => action(`click: ${pref} button upload`)($file));
      $file.on('change', () => action(`change: ${pref} file`)($buttonShow, $file, item, $thumbnail));
      $('.table__order', row).on('pointerdown', action('pointerdown: .table order'));
   });
   $(`${pref}`).each(action(`${pref} init`));

   when(`click: ${pref} button show`, e => {
      $.magnificPopup.open({
         items: {
            src: `
            <div class="item_T_video_popup">
               <video controls="controls" autoplay="autoplay">
                  <source src="${e.target.dataset.mfpSrc}"></source>
               </video>
            </div>`
         },
         verticalFit: true,
         type: 'inline',
      });
   });
   when(`click: ${pref} button upload`, $file => {
      $file.trigger('click');
   });
   when(`change: ${pref} file`, async ($buttonShow, $file, item, $thumbnail) => {
      const fetchUrl = updateLink;

      const formData = new FormData();
      formData.append('item_id', item.dataset.itemId);
      formData.append('colname', 'value');
      formData.append('value', $file[0].files[0]);

      let res = await fetchJsonOk('Uploading', fetchUrl, {
         method: 'POST',
         body: formData,
      });
      
      res.data = res.data + '?' + Date.now(); // add get query to renew browser buffer

      $buttonShow[0].dataset.mfpSrc = res.data;
      $buttonShow.removeAttr('disabled');

      const $thumbnailVideo = $thumbnail.removeClass(`${pref}__thumbnail_free`.slice(1)).find('video').removeClass('dn');
      $thumbnailVideo.find('source').attr('src', res.data);
      $thumbnailVideo[0].load();
   });

   window.item_T_video_handle = function (row) {
      action(`${pref} init`)(0, row);
   };
   when('rowHandle: video', tr => window.item_T_video_handle(tr));
   when('duplicateRow: video', (tr, id, typeName, res) => {
      console.log(res);
      const $source = $('video source', tr);

      let newSrc = `${res.data}?${Date.now()}`;

      $source.attr('src', newSrc);
      $(`${pref}__show-button`, tr).attr('data-mfp-src', newSrc);
   });
});