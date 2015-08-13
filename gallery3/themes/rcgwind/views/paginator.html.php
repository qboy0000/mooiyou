<?php defined("SYSPATH") or die("No direct script access.") ?>
<?
?>

<ul class="g-paginator ui-helper-clearfix">
  <li class="g-first">

  <? if (isset($previous_page_url)): ?>
    <a href="<?= $previous_page_url ?>" class="g-button ui-icon-left ui-state-default ui-corner-all">
      <span class="ui-icon ui-icon-seek-prev"></span><?= t("Previous") ?></a>
  <? else: ?>
    <a class="g-button ui-icon-left ui-state-disabled ui-corner-all">
      <span class="ui-icon ui-icon-seek-prev"></span><?= t("Previous") ?></a>
  <? endif ?>
  </li>

  <li class="g-info">
    <? if ($total): ?>
      <? if ($page_type == "collection"): ?>
        <?= /* @todo This message isn't easily localizable */
            t2("Photo %from_number of %count",
               "Photos %from_number - %to_number of %count",
               $total,
               array("from_number" => $first_visible_position,
                     "to_number" => $last_visible_position,
                     "count" => $total)) ?>
      <? else: ?>
        <?= t("%position of %total", array("position" => $position, "total" => $total)) ?>
      <? endif ?>
    <? else: ?>
      <?= t("No photos") ?>
    <? endif ?>
  </li>

  <li class="g-text-right">
  <? if (isset($next_page_url)): ?>
    <a href="<?= $next_page_url ?>" class="g-button ui-icon-right ui-state-default ui-corner-all">
      <span class="ui-icon ui-icon-seek-next"></span><?= t("Next") ?></a>
  <? else: ?>
    <a class="g-button ui-state-disabled ui-icon-right ui-corner-all">
      <span class="ui-icon ui-icon-seek-next"></span><?= t("Next") ?></a>
  <? endif ?>

<!--   <? if ($page_type == "collection"): ?>
    <? if (isset($last_page_url)): ?>
      <a href="<?= $last_page_url ?>" class="g-button ui-icon-right ui-state-default ui-corner-all">
        <span class="ui-icon ui-icon-seek-end"></span><?= t("Last") ?></a>
    <? else: ?>
      <a class="g-button ui-state-disabled ui-icon-right ui-corner-all">
        <span class="ui-icon ui-icon-seek-end"></span><?= t("Last") ?></a>
    <? endif ?>
  <? endif ?> -->
  </li>
</ul>
