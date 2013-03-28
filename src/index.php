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

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="/">Mr. Recruiter!</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as <a href="#" class="navbar-link">Superuser</a>
            </p>
            <ul class="nav">
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Help</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">What do you want to do?</li>
              <li><a href="#dashboard">Dashboard</a></li>
              <li><a href="#search">Find &amp; View</a></li>
              <li><a href="#upload">Upload &amp; Index</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
          <!--  about pg -->
          <div id="pg-about" align="justify">
           <div class="page-header">
              <h1>Lets get started!</h1>
            </div>
              <strong>Mr. Recruiter</strong> will help you hire the best people around. Use the menu on the left to do different things. In <strong>Find &amp; View</strong> you can search through every word in every resume and view candidate details. In <strong>Upload &amp; Index</strong> you can drag and drop resume to add them to the database. And the best part, all this runs off the cloud. Meaning, accessible by whole of your team from anywhere anytime. Do checkout some interesting analytics on the <strong>Dashboard</strong>.  
          </div>          
          <!--  dashboard pg -->
          <div id="pg-dashboard" style="display:none">
           <div class="page-header">
              <h1>Dashboard</h1>
            </div>
            <blockquote>
              This place will contain interesting analytics.
            </blockquote>
          </div>
          <!--  upload pg -->
          <div id="pg-upload" style="display:none;">
            <div class="page-header">
              <h1>Upload &amp; Index Resumes</h1>
            </div>
            <blockquote>
              Drag &amp; drop resume files (only doc, docx & pdf) here to upload them and index into the resume database. Indexing is the process by which every single word in the resume text is made available for you to search. 
            </blockquote>
            <!-- upload form -->
            <div>
                <!-- The file upload form used as target for the file upload widget -->
                <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
                    <!-- Redirect browsers with JavaScript disabled to the origin page -->
                    <noscript><input type="hidden" name="redirect" value=""></noscript>
                    <!-- The loading indicator is shown during file processing -->
                    <div class="fileupload-loading"></div>
                    <br>
                    <!-- The table listing the files available for upload/download -->
                    <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
                </form>
            </div>
            <!-- The template to display files available for upload -->
            <script id="template-upload" type="text/x-tmpl">
            {% for (var i=0, file; file=o.files[i]; i++) { %}
                <tr class="template-upload fade">
                    <td class="preview"><span class="fade"></span></td>
                    <td class="name"><span>{%=file.name%}</span></td>
                    <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                    {% if (file.error) { %}
                        <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
                    {% } else if (o.files.valid && !i) { %}
                        <td>
                            <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
                        </td>
                        <td>{% if (!o.options.autoUpload) { %}
                            <button class="btn btn-primary start">
                                <i class="icon-upload icon-white"></i>
                                <span>Start</span>
                            </button>
                        {% } %}</td>
                    {% } else { %}
                        <td colspan="2"></td>
                    {% } %}
                    <td>{% if (!i) { %}
                        <button class="btn btn-warning cancel">
                            <i class="icon-ban-circle icon-white"></i>
                            <span>Cancel</span>
                        </button>
                    {% } %}</td>
                </tr>
            {% } %}
            </script>
            <!-- The template to display files available for download -->
            <script id="template-download" type="text/x-tmpl">
            {% for (var i=0, file; file=o.files[i]; i++) { %}
                <tr class="template-download fade">
                    {% if (file.error) { %}
                        <td></td>
                        <td class="name"><span>{%=file.name%}</span></td>
                        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                        <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
                    {% } else { %}
                        <td class="preview">{% if (file.thumbnail_url) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
                        {% } %}</td>
                        <td class="name">
                            <a href="{%= getGoogleViewerLink(file.url) %}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}" target="_blank">{%=file.name%}</a>
                        </td>
                        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                        <td colspan="2"></td>
                    {% } %}
                    <td>
                        &nbsp;
                        <!-- removing delete button. 
                        <button class="btn btn-danger delete" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                            <i class="icon-trash icon-white"></i>
                            <span>Delete</span>
                        </button>
                        <input type="checkbox" name="delete" value="1" class="toggle">
                        -->
                    </td>
                </tr>
            {% } %}
            </script>            
          </div>
          <!--  search pg -->
          <div id="pg-search" style="display:none">
            <div class="page-header">
              <h1>Find &amp; View Resumes</h1>
            </div>
            <blockquote>
              Use the box below to enter a free flowing search string including boolean (and, or). Best matched results will be listed right below.
            </blockquote>
          </div>
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; J.G.D Ventures 2013</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="lib/jquery/jquery-1.9.1.min.js"></script>
    <script src="lib/jquery/jquery.ui.widget.js"></script>
    <script src="http://blueimp.github.com/JavaScript-Templates/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="http://blueimp.github.com/JavaScript-Canvas-to-Blob/canvas-to-blob.min.js"></script>
    <!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="http://blueimp.github.com/Bootstrap-Image-Gallery/js/bootstrap-image-gallery.min.js"></script>
    <!-- DO NOT MESS WITH THE ORDER OF INCLUSION of below files -->
    <script src="jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
    <script src="jQuery-File-Upload/js/jquery.fileupload.js"></script>
    <script src="jQuery-File-Upload/js/jquery.fileupload-fp.js"></script>
    <script src="jQuery-File-Upload/js/jquery.fileupload-ui.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
