<script type="text/javascript" src="<?php print S ?><?php print config('cache.js.enabled') && is_file(CACHE . 'app.js') ? 'cache/app.js' : 'js/app.php' ?>"></script>
<script type="text/javascript">
(function($) {
    $(document).ready(function() {
        var $page = $('body');
        var application = new Tc.Application($page);
        application.registerModules();
        application.start();
    });
})(Tc.$);
</script>
