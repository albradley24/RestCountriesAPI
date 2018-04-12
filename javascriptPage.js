function searchCountryJava()
{
	var countryName = document.getElementById("countryName").value;
	
	//Error checking before submission
	if (countryName != "")
	{
		var xhttp = new XMLHttpRequest();
		xhttp.open("GET", "phpPage.php?function=searchCountry&countryName=" + countryName, false);
		xhttp.send();
		document.getElementById("countriesTable").innerHTML = xhttp.responseText;
	}
	//If input value is blank, throw error message
	else
	{
		window.alert("Please enter a value for country name.");
	}
}