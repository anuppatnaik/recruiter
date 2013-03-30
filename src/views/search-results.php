<!--  using templating to paint out search results -->
<script id="template-search-results" type="text/x-tmpl">
    {% if(o.candidates.length) { %}
    <table class="table table-condensed table-hover">
        <thead>
            <tr>
            <th class="span1"><input type="checkbox"></th>
            <th class="span9">People Found</th>
            </tr>
            </thead>
            <tbody>
            {% for (var i=0,candidate; candidate = o.candidates[i]; i++) { %}
                  <tr>
                  <td><input type="checkbox"></td>
                  <td>
                        <a href="{%= getGoogleViewerLink(candidate['fields']['url']) %}" target="_blank">
                            {%= (candidate['fields']['filename']? candidate['fields']['filename'] : (candidate['fields']['file.title']? candidate['fields']['file.title'] : "No Name")) %}
                        </a>
                        <br>
                        <div align="justify">
                              <!-- TBD 2 things
                                    1. Shows only first fragment
                                    2. Does not highlight keywords found
                              -->
                              {%= candidate['highlight']['file'][0] %}
                        </div>
                  </td>
                  </tr>
            {% }  %}
        </tbody>
    </table> 
    {% }  %}
</script>