<?php 
	class PrimsAlgorithm {
		//$INT_MAX = 0x7FFFFFFF;
		const INFINITY = 100000000;

		function MinKey($key, $set, $verticesCount)
		{
			// global $INT_MAX;
			// $min = $INT_MAX;
			$min = self::INFINITY;
			$minIndex = 0;

			for ($v = 0; $v < $verticesCount; ++$v)
			{
				if ($set[$v] == false && $key[$v] < $min)
				{
					$min = $key[$v];
					$minIndex = $v;
				}
			}

			return $minIndex;
		}

		function PrintResult($parent, $graph, $verticesCount)
		{ 
			$outputFile = fopen("Result_of_Graph_G_N_". $verticesCount . ".txt", "w");
			$outputString.=""; 
			
			$edge = $verticesCount - 1;
			echo '<div class="container"><div class="row"><div class="col-sm-1">
          		</div><div class="panel panel-primary">';
			echo '<div class="panel-heading">Output Panel</div>';
			echo '<div class="panel-body">';
			echo '<p>Total number of nodes ='.$verticesCount.'</p>';
			echo '<p>Total number of edges = '.$edge.'</p>';
			
			echo '</div>';

			echo '<table class="table">';
			echo "<thead>
		      <tr>
		        <th>edges</th>
		        <th>Cost</th>
		        </tr>
		    </thead>";
		    $outputString.="Total number of nodes = ". $verticesCount."\n";
		    $outputString.="Total number of edges = ". $edge."\n";
			$sum = 0;
			$str = "Total cost of minimum spanning tree is = SUM OF (";
			$outputString.="List of edges & their costs: \n";
			for ($i = 1; $i < $verticesCount; ++$i) {
				echo "<tr>";
				$sum = $sum + $graph[$i][$parent[$i]];
				echo "<td>"."(". $parent[$i] . " , " . $i. ")" ."</td>";
				$outputString.="( ".$parent[$i]." , ".$i." ) \t edge cost:   ".$graph[$i][$parent[$i]]."\n";
				echo "<td>". $graph[$i][$parent[$i]] ."</td>";
				$str .= " ".$graph[$i][$parent[$i]] ."+";
				echo "</td>";
			}
			$str = rtrim($str, "+");
			$str .= ")";
			echo '</table>';

			echo $str . " = " .$sum;
			$outputString.="Total cost of minimum spanning tree is = " .$sum."\n";
			echo '<div class="col-sm-1">
            </div></div></div></div>';
            fwrite($outputFile, $outputString);
            fclose($outputFile);

		}

		function Prim($graph, $verticesCount, $stepProcess = 0)
		{
			//global $INT_MAX;
			$parent = array();
			$key = array();
			$mstSet = array();

			for ($i = 0; $i < $verticesCount; ++$i)
			{
				//$key[$i] = $INT_MAX;
				$key[$i] = self::INFINITY;
				$mstSet[$i] = false;
			}

			$key[0] = 0;
			$parent[0] = -1;

			for ($count = 0; $count < $verticesCount - 1; ++$count)
			{
				$u = $this->MinKey($key, $mstSet, $verticesCount);
				$mstSet[$u] = true;

				for ($v = 0; $v < $verticesCount; ++$v)
				{
					if ($graph[$u][$v] && $mstSet[$v] == false && $graph[$u][$v] < $key[$v])
					{
						$parent[$v] = $u;
						$key[$v] = $graph[$u][$v];
					}
				}
			}

			if($stepProcess == 1){
				$result = array(
					"parent" => $parent,
					"graph"	=> $graph,
					"verticesCount" => $verticesCount
				);
				
				return $result;
			} else {
				$this->PrintResult($parent, $graph, $verticesCount);
			}
			
		}
	}
?>