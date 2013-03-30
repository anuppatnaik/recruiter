              <!--  =======  SEARCH PAGE ======= -->
                <div id="pg-search" style="display:none">
                  <div class="page-header">
                    <h1>Search</h1>
                  </div>
                  <div class="input-append">
                    <div class="span9">
                      <input type="text" name="query" id="search-box" style="width:580px;font-size:16px">
                      <span class="add-on" id="search-icon">
                        <a href="#"><i class="icon-search"></i></a>
                      </span>
                    </div>
                  </div>
                  <div id="search-hlp" style="margin-top:10px;margin-left:20px;padding:1 0 1 0px;background-color:#FFFFCC">
                    <blockquote>
                      Use the box above to enter a free flowing search string including boolean (and, or). Best matched results will be listed right below.
                    </blockquote>
                  </div>
                  <div id="search-results" style="margin-left:20px;">
                     <?php include("views/search-results.php") ?> 
                  </div>
                </div>
  