<?php /* Template Name: cars */ ?>


<?
include_once(ABSPATH . 'Grab/Page.php');

$isOneCar = isset($_GET['car'])?$_GET['car']:NULL;



if ($isOneCar) {

  include_once(ABSPATH . 'Grab/Car.php');

  $page    = new Grab\Car($_GET['car']);
  $page->load();
  $contact = $page->get_contact();


}
else {

  if (isset($_POST)) {
    foreach ($_POST as $k=>$v) {
      if (!empty(trim($v)) && ($k == 'sort' | $k == 'q'))
      $query .= "&".$k."=".trim($v);
    }
  }
  

  //  anyway make page
  $page   = new Grab\Page($query);
  $page->load();

  $select = $page->get_select();
  $list   = $page->get_list();
}

?>

<?php
global $avia_config;

/*
* get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
*/
get_header();

$title = __('Blog - Latest News', 'avia_framework'); //default blog title
$t_link= home_url('/');
$t_sub = "";

if (avia_get_option('frontpage') && $new = avia_get_option('blogpage')) {
  $title = get_the_title($new); //if the blog is attached to a page use this title
  $t_link= get_permalink($new);
  $t_sub = avia_post_meta($new, 'subtitle');
}

if ( get_post_meta(get_the_ID(), 'header', true) != 'no') echo avia_title(array('heading' =>'strong','title'   => $title,'link'    => $t_link,'subtitle'=> $t_sub));

?>
<div class="overflow" style="display: none;" >
  <h1>
    Please Wait
  </h1>
</div>

<div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>

  <div class='container template-blog template-single-blog '>

    <main class='content units <?php avia_layout_class( 'content' ); ?> <?php echo avia_blog_class_string(); ?>' <?php avia_markup_helper(array('context'  => 'content','post_type'=>'post'));?>>
	 <? if (!$isOneCar):?>
      <form method="post" action="" id="form_filter">
        <div class="entry-content-wrapper clearfix"  >


          <? if (isset($_POST['q']) && !empty($_POST['q'])) :?>
          <h1>
            Søk : <?= $_POST['q'] ?>
          </h1>
          <br />
          <a href="" onclick="location.reload()"   >
            Reset
          </a>
          <br /><br /><br />
          <? endif;?>

          <div class="flex_column av_one_third first  avia-builder-el-0  el_before_av_two_third  avia-builder-el-first  " >
            <label>
              Sortering
            </label>
            <select id="sort" name="sort">
              <?
              foreach ($select as $option): ?>
              <?= $option ?>
              <? endforeach ;?>
            </select>
          </div>

          <div class="flex_column av_two_third   avia-builder-el-2  el_after_av_one_third  avia-builder-el-last  ">
            <section class="av_textblock_section" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
              <div class="avia_textblock " itemprop="text">
                <label>
                  <?= count($list) ?>  treff
                </label>
                <input  value="<?= isset($_POST['q'])?$_POST['q']:NULL?>"   type="search" name="q" id="q" placeholder="Søk" style="width: 100%;"/>

              </div>
            </section>
          </div>
        </div>
      </form>
	      <? if (count($list) > 0 ):?>
	      																									<div class="entry-content-wrapper clearfix">
        <?
        foreach ($list as $row):?>


        <div class="car_row"   onclick="location.replace('<?= $page->link_to_car($row['url']) ?>')"    id="<?= $row['url']?>">
      
          <div class="flex_column av_one_third first  avia-builder-el-0  el_before_av_two_third  avia-builder-el-first  ">
            <span class="avia-image-container" itemscope="itemscope" itemtype="http://schema.org/ImageObject">
              <img class="avia_image  avia-builder-el-1  avia-builder-el-no-sibling  avia-align-center  " src="<?= $row['img']?>" alt="<?= $row['title']?>" title="<?= $row['title']?>" itemprop="contentURL">
            </span>
          </div>
          <div class="flex_column av_two_third   avia-builder-el-2  el_after_av_one_third  avia-builder-el-last  ">
            <section class="av_textblock_section" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
              <div class="avia_textblock " itemprop="text">
                <h6>
                  <?= $row['title']?>
                </h6>
                <br />
                <ul style="line-height: 15px;">
                  <li>
                    <?= $row['year']?>
                  </li>
                  <li>
                    <?= $row['distance']?>
                  </li>
                  <li>
                    <?= $row['price']?>
                  </li>
                </ul>

                <b>
                  <?= $row['desc']?>
                </b>


              </div>
            </section>
          </div>
        </div>

        <? endforeach ;?>
      </div>
	      <? endif;?>
      
      <? else:?>
      <div class="flex_column av_one_full first  avia-builder-el-0  el_before_av_promobox  avia-builder-el-first  ">

