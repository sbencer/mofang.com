<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta content="yes" name="apple-mobile-web-app-capable">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>partition/mobile.base.css" />
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>partition/index.css" />
</head>
<body>
    <div id="scroller" class="page clearfix">
        <ul id="thelist" class="clearfix">
            <?php foreach($lists_info as $_v) { ?>
            <li class="ui-listall clearfix">
                <a class="nbd" href="<?php echo $_v['url']; ?>">
                    <img _src="<?php echo $_v['thumb']; ?>/214x120" width="214" height="120" style="display: block;"/>
                <p class="gong-hd-more"><?php echo $_v['shortname']; ?></p>
                </a>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
    <script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>partition/load.js"></script>
    <script type="text/javascript">
        $(function () {
            scrollLoad.init();
        })
    </script>
</body>
</html>


