<script type="text/javascript">
    window.monolith_stack = {
        configs: {
            defaultDispatcher: "{{DEFAULT_DISPATCHER}}",
            omitDefaultRoute: "{{OMIT_DEFAULT_ROUTE}}",
            allowSamePageNavigation: "{{ALLOW_SAME_PAGE_NAV}}",
            baseDir: "{{AP_DIR}}"
        },
        constants: {
            <?php
                $first = true;
                foreach(Configuration::javascriptConstants as $var=>$val){
                    echo $first ? "" : ",\n";
                    echo "$var:";
                    echo is_string($val) ? "\"".$val."\"" : $val;
                $first=false;}
            ?>
        },
        action_queue: [{action:"auto_load",data: "{{PAGE}}"}]
    };
</script>