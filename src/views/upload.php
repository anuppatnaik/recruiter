              <!-- =======  UPLOAD PAGE ======= -->
                <div id="pg-upload" style="display:none;">
                  <div class="page-header">
                    <h1>Upload</h1>
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
  