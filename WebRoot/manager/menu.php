<?php
if (!isset($_SESSION['Manager'])) {
   // $this->redirect("../../Logins");
    print_r($_SESSION);
} else {
    //echo (session_cache_expire());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="zh-CN" lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php
        $jquery_ui = "../jquery-ui";
        $bundle = $jquery_ui . "/development-bundle";
        print "<link rel='stylesheet' href='$bundle/themes/base/jquery.ui.all.css'>";
        print "<script type='text/javascript' src='$jquery_ui/js/jquery-1.9.1.js'></script>";
        print "<script type='text/javascript' src='$jquery_ui/js/jquery-ui-1.10.1.custom.js'></script>";
        print "<script src='$bundle/ui/jquery.ui.position.js'></script>";
        print "<script src='$bundle/ui/jquery.ui.core.js'></script>";
        print "<script src='$bundle/ui/jquery.ui.widget.js'></script>";
        print "<script src='$bundle/ui/jquery.ui.button.js'></script>";
        print "<script src='$bundle/ui/jquery.ui.tabs.js'></script>";
        print "<link rel='stylesheet' href='$bundle/demos/demos.css'>";
        ?>
        <script>
            $(document).ready(function(event){
                $('#logout').click(function(){
                    parent.window.location.href = "../../Logins/exitSystem";
                    return false;
                });
                $('a.ksmChild').click(function(event){
                    event.preventDefault();
                    parent.tabs.jquery_addTab($(this).attr("href"), $(this).children(".ksmIn").text());
                });
                $("#add").click(function (){
                    callMain();
                })
            });
        </script>
    </head>
    <body>

        <?php
        $KoolControlsFolder = "../../KoolPHPSuite/KoolControls";
        require $KoolControlsFolder . "/KoolSlideMenu/koolslidemenu.php";
        
//$ksm->slidingSpeed = 6;
//$ksm->width="270px";
//About us

        $xmlDoc = new DOMDocument();
        $xmlDoc->load("menu.xml");

        $ksm = new KoolSlideMenu("ksm");
        $ksm->loadXML($xmlDoc->saveXML());
        $ksm->scriptFolder = $KoolControlsFolder . "/KoolSlideMenu";
        $ksm->styleFolder = $KoolControlsFolder . "KoolSlideMenu/styles/bluearrow";
        
        ?>
        <form id="form1" method="post">
            <?php echo $ksm->Render(); ?>
        </form>
<!--                    <script type="text/javascript">
                        function OnParentMouseOver_handle(sender,arg)
                        {
                            ksm.getItem(arg.ItemId).expand();
                        }	
                        // Register for OnParentMouseOver event
                        ksm.registerEvent("OnParentMouseOver",OnParentMouseOver_handle);	
                    </script>-->
            
    </body>
</html>