<a href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Tilbake</a>

        <div  class="av_promobox avia-button-yes  avia-builder-el-4  el_after_av_one_full  avia-builder-el-last  ">
          <div class="avia-promocontent">
            <h3>
              Vi har et aktuelt prosjekt, kontakt oss!

            </h3>
          </div>
          <div class="avia-button-wrap avia-button-right ">
            <a href="<?= $page->get_button_url() ?>" class="avia-button avia-icon_select-yes avia-color-orange avia-size-large avia-position-right " target="_blank">
              <span class="avia_button_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello">
              </span>
              <span class="avia_iconbox_title">
                Send melding
              </span>
            </a>
          </div>
        </div>

        <!---->
        <?
        $imgs = $page->get_all_images();
        if ($imgs):?>

        <div class="avia-gallery avia-gallery-1 avia_lazyload avia_animate_when_visible  avia-builder-el-0  avia-builder-el-no-sibling  avia_start_animation" itemscope="itemscope" itemtype="http://schema.org/ImageObject">
          <a class="avia-gallery-big fakeLightbox avianolink noLightbox avia-gallery-big-no-crop-thumb " href="<?= $imgs[0] ?>" data-onclick="1" title="here" style="height: auto; opacity: 1;">
            <span class="avia-gallery-big-inner" itemprop="contentURL">
              <img src="<?= $imgs[0] ?>" style="height: auto; width: 100%;">
            </span>
          </a>
          <div class="avia-gallery-thumb">
            <?
            foreach ( $imgs  as $value ): ?>


            <a href="<?= $value ?>" data-rel="gallery-1" data-prev-img="<?= $value ?>" class="first_thumb avianolink noLightbox " data-onclick="1" title="" itemprop="contentURL">
              <img src="<?= $value ?>"  title="resepsjon" alt="" class="avia_start_animation">
            </a>
            <? endforeach;?>
          </div>
        </div>


        <? endif; ?>
        <!---->

        <div class="avia-icon-list-container  avia-builder-el-2  el_after_av_gallery  el_before_av_textblock ">
          <ul class="avia-icon-list avia-icon-list-left avia_animate_when_almost_visible">
            <li>
              <div class="iconlist_icon avia-font-entypo-fontello">
                <span class="iconlist-char" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello">
                </span>
              </div>
              <article class="article-icon-entry" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
                <div class="iconlist_content_wrap">
                  <header class="entry-content-header">
                    <h4 class="iconlist_title" itemprop="headline">
                      Contact person
                    </h4>
                  </header>
                  <div class="iconlist_content" itemprop="text">
                    <p>
                      <?= $contact['person']?>
                    </p>
                  </div>
                </div>
                <footer class="entry-footer">
                </footer>
              </article>
              <div class="iconlist-timeline">
              </div>
            </li>
            <li>
              <div class="iconlist_icon avia-font-entypo-fontello">
                <span class="iconlist-char" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello">
                </span>
              </div>
              <article class="article-icon-entry" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
                <div class="iconlist_content_wrap">
                  <header class="entry-content-header">
                    <h4 class="iconlist_title" itemprop="headline">
                      Telefon
                    </h4>
                  </header>
                  <div class="iconlist_content" itemprop="text">
                    <p>
                      <?= $contact['phone']?>
                    </p>
                  </div>
                </div>
                <footer class="entry-footer">
                </footer>
              </article>
              <div class="iconlist-timeline">
              </div>
            </li>
          </ul>
        </div>
        <section class="av_textblock_section" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
          <div class="avia_textblock " itemprop="text">
            <?= $page->get_body()?>
          </div>
        </section>

      </div>
      <? endif;?>

    </main>


    <?php

    //get the sidebar
    $avia_config['currently_viewing'] = 'page';

    get_sidebar();

    ?>


  </div><!--end container-->

</div><!-- close default .container_wrap element -->


<?php get_footer(); ?>



<?
if (isset($select)) :?>
<script>
  document.getElementById("sort").onchange = function(){
    sendForm();
  }
  document.getElementById("q").onchange = function(){
    if(this.value.length > 3){
      sendForm();
    }


  }
  function sendForm(){
    document.querySelector(".overflow").removeAttribute("style");
    document.getElementById("form_filter").submit();
  }
</script>
<? endif;?>

<style>
  .car_row{
    margin-bottom: 20px;
    float: left;
  }
  .car_row:hover{
    opacity: 0.7;
    cursor: pointer;
  }
  .overflow{
    position: fixed;
    z-index: 999;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,.5);
  }
  .overflow h1{
    color: white;
    text-align: center;
    margin-top: 20%;
    font-size: 34px;
  }
  .avia-gallery-big-inner img{
    width: 100% !important;
    height: auto !important;
  }
  
  .work_date td ,.work_date th{
  	color: #aaaaaa !important;
  }

</style>