<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$this->language = $doc->language;


$itemid   = $app->input->getCmd('Itemid', '');

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" >
<head>
	<title><?php echo $this->title; ?> <?php echo $this->error->getMessage();?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="icon" type="image/png" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon_32x32.ico">
	 <link href="http://fonts.googleapis.com/css?family=Lato:100,300,700" rel="stylesheet" type="text/css">
     <link href="http://fonts.googleapis.com/css?family=Pontano+Sans" rel="stylesheet" type="text/css">
     <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/normalize.min.css" type="text/css" />
     <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/main.css" type="text/css" />

	
</head>
<body class="<?php echo ($itemid ? ' bgid-' . $itemid : '')?>">
	
	<div id="wrap">
          
            
            <section id="main">
                <section id="left-container">

                    <div id="menu-top">
                      
                        <?php if (JModuleHelper::getModule('menu-top')) : ?>
                        <?php
										$mt = JModuleHelper::getModule('menu-top');
										echo JModuleHelper::renderModule($mt);
									?>
						<?php endif; ?>
                    </div>
                    <div id="reservationbox">
                        <div id="dialog" class="window">
                        	<?php if (JModuleHelper::getModule('reservation-box')) : ?>
                        <?php
										$rb = JModuleHelper::getModule('reservation-box');
										echo JModuleHelper::renderModule($rb);
									?>
						<?php endif; ?>
                            <jdoc:include type="modules" name="reservation-box" style="none" />
                        </div>
                    </div>
                    <div id="callbox">
                        <div id="dialogC" class="window">
                            <jdoc:include type="modules" name="call-box" style="none" />
                        </div>
                    </div>
                    <div id="contactbox">
                        <div id="dialogT" class="window">
                            <jdoc:include type="modules" name="contact-box" style="none" />
                        </div>
                    </div>
                    <div id="contenido">
                       <div class="text404">
                       		<h1 class="page-header"><?php echo JText::_('JERROR_LAYOUT_PAGE_NOT_FOUND'); ?></h1>
								<div class="well">
								<div class="row-fluid">
									<div class="span6">
										<p><strong><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></strong></p>
										<p><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></p>
										<ul>
											<li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
											<li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
											<li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
											<li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
										</ul>
									</div>
									<div class="span6">
										<?php if (JModuleHelper::getModule('search')) : ?>
											<p><strong><?php echo JText::_('JERROR_LAYOUT_SEARCH'); ?></strong></p>
											<p><?php echo JText::_('JERROR_LAYOUT_SEARCH_PAGE'); ?></p>
											<?php
												$module = JModuleHelper::getModule('search');
												echo JModuleHelper::renderModule($module);
											?>
										<?php endif; ?>
										<p><?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?></p>
										<p><a href="<?php echo $this->baseurl; ?>/index.php" class="btn"><i class="icon-home"></i> <?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a></p>
									</div>
								</div>
								<hr />
								<p><?php echo JText::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></p>
								<blockquote>
									<span class="label label-inverse"><?php echo $this->error->getCode(); ?></span> <?php echo $this->error->getMessage();?>
								</blockquote>
							</div>

                       </div>
                        
                    </div>
                </section>
                <section id="right-container">
                    <div id="logo">
                    <a href="<?php echo $this->baseurl ?>"><div id="contenedor_legenda"></div><div id="legenda"></div>

                     <div id="mascara"></div>
                     <div id="logo_animado">
                         <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="210" height="130" id="Logo animado 3Monkies" align="middle">
                        <param name="movie" value="<?php echo $this->baseurl ?>/templates/3monkiescr/img/logo.swf" />
                        <param name="quality" value="high" />
                        <param name="bgcolor" value="#ffffff" />
                        <param name="play" value="true" />
                        <param name="loop" value="true" />
                        <param name="wmode" value="transparent" />
                        <param name="scale" value="showall" />
                        <param name="menu" value="true" />
                        <param name="devicefont" value="false" />
                        <param name="salign" value="" />
                        <param name="allowScriptAccess" value="sameDomain" />
                        <!--[if !IE]>-->
                        <object type="application/x-shockwave-flash" data="<?php echo $this->baseurl ?>/templates/3monkiescr/img/logo.swf" width="210" height="130">
                            <param name="movie" value="<?php echo $this->baseurl ?>/templates/3monkiescr/img/logo.swf" />
                            <param name="quality" value="high" />
                            <param name="bgcolor" value="#ffffff" />
                            <param name="play" value="true" />
                            <param name="loop" value="true" />
                            <param name="wmode" value="transparent" />
                            <param name="scale" value="showall" />
                            <param name="menu" value="true" />
                            <param name="devicefont" value="false" />
                            <param name="salign" value="" />
                            <param name="allowScriptAccess" value="sameDomain" />
                        <!--<![endif]-->
                            <a href="http://www.adobe.com/go/getflash">
                                <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
                            </a>
                        <!--[if !IE]>-->
                        </object>
                        <!--<![endif]-->
                    </object>
                     </div>   
                        
                    </a>
                        
                        
                    </div>
                    <nav id="menu">
                        <?php if (JModuleHelper::getModule('menu')) : ?>
                        <?php
										$module = JModuleHelper::getModule('menu');
										echo JModuleHelper::renderModule($module);
									?>
						<?php endif; ?>
                    </nav>
                </section>
            </section>
        </div>
        <footer>
            <div id="bottom">
                <nav id="menu-bottom">
                    
                     <?php if (JModuleHelper::getModule('menu-bottom')) : ?>
                        <?php
										$module = JModuleHelper::getModule('menu-bottom');
										echo JModuleHelper::renderModule($module);
									?>
						<?php endif; ?>
                </nav>
                <div id="redes">
                    <jdoc:include type="modules" name="redes" style="none" />
                </div>
                <div id="patners">
                    <jdoc:include type="modules" name="patners" style="none" />
                </div>
                <div id="copyright">
                    <a href="http://www.avotz.com" target="_blank">Copyright &copy; 2013 | Avotz</a >
                </div>
            </div>
        </footer>

      
        
        <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/vendor/jquery-1.10.1.min.js"></script>

        <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/main.js"></script>

        <script>
            /*var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));*/
        </script>

	<jdoc:include type="modules" name="debug" style="none" />
</body>

</html>
