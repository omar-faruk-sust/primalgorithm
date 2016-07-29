 <footer class="footer">
      <div class="container">
        <p class="text-muted"></p>
        <div class="pull-right hidden-xs">
            <p class="text-muted">Concordia University</p>
        </div>
      <strong>Copyright &copy;<a href="#">MST</a>.</strong> All rights reserved to COMP-6411, 2016.
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

            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;
                      console.log(log);
                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }

            });

            // reload the page
            $(".btn-cancel-process").click(function(event) {
                 event.preventDefault();
                 console.log("Refresh");
                 location.reload(true);
                 //window.location.reload(true);
            });

            // ajax call handle
            $("#btn-step-process").on("click", function(event) {
              event.preventDefault();
              var node_no = $("#node_no").val();

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

              console.log(fd);
              $("#output_content").show();

              $.ajax({
                //dataType: 'json',
                url: "second.php",
                type: "POST",
                data: fd, //<----post here the files and other values
                processData: false,  // tell jQuery not to process the data
                contentType: false ,  // tell jQuery not to set contentType
                success: function(data) {
                  //alert(data['status']);
                  console.log(data.status);
                  console.log(data);
                },
                error: function() {
                  alert('does not work');
                }
              });
            });

        });
        
      });
    </script>
  </body>
</html>