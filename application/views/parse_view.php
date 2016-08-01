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

        <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/navbar.css') ?>" rel="stylesheet">

        <!-- Core -->
        <script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery-2.2.2.min.js') ?>"></script>
        <!-- Dependency: jquery -->
        <script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>


    </head>
    <body style="margin-bottom: 50px;">

        <div class="container">

            <!-- Static navbar -->
            <nav class="navbar navbar-default" style="margin-bottom: 10px;">
                <div class="container-fluid">
                    <div class="navbar-header">                        
                        <a class="navbar-brand" href="#">#</a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <?php $class = strtolower($this->router->fetch_class()); ?>
                            <li class="<?php echo $class == 'parse' ? 'active' : '' ?>">
                                <a href="<?php echo base_url('parse') ?>">/parse</a>
                            </li>
                            <li class="<?php echo $class == 'parse2' ? 'active' : '' ?>">
                                <a href="<?php echo base_url('parse2') ?>">/parse2</a>
                            </li>
                            <li class="<?php echo $class == 'parse_prod' ? 'active' : '' ?>">
                                <a href="<?php echo base_url('parse_prod') ?>">/parse_prod</a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?php echo base_url('signin/out') ?>">Signout</a></li>
                        </ul>                        
                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>

            <div id="editor" style="height: 500px;"></div>

            <div class="row" style="margin-top: 0px;">
                <div class="col-md-8"></div>
                <div class="col-md-4" style="text-align: right; padding-top: 20px;">
                    <button type="button" class="btn btn-default" data-loading-text="Saving..." id="btnSave">&nbsp;&nbsp;Save&nbsp;&nbsp;</button>
                    <br><br>
                </div>
            </div>
            
            <div id="console" style="height: 150px;"></div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.4/ace.js" type="text/javascript" charset="utf-8"></script>
        <script>
            var editor = ace.edit("editor");
            editor.setTheme("ace/theme/xcode");
            editor.getSession().setMode("ace/mode/javascript");

            var console = ace.edit("console");
            console.setTheme("ace/theme/terminal");
            console.getSession().setMode("ace/mode/text");
            console.setReadOnly(true);
            
            $(document).ready(function () {
                $.post('<?php echo base_url($class . "/get_source") ?>', function (response) {
                    editor.setValue(response);
                });

                $('#btnSave').click(function () {
                    var btn = $(this).button('loading');
                    $.post('<?php echo base_url($class . "/set_source") ?>', editor.getValue(), function (response) {
                        console.setValue(response);
                        btn.button('reset');
                    });
                });
            });
        </script>

    </body>
</html>