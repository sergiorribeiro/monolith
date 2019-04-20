<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1"/>
        <link rel="shortcut icon" href="{{AP_DIR}}/assets/icons/favicon.ico">
        <link rel="icon" href="{{AP_DIR}}/assets/icons/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="{{AP_DIR}}/assets/styles/style.css">
        <?php wrapperInjection("head") ?>
    </head>
    <body>
        <?php wrapperInjection("body") ?>
        <script type="text/javascript" src="{{AP_DIR}}/wrapper/wrapper.js"></script>
        <?php wrapperInjection("scriptpack") ?>
    </body>
</html>