<?php require("header.php"); ?>
<?php 
  include "prim.php";

  $primsAlgorithm = new PrimsAlgorithm();
  if(isset($_POST['btn-upload']))
    {
      if(!empty($_FILES['input_file']['name'])){
          $fileData = $_FILES['input_file'];
          $node_no = $_POST['node_no'];
            $new_graph = processInputData($node_no, $fileData);
         
            $primsAlgorithm->Prim($new_graph, $node_no);
      } else {
        die("you did not select any input file");
       }
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
           die("Error. File is not being read. Please try again!");
      }

      fclose($myfile);
      return $new_graph;
  }
?>

<?php require("footer.php"); ?>
