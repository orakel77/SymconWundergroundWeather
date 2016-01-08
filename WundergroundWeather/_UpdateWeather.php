<?

	$SkriptStart = microtime(true);

	$Api = IPS_GetProperty(IPS_GetParent($_IPS["SELF"]), "API");
	$Location = IPS_GetProperty(IPS_GetParent($_IPS["SELF"]), "Location");
//	$api = $this->ReadPropertyString("API");
//	$location = $this->ReadPropertyString("Location");

   echo "API:" . $Api . "<br>";

	$Url = "http://api.wunderground.com/api/".$Api."/geolookup/conditions/lang:DL/q/DL/".$Location.".json";
	$json_string = file_get_contents($Url);
	$parsed_json = json_decode($json_string);
	
	echo "ID Temperatur:" . IPS_GetVariableIDByName('Temperatur',IPS_GetParent($_IPS["SELF"]));
	echo "ID Temperatur:" . IPS_GetObjectIDByIdent('Condition',IPS_GetParent($_IPS["SELF"]));
	

	$value = $parsed_json->{'current_observation'}->{'weather'};
		SetValueString(IPS_GetObjectIDByIdent('Condition',IPS_GetParent($_IPS["SELF"])),$value);

	$value = $parsed_json->{'current_observation'}->{'wind_dir'};
		SetValueString(IPS_GetObjectIDByIdent('WindDirectionString',IPS_GetParent($_IPS["SELF"])),$value);

		
	$value = $parsed_json->{'current_observation'}->{'pressure_mb'};
		SetValueInteger(IPS_GetObjectIDByIdent('AirPressure',IPS_GetParent($_IPS["SELF"])),intval($value));

	$value = $parsed_json->{'current_observation'}->{'visibility_km'};
		SetValueInteger(IPS_GetObjectIDByIdent('Visibility',IPS_GetParent($_IPS["SELF"])),intval($value));
		
	$value = $parsed_json->{'current_observation'}->{'relative_humidity'};
	  SetValueInteger(IPS_GetObjectIDByIdent('Humidity',IPS_GetParent($_IPS["SELF"])),intval($value));

	$value = $parsed_json->{'current_observation'}->{'wind_degrees'};
		SetValueInteger(IPS_GetVariableIDByName('WindDirection',IPS_GetParent($_IPS["SELF"])),intval($value));

		
	$value = $parsed_json->{'current_observation'}->{'temp_c'};
		SetValueFloat(IPS_GetObjectIDByIdent('Temperature',IPS_GetParent($_IPS["SELF"])),floatval($value));

	$value = $parsed_json->{'current_observation'}->{'windchill_c'};
		SetValueFloat(IPS_GetObjectIDByIdent('Windchill',IPS_GetParent($_IPS["SELF"])),floatval($value));

	$value = $parsed_json->{'current_observation'}->{'dewpoint_c'};
		SetValueFloat(IPS_GetObjectIDByIdent('Dewpoint',IPS_GetParent($_IPS["SELF"])),floatval($value));

	$value = $parsed_json->{'current_observation'}->{'wind_kph'};
		SetValueFloat(IPS_GetObjectIDByIdent('WindSpeed',IPS_GetParent($_IPS["SELF"])),floatval($value));

	$value = $parsed_json->{'current_observation'}->{'wind_gust_kph'};
		SetValueFloat(IPS_GetObjectIDByIdent('WindSpeedGust',IPS_GetParent($_IPS["SELF"])),floatval($value));

	$value = $parsed_json->{'current_observation'}->{'UV'};
	  SetValueFloat(IPS_GetObjectIDByIdent('UV',IPS_GetParent($_IPS["SELF"])),floatval($value));

	$SkriptLaufzeit = microtime(true) - $SkriptStart;
	IPS_LogMessage($_IPS['SELF'], "Laufzeit beträgt ". $SkriptLaufzeit. "sek");
?>