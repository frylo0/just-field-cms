<?php function mailing_page() { ?>
   <?php global $db, $reg; ?>

   <?php $newsletters = $db->at_path('mailing')->get_children(); ?>
   <?php $is_data = count($newsletters) > 1; // 1 for template element ?>

   <?php if ($is_data) : ?>

      <table data-action-link="">
         <thead>
            <tr>
               <td class="tac">ID</td>
               <td>Name</td>
               <td class="w100">Subject</td>
               <td>Inspect</td>
               <td>Send button</td>
            </tr>
         </thead>
         <tbody>

            <?php foreach ($newsletters as $mail) : ?>

               <?php if ($mail->key == '__tpl__') continue; ?>

               <?php $id = $mail->id; ?>
               <?php $name = $mail->name; ?>
               <?php $subject = $mail->at_path('subject')->value; ?>

               <?php $selectors = $mail->at_path('selectors'); ?>
               <?php $receivers = $reg->mailing->selectors_to_emails($selectors); ?>

               <tr>
                  <td class="tac"><?= $id ?></td>
                  <td><?= $name ?></td>
                  <td class="w100"><?= $subject ?></td>
                  <td><a style="color: var(--c2)" href="../field/?path=mailing/<?= $mail->key ?>&curr_path_i=2&view=tree">Open</a></td>
                  <td class="p0">
                     <button class="box p1 box_mode_dark button tac cup brad0 w100" data-receivers="<?= $receivers ?>">
                        Send
                     </button>
                  </td>
               </tr>

            <?php endforeach; ?>

         </tbody>
      </table>

   <?php else : ?>

      <h2 class="tac">No newsletters.</h2>
      <p class="plr1">
         How to add newsletter:
      </p>
      <ol class="pr1">
         <li>Duplicate field with name <strong><code>__tpl__</code></strong> at <code><a href="../field/?view=tree&path=mailing&curr_path_i=1" style="color: var(--c2);"><strong>/mailing</strong></a></code> path.</li>
         <li>Change key, and name to something with sense. <span style="color: red">(!important)</span></li>
         <li>Change newsletter content: subject, message, and selectors.</li>
      </ol>

   <?php endif; ?>

<?php } ?>