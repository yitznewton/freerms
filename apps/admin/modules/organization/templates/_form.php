<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery("#tab-container > ul").tabs();

  });

  tab_names = new Array();
  tab_names[0] = 'general';
  tab_names[1] = 'ip-ranges';
  tab_names[2] = 'databases';

  function set_tab_state() {
    active_tab = jQuery('#tab-container > ul').data('selected.tabs');
    document.getElementById('tab-state').value = tab_names[active_tab];
  }
</script>

<form action="<?php echo url_for('organization/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="POST" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> onsubmit="set_tab_state();">
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="PUT" />
<?php endif; ?>
  <div>
    <?php echo $form->renderHiddenFields() ?>
    <input type="submit" value="Save" />
    <?php if (!$form->getObject()->isNew()): ?>
    <?php endif; ?>
  </div>

  <div id="tab-container">
    <ul>
      <li class="ui-tabs-nav-item"><a href="#general"><span>General</span></a></li>
      <li class="ui-tabs-nav-item"><a href="#database-vendor"><span>Databases as vendor</span></a></li>
      <li class="ui-tabs-nav-item"><a href="#contacts"><span>Contacts</span></a></li>
      <!-- <li class="ui-tabs-nav-item"><a href="#database-negotiator"><span>Databases as negotiator</span></a></li> -->
    </ul>

    <div id="general">
      <table>
        <tbody>
          <?php echo $form->render() ?>
          <?php /*
          <?php echo $form->renderGlobalErrors() ?>
          <?php echo $form['name']->renderRow() ?>
          <?php echo $form['alt_name']->renderRow() ?>
          <?php echo $form['code']->renderRow() ?>
          <?php echo $form['address']->renderRow() ?>
          <?php echo $form['ezproxy_host']->renderRow() ?>
          <?php echo $form['cost_center_no']->renderRow() ?>
          <?php echo $form['fte']->renderRow() ?>
          <?php echo $form['note']->renderRow() ?>
           *
           */ ?>
        </tbody>
      </table>
    </div>

    <div id="database-vendor">
      <?php if ($eresources_vendor): ?>
      <?php echo "<ul class=\"database-list\">\n" ?>
        <?php foreach ($eresources_vendor as $eresource): ?>
        <?php $id = $eresource->getId() ?>
        <?php echo "<li>" ?>
        <?php echo link_to($eresource->getTitle(), 'database/edit?id='. $id) ?>
        <?php echo '</li>' ?>
        <?php endforeach; ?>
      <?php echo "</ul>\n" ?>
      <?php endif; ?>

    </div>

    <div id="contacts">
      <?php if ($contacts): ?>
        <?php foreach ($contacts as $contact):?>
        <h5>
          <?php echo link_to($contact, 'contact/edit?id='.$contact->getId()) ?>
        </h5>
        <div class="contact-list">
          <?php echo $contact->getRole() ?>
          <?php echo '-' ?>
          <a href="mailto:<?php echo $contact->getEmail()?>" >
            <?php echo $contact->getEmail()?>
          </a>
        </div>
        <?php endforeach ?>
      <?php endif ?>
    </div>
    <!--
    <div id="database-negotiator">
    </div>
    -->
  </div>

  <input type="hidden" id="tab-state" name="tab-state" value="general" />

</form>
