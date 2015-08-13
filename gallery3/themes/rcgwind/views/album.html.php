<?php defined("SYSPATH") or die("No direct script access.") ?>
<? // @todo Set hover on AlbumGrid list items for guest users ?>
<div id="g-info">
  <?= $theme->album_top() ?>
  <h1><?= html::purify($item->title) ?></h1>
  <div class="g-description"><?= nl2br(html::purify($item->description)) ?></div>
    <script type="text/javascript">
      $(window).load(function(){      

        $(".slideshow-standard").sliderkit({
          autospeed:3000,
          circular:true,
          fastchange:false
        });
        
        // Slideshow > Carousel
        $(".slideshow-carousel").sliderkit({
          shownavitems:4,
          autospeed:3000,
          mousewheel:true,
          circular:true
        });
        
        var mySliderkit = $(".slideshow-carousel").data('sliderkit');
        $("#slideshow-apibtn").toggle(
          function(){
            mySliderkit.playBtnPause();return false;
          },
          function(){
            mySliderkit.playBtnStart();return false;
          }
        );
        
      });
    </script> 
</div>

<div id="show_page" style="padding-left:100px; display:none">
  <div class="sliderkit slideshow-standard" style="display: block;"> 
    <div class="sliderkit-panels"> 

    <? foreach ($fiveitems as $key => $c): ?>
      <div class="sliderkit-panel" style="display: block;"> 
          <img src="<?= $c->resize_url() ?>" width="500" height="335">
        </div>
    <? endforeach ?>

    </div> 
  </div>
</div>

<ul id="g-album-grid" class="ui-helper-clearfix">
<? if (count($children)): ?>
  <? foreach ($children as $i => $child): ?>
    <? if ($child->is_album()): ?>
      <? $item_class = "g-album"; ?>
    <? elseif ($child->is_movie()): ?>
      <? $item_class = "g-movie"; ?>
    <? else: ?>
      <? $item_class = "g-photo"; ?>
    <? endif ?>
  <li id="g-item-id-<?= $child->id ?>" class="g-item <?= $item_class ?>">
    <?= $theme->thumb_top($child) ?>
    <a href="<?= $child->url() ?>">
      <? if ($child->has_thumb()): ?>
      <?= $child->thumb_img(array("class" => "g-thumbnail")) ?>
      <? endif ?>
    </a>
    <?= $theme->thumb_bottom($child) ?>
    <?= $theme->context_menu($child, "#g-item-id-{$child->id} .g-thumbnail") ?>
    <h2><span class="<?= $item_class ?>"></span>
      <a href="<?= $child->url() ?>"><?= html::purify($child->title) ?></a></h2>
    <ul class="g-metadata">
      <?= $theme->thumb_info($child) ?>
    </ul>
  </li>
  <? endforeach ?>
<? else: ?>
  <? if ($user->admin || access::can("add", $item)): ?>
  <? $addurl = url::site("uploader/index/$item->id") ?>
  <li><?= t("There aren't any photos here yet! <a %attrs>Add some</a>.",
            array("attrs" => html::mark_clean("href=\"$addurl\" class=\"g-dialog-link\""))) ?></li>
  <? else: ?>
  <li><?= t("There aren't any photos here yet!") ?></li>
  <? endif; ?>
<? endif; ?>
</ul>
<?= $theme->album_bottom() ?>

<?= $theme->paginator() ?>
