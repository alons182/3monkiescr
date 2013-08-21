<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.3monkiescr
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;



$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$this->language = $doc->language;


$itemid   = $app->input->getCmd('Itemid', '');

// Add JavaScript Frameworks
//JHtml::_('bootstrap.framework');

// Add Stylesheets
$doc->addStyleSheet('templates/'.$this->template.'/css/main.css');
$doc->addStyleSheet('templates/'.$this->template.'/css/normalize.min.css');


?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" >
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
     <link rel="icon" type="image/png" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon_32x32.ico">
	 <link href="http://fonts.googleapis.com/css?family=Lato:100,300,700" rel="stylesheet" type="text/css">
     <link href="http://fonts.googleapis.com/css?family=Pontano+Sans" rel="stylesheet" type="text/css">
     <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
     <?php if ($itemid == 151):?>
            <style type="text/css">
                html {
                    overflow-y: auto;
                }
                .item-page{
                    padding: 20px;
                    margin: 20px 0px 0px 0px;
                    clear: both;
                    width: 600px;
                    position: relative;
                    background-color: rgba(255, 255, 255, 0.9);
                }
            </style>
        <?php endif; ?>

     <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/vendor/modernizr-2.6.2.min.js"></script>
     
     
</head>

<body class="<?php echo ($itemid ? ' bgid-' . $itemid : '')?>">
	
	<div id="wrap">
          
            
            <section id="main">
                <section id="left-container">

                    <div id="menu-top">
                       <jdoc:include type="modules" name="menu-top" style="none" />
                    </div>
                    <div id="reservationbox">
                        <div id="dialog" class="window">
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
                        <jdoc:include type="modules" name="top-contenido" style="none" />
                        <jdoc:include type="component" />
                    </div>
                </section>
                <section id="right-container">
                    <div id="logo">
                        <a href="<?php echo $this->baseurl ?>"><img src="<?php echo $this->baseurl ?>/templates/3monkiescr/img/logo.png" alt="3 Mokies Logo"></a>
                    </div>
                    <nav id="menu">
                        <jdoc:include type="modules" name="menu" style="none" />
                    </nav>
                </section>
            </section>
        </div>
        <footer>
            <div id="bottom">
                <nav id="menu-bottom">
                    <jdoc:include type="modules" name="menu-bottom" style="none" />
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
        <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/vendor/jquery.validate.min.js"></script>
        <script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/vendor/chosen.jquery.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>



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
