<?php
	
	$function=$_REQUEST["function"];
	$function();
	
	function searchCountry()
	{
		$countryName = $_REQUEST["countryName"];
		
		$response = file_get_contents('https://restcountries.eu/rest/v2/name/' . $countryName);
		$response = json_decode($response);
		
		if ($response != "" && $response != null)
		{
			echo "<table>";
				echo "<tr>";
					echo "<th>Country Name</th>";
					echo "<th>Alpha Code 2</th>";
					echo "<th>Alpha Code 3</th>";
					echo "<th>Flag</th>";
					echo "<th>Region</th>";
					echo "<th>Subregion</th>";
					echo "<th>Population</th>";
					echo "<th>Language(s)</th>";
				echo "</tr>";
			//Limit results returned to 50
			//Display total number of countries on bottom of page
			//If greater than 50, show *error* message
			if (count($response) <= 50)
			{
				$total = count($response);
			}
			else
			{
				$total = 50;
			}
			//Using total variable to only display first 50 results
			for ($i = 0; $i < $total; $i++)
			{
				echo "<tr>";
					echo "<td>" . $response[$i]->name . "</td>";
					echo "<td>" . $response[$i]->alpha2Code . "</td>";
					echo "<td>" . $response[$i]->alpha3Code . "</td>";
					echo "<td><img src='" . $response[$i]->flag . "'</td>";
					echo "<td>" . $response[$i]->region . "</td>";
					echo "<td>" . $response[$i]->subregion . "</td>";
					echo "<td>" . number_format($response[$i]->population) . "</td>";
					echo "<td>";
						for ($k = 0; $k < count($response[$i]->languages); $k++)
						{											
							//Check for more than one language (put each on a newline)
							if (count($response[$i]->languages) > 1)
							{
								echo $response[$i]->languages[$k]->name . "<br>";
							}
							else
							{
								echo $response[$i]->languages[$k]->name;
							}
						}
					echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
			
			//Display *error* message when results contain more than 50 items
			if (count($response) > 50)
			{
				echo "<h3>Total number of countries: " . count($response) . "</h3>";
				echo "<p>**Only displaying first 50 results**</p>";
			}
			else
			{
				echo "<h3>Total number of countries: " . count($response) . "</h3>";
			}
			
			echo "<h3>Regions: </h3>";
			echo "<ul>";
			
				//Create empty array to store regions
				$resultRegions = [];
				
				//For each region in response, add it to the new array
				foreach ($response as &$region)
				{
					array_push($resultRegions,$region->region);
				}
				
				//Print each region in the array and the number of times it appears in the results
				$regionTotals = array_count_values($resultRegions);
				foreach ($regionTotals as $key => $value) 
				{
					//Catch empty keys/values and ignore them
					if ($key != null || $key != "")
					{
						echo "<li>" . $key . " (" . $value . ")</li>";
					}
				}
				
			echo "</ul>";
			
			echo "<h3>Subregions: </h3>";
			echo "<ul>";
			
				//Create empty array to store subregions
				$resultSubregions = [];
				
				//For each subregion in response, add it to the new array
				foreach ($response as &$subregion)
				{
					array_push($resultSubregions,$subregion->subregion);
				}
				
				//Print each subregion in the array and the number of times it appears in the results
				$subregionTotals = array_count_values($resultSubregions);
				
				foreach ($subregionTotals as $key => $value) 
				{
					//Catch empty keys/values and ignore them
					if ($key != null || $key != "")
					{
						echo "<li>" . $key . " (" . $value . ")</li>";
					}
				}
				
			echo "</ul>";
		}
		else
		{
			echo "The country name you supplied did not produce results. Please correct and resubmit.";
		}
	}
?>