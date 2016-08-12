<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/favicon-32x32.png') ?>">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Cloudcode</title>

        <!-- Core -->
        <script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery-2.2.2.min.js') ?>"></script>

        <script>
            function load_viewlog() {
                $.post('<?php echo base_url("viewlog/stream/" . $class) ?>', function (response) {
                    document.body.innerHTML = '<pre>' + response + '</pre>';
                    window.scrollTo(0,document.body.scrollHeight);
                    setTimeout(load_viewlog, 4000)
                });
            }
            
            $(document).ready(function () {
                load_viewlog();
            });
        </script>

    </head>
    <body style="margin: 0; padding: 0; background-color: black; color: white;">
    </body>
</html>