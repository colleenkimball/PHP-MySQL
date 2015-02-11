<!--This php program takes in a GET and pulls information from a database based on the user's input-->

<?php
			
			$con = mysql_connect(HOST,USERNAME,PASSWORD);
 					if (!$con) {die('Could not connect: ' . mysql_error());}
 					mysql_select_db("grownnextdoor");
 					$query = 'select 
					Farm.name as farmName,
					Farm.hours as farmHours,
					Farm.address as farmAddress,
					Farm.description as farmDescription,
					Tag.name as tagName,
					Tag.image as tagImage
					from (Farm, Tag)
	
					inner join FarmToTag
					on Farm.id = FarmToTag.farmID
					and FarmToTag.tagID = Tag.id

					group by farmName;';
					$result = mysql_query($query);
					
					$SQL = 'select 
					Farm.name as farmName,
					Farm.hours as farmHours,
					Farm.address as farmAddress,
					Farm.description as farmDescription,
					Tag.name as tagName,
					Tag.image as tagImage,
					Produce.name as produceName
					from (Farm, Tag, Produce)

					inner join FarmToProduce
					on Farm.id = FarmToProduce.farmID 
					and FarmToProduce.produceID = Produce.id
					and Produce.name = "'.$_GET[produce].'"
	
					inner join FarmToTag
					on Farm.id = FarmToTag.farmID

					group by farmName;';
					
					
					//echo($SQL);	
					$innerJoinQuery = mysql_query($SQL);	
									
					$result2 = mysql_query($query) or die($query."<br/><br/>".mysql_error());
				
					if (strlen($_GET[produce])==0){
					while($innerJoin2 = mysql_fetch_array($result))
 					{
						$a=explode(" ",$innerJoin2['farmName']);
					
						echo("<section class='farm'>");
						//echo("<p>".$farmToProduceRow['id'].$farmToProduceRow['farmID'].$farmToProduceRow['produceID']."</p>");
						echo("<img src=".$innerJoin2['tagImage']." alt=".$innerJoin2['tagName']." align='right' height='20px'/>");
						echo("<h5><a href='".$a[0].$a[1].".html' class='floatbox'>".$innerJoin2['farmName']."</a></h5>");
						echo("<p>".$innerJoin2['farmAddress']."<br />");
						echo("Open ".$innerJoin2['farmHours']."<br /><br />");
						echo($innerJoin2['farmDescription']."</p>");
						echo("</section>");
					 }
					}
						
					else {
					echo("<h2>Search Results for ".$_GET[produce]."</h2>");
 					while($innerJoin = mysql_fetch_array($innerJoinQuery))
 					{ 
						$a=explode(" ",$innerJoin['farmName']);
					
						echo("<section class='farm'>");
						//echo("<p>".$farmToProduceRow['id'].$farmToProduceRow['farmID'].$farmToProduceRow['produceID']."</p>");
						echo("<img src=".$innerJoin['tagImage']." alt=".$innerJoin['tagName']." align='right'/>");
						echo("<h5><a href='".$a[0].$a[1].".html' class='floatbox'>".$innerJoin['farmName']."</a></h5>");
						echo("<p>".$innerJoin['farmAddress']."<br />");
						echo("Open ".$innerJoin['farmHours']."<br /><br />");
						echo($innerJoin['farmDescription']."</p>");
						echo("</section>");
					 }
					 }
					 mysql_close($con);
				
		?>
