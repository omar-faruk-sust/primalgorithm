 <footer class="footer">
      <div class="container">
        <p class="text-muted"></p>
        <div class="pull-right hidden-xs">
            <p class="text-muted">Concordia University</p>
        </div>
      <strong>Copyright &copy;<a href="#">Omar Faruk</a>.</strong> All rights reserved to COMP-6411, 2016.
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/tmpl.js"></script>

    <script type="text/javascript">
      $(function() {
        var inputFile;
        // We can attach the `fileselect` event to all file inputs on the page
        $(document).on('change', ':file', function() {
          var input = $(this),
              numFiles = input.get(0).files ? input.get(0).files.length : 1,
              label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
          input.trigger('fileselect', [numFiles, label]);
        });

        // We can watch for our custom `fileselect` event like this
        $(document).ready( function() {
            var paren;
            var graph;
            var verticesCount = 0;
            var sum = 0;
            // creates a <table> element and a <tbody> element
            var tblBody = document.getElementById("table-body");


            $(':file').on('fileselect', function(event, numFiles, label) {
                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;
                if( input.length ) {
                    input.val(log);
                } else {
                    //if( log ) alert(log);
                }
            });

            // reload the page
            $(".btn-cancel-process").click(function(event) {
                 event.preventDefault();
                 location.reload(true);
                 //window.location.reload(true);
            });

            // ajax call handle
            $("#btn-step-process").on("click", function(event) {
              event.preventDefault();
              var node_no = $("#node_no").val();
              var stepBtnCOunter = $('#step-btn-counter').val();
              stepBtnCOunter++ ;
              $('#step-btn-counter').val(stepBtnCOunter);

              if(stepBtnCOunter > 1 && verticesCount > stepBtnCOunter) {
    
                // if ((graph !== undefined || graph.length > 0) && (paren !== undefined || paren.length > 0) ) {}

                  // creates a table row
                  var row = document.createElement("tr");
                  // the end of the table row
                  var cell1 = document.createElement("td");
                  var temp = stepBtnCOunter;
                  var temp1 = parent[stepBtnCOunter].toString();
                  var text1 = temp1.concat(" - ", temp.toString() );
                  var cellText1 = document.createTextNode(text1);

                  var cell2 = document.createElement("td");
                  var cellText2 = document.createTextNode(graph[stepBtnCOunter][parent[stepBtnCOunter]]);

                  cell1.appendChild(cellText1);
                  cell2.appendChild(cellText2);
                  row.appendChild(cell1);
                  row.appendChild(cell2);

                  sum = parseInt(sum) + parseInt(graph[stepBtnCOunter][parent[stepBtnCOunter]]);

                  // add the row to the end of the table body
                  tblBody.appendChild(row);
                } else if(verticesCount == stepBtnCOunter) {
                  alert("Your process is finished");          
                  $("#first span.sum").text("Total cost of minimum spanning tree is = " + sum.toString());
                }


                if(stepBtnCOunter - 1 == 0) {
                  if(node_no.length == 0)
                  {
                      alert("Please enter the node number");
                      return;
                  }

                  var fd = new FormData();
                  var file_data = $('#fileUpload').prop('files')[0];

                  // now append the data as key value pair 
                  fd.append('node_no', node_no);                
                  fd.append('file', file_data);

                  $.ajax({
                    //dataType: 'json', // to use FormData no need to specify data type
                    url: "ajax.php",
                    type: "POST",
                    data: fd, //<----post here the files and other values
                    processData: false,  // tell jQuery not to process the data
                    contentType: false ,  // tell jQuery not to set contentType
                    cache: false,
                    success: function(data) {
                      $("#output_content").show();
                      var json = $.parseJSON(data);
                      parent = json.parent;
                      graph = json.graph;
                      verticesCount = json.verticesCount;
                      var edeg = verticesCount - 1;
                      $("#vertex-no").text("Total number of node :" + verticesCount);
                      $("#edges-no").text("Total number of edeg :" + edeg);
                      //append the first row in table
                      var row = document.createElement("tr");
                      var cell1 = document.createElement("td");
                      var temp = 1;
                      var temp1 = parent[1].toString();
                      var text1 = temp1.concat(" - ", temp.toString() );
                      var cellText1 = document.createTextNode(text1);

                      var cell2 = document.createElement("td");
                      var cellText2 = document.createTextNode(graph[1][parent[1]]);
                      sum = parseInt(sum) + parseInt(graph[1][parent[1]]);
                      cell1.appendChild(cellText1);
                      cell2.appendChild(cellText2);
                      row.appendChild(cell1);
                      row.appendChild(cell2);
                      tblBody.appendChild(row);
                    },
                    error: function(error) {
                      alert(error);
                    }
                  });
                }

            });
        });
        
      });
    </script>
  </body>
</html>