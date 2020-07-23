<?php
?>
<h4><?php use Vsch\TranslationManager\Manager;

    trans($package . '::messages.search-header', ['count' => $numTranslations]) ?></h4>
<table class="table table-translations">
  <thead>
    <tr>
      <th width="15%"><?php echo trans($package . '::messages.group') ?></th>
      <th width="20%"><?php echo trans($package . '::messages.key') ?></th>
      <th width=" 5%"><?php echo trans($package . '::messages.locale') ?></th>
      <th width="60%"><?php echo trans($package . '::messages.translation') ?></th>
    </tr>
  </thead>
  <tbody>
      <?php 
        $translator = App::make('translator'); 
        foreach ($translations as $t):
            $groupUrl = action($controller . '@getView', $t->group); 
            $isLocaleEnabled = str_contains($userLocales, ',' . $t->locale . ',');
            if ($t->group === Manager::JSON_GROUP && $t->locale === 'json' && $t->value === null || $t->value === '') {
                $t->value = $t->key;
            }
            ?>
        <tr id='<?php echo str_replace('.', '-', $t->key)?>'>
          <td>
            <a href="<?php echo $groupUrl ?>#<?php echo $t->key ?>"><?php echo $t->group ?></a>
          </td>
          <td><?php echo $t->key ?></td>
          <td><?php echo $t->locale ?></td>
          <td>
              <?php echo $isLocaleEnabled ? $translator->inPlaceEditLink($t) : $t->value ?>
          </td>
        </tr>
        <?php endforeach; ?>
  </tbody>
</table>

