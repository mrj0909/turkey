<link href="<?php echo theme_url();?>/assets/css/style_listings.css" rel="stylesheet">
<!-- Page heading two starts -->
<div class="page-heading-two">
    <div class="container">
        <h2><?php echo $title =$magazine_data->title?> <?php echo $magazine_data->month?> - <?php echo $magazine_data->year?></h2>
        <div class="breads">
            <a href="<?php echo site_url(); ?>"><?php echo lang_key('home'); ?></a> / 
            <a href="<?php echo site_url('emagazine'); ?>"><?php echo lang_key('emagazine'); ?></a> / 
			<?php echo $title?> <?php echo $magazine_data->month?> - <?php echo $magazine_data->year?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Container -->
<div class="container">
    <div class="row">
        <div class="col-md-9 col-sm-12 col-xs-12">
        <div class="mDetail">
<div class="mPictureBox">
<?php $images = json_decode($magazine_data->gallery);?>
<img id="image" src="<?php echo get_thumbs_image($magazine_data->featured_img)?>" alt="<?php echo $title?>" style="display: block; margin: 0px auto;" width="298" title="<?php echo $title?>">
<?php if(count($images)>0){?>
	<ul class="gallery">
		<?php for($img=0;$img<count($images);$img++){?>
        <li>
		<div class="mtop">
			<a href="#" title="Read">
			<img src="<?php echo get_gallery_image($images[$img])?>" width="84" height="100"/>
			</a>
		</div>
		</li>
        <?php }?>
     </ul>
<?php }?>
</div>


<div class="mContent">
<h1><?php echo $title?> <?php echo $magazine_data->month?> - <?php echo $magazine_data->year?></h1>

			<!-- AddThis Button BEGIN -->
								<!-- Go to www.addthis.com/dashboard to customize your tools -->
				<table>
				<tr>
					<td>
				<div style="display:inline" class="addthis_native_toolbox"></div>
				</td>
					<td>
				<a style="display:inline" href="http://www.pinterest.com/pin/create/button/?url=http%3A%2F%2Fwww.magzter.com%2FCA%2FDolce-Media%2FCity-Life-Magazine%2FBusiness&media=http%3A%2F%2Fcdn.magzter.com%2F1417545595%2F1439212736%2Fimages%2Fthumb%2F390_thumb_1.jpg&description=Get+your+digital+edition+of+City+Life+Magazine+Magazine+subscriptions+and+issues+online+from+Magzter.+Buy%2C+download+and+read+City+Life+Magazine+Magazine+on+your+iPad%2C+iPhone%2C+Android%2C+Tablets%2C+Kindle+Fire%2C+Windows+8%2C+Web%2C+Mac+and+PCs+only+from+Magzter+-+The+Digital+Newsstand." data-pin-do="buttonPin" data-pin-config="beside"><img src="https://d1wofkmqsniyp0.cloudfront.net/public/v2.0/imgs/pinit.png" /></a>&nbsp;&nbsp;&nbsp;
			</td>
				
			</tr></table>
			<p></p>
				<!-- AddThis Button END -->
	
	<div class="cFl">
	CATEGORY:  <?php echo get_category_title_by_id($magazine_data->category)?><br>
	FREQUENCY: <?php echo $magazine_data->magazine_frequency?><br>
	LANGUAGE:  <?php echo $magazine_data->magazine_language?>  <br></div>
	<h5>Magazine Description</h5>
	<p><?php echo $magazine_data->description?></p>
    <h5>Issue Description</h5>
	<p><?php echo $magazine_data->description?></p>
	<a href="<?php echo $magazine_data->mac?>">
    <img src="<?php echo theme_url();?>/assets/img/mac-icon.png" width="63" />
    </a>
    <a href="<?php echo $magazine_data->android?>">
    <img src="<?php echo theme_url();?>/assets/img/android-icon.png" width="63" />
    </a>
    <a href="<?php echo $magazine_data->window?>">
    <img src="<?php echo theme_url();?>/assets/img/win8-icon.png" width="63" />
    </a>
    <img src="<?php echo get_thumbs_image($magazine_data->qr)?>" width="63" /> <br>
	<a href="<?php echo $magazine_data->url?>" class="dRead" target="_blank">READ MORE</a>
</div>
<div class="clear"></div>
<div class="magazine">
         <h2>Back Issues</h2>
    <?php 
	     if(count($back)>0){
			 echo "<ul>";
		 foreach($back as $magazine)
	     {
			 $detail_link = site_url('emagazine_details/'.$magazine->mag_id);
	?>
		 <li>
            <div class="mtop">
                <a href="<?php echo $detail_link?>" title="Read">
              	  <img src="<?php echo get_thumbs_image($magazine->featured_img);?>" width="193" height="231"/>
                </a>
            </div>
            <div class="cellOS"><?php echo $magazine->name?><br /><?php echo $magazine->year?>/<?php echo $magazine->month?></div>
            <a class="mname" href="<?php echo $magazine->url?>" title="Read"><img src="<?php echo theme_url();?>/assets/img/icopreview.jpg" /></a>
            <a class="mname" href="<?php echo $detail_link?>" title="Detail"><img src="<?php echo theme_url();?>/assets/img/icoread.jpg" /></a>
        </li>
        <?php
		 } 
		  echo "</ul>"; 
		 }
		 else
		 {?>
           <div>No Magazines were found</div>
		<?php }?>
    </div>

  <div class="clear"></div>
         <div class="magazine">
         <h2>Featured Magazines</h2>
    <?php 
	     if(count($featured)>0){
			 echo "<ul>";
		 foreach($featured as $magazine)
	     {
			 $detail_link = site_url('emagazine_details/'.$magazine->id);
	?>
        <li>
            <div class="mtop">
                <a href="<?php echo $detail_link?>" title="Read">
              	  <img src="<?php echo get_thumbs_image($magazine->featured_img);?>" width="193" height="231"/>
                </a>
            </div>
            <div class="cellOS"><?php echo $magazine->name?><br /><?php echo $magazine->year?>/<?php echo $magazine->month?></div>
            <a class="mname" href="<?php echo $magazine->url?>" title="Read"><img src="<?php echo theme_url();?>/assets/img/icopreview.jpg" /></a>
            <a class="mname" href="<?php echo $detail_link?>" title="Detail"><img src="<?php echo theme_url();?>/assets/img/icoread.jpg" /></a>
        </li>
        <?php
		 } 
		  echo "</ul>"; 
		 }
		 else
		 {?>
           <div>No Magazines were found</div>
		<?php }?>
    </div>
	</div>
    <div class="clear"></div>
		<?php render_widgets('footeremagazine');?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="sidebar">
                <?php render_widgets('RightBarEmagazines');?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55d3aa799154da71" async="async"></script>