<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Mr. Recruiter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Helps you recruit the best">
    <meta name="author" content="JGD. Ventures">

    <!-- Le styles -->
    <link href="lib/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="jQuery-File-Upload/css/style.css">
    <link rel="stylesheet" href="jQuery-File-Upload/css/jquery.fileupload-ui.css">
    <noscript><link rel="stylesheet" href="jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css"></noscript>

    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
    <link href="lib/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="lib/bootstrap/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="lib/bootstrap/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="lib/bootstrap/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="lib/bootstrap/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="lib/bootstrap/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="lib/bootstrap/ico/favicon.png">
  </head>

  <body>
    <div class="container">
      <div class="row">
        <div class="span12">
          <?php include("views/header.php") ?>
          <div class="container">
            <div class="row">
              <div class="span12">
                <?php include("views/home.php") ?>
                <?php include("views/search.php") ?>
                <?php include("views/upload.php") ?>
                <?php include("views/stats.php") ?>
              </div><!--/span-->
            </div><!--/row-->
            <?php include("views/footer.php") ?>
          </div><!--/.fluid-container-->
        </div>
      </div>
    </div>
    <!-- span 12 -->
    <?php include("views/js-includes.php") ?>
  </body>
</html>
