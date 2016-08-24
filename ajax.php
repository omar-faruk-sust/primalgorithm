
<?php 
  include "prim.php";

  $primsAlgorithm = new PrimsAlgorithm();
 if(isset($_POST['node_no']) && isset($_FILES['file'])){
        
        $fileData = $_FILES['file'];
        $node_no = $_POST['node_no'];
        $graph = processInputData($node_no, $fileData);

        $response = $primsAlgorithm->Prim($graph, $node_no, $stepProcess = 1);

        if(!empty(array_filter($response))){
          $response['status'] = 1;
        } else {
          $response['status'] = 0;
        }

        echo json_encode($response);
        return ;
    } else {
      die("Not catching Ajax Call");
    }
?>

<?php 
  function processInputData($node_no, $files) {
    $uploaddir = __DIR__ . '/uploads';
    $new_graph = array();
    $errors= array();
    
    $file_name = $files['name'];
    $file_size =$files['size'];
    $file_tmp =$files['tmp_name'];
    $file_type=$files['type'];

      if (move_uploaded_file($files['tmp_name'], "$uploaddir/$file_name")) {
          ini_set("memory_limit",-1);
          $input_file = "$uploaddir/$file_name";
      
          $myfile = fopen($input_file, "r") or die("Unable to open file!");
          $i = 0;
          while(! feof($myfile))
          {
              $lines = fgets($myfile); // one line in each time
              // this is because at the end of the line it's generating empty array
              if ($lines === false) {
                  break;
               }
              $splitedArray = preg_split('#\s+#', $lines, null, PREG_SPLIT_NO_EMPTY);
              $new_graph[$i] = $splitedArray;
              $i++;
          }
        }else{
           echo "file is not uploaded.";
      }
      fclose($myfile);

      return $new_graph;
  }
?>