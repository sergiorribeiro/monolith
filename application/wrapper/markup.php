<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1"/>
        <link rel="shortcut icon" href="/application/assets/icons/favicon.ico">
        <link rel="icon" href="/application/assets/icons/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="/application/assets/styles/style.css">
        <script type="text/javascript">
            window.monolith_stack = {
                configs: {
                    defaultPage: "{{DEFAULT_PAGE}}",
                    omitDefaultRoute: "{{OMIT_DEFAULT_ROUTE}}",
                    allowSamePageNavigation: "{{ALLOW_SAME_PAGE_NAV}}"
                },
                action_queue: [{action:"auto_load",data: "{{PAGE}}"}]
            };
        </script>
    </head>
    <body>
        <monolith-event-emitter></monolith-event-emitter>
        <monolith-stage data-relevance="buffer"></monolith-stage>
        <monolith-stage data-relevance="stage"></monolith-stage>
        <monolith-preload-curtain></monolith-preload-curtain>
        
        <script type="text/javascript" src="/foundations/monolith.js"></script>
        <script type="text/javascript" src="/application/wrapper/scripts/main.js"></script>

        <script type="text/javascript">{{SCRIPTPACK}}</script>
    </body>
</html>