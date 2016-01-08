<?
    // Klassendefinition
    class Wunderground extends IPSModule {
 
        // Der Konstruktor des Moduls
        // Überschreibt den Standard Kontruktor von IPS
        public function __construct($InstanceID) {
            // Diese Zeile nicht löschen
            parent::__construct($InstanceID);
			
            // Selbsterstellter Code
        }
 
        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
            parent::Create();
			$this->RegisterPropertyString("API", "");
			$this->RegisterPropertyString("Location", "Menden");
			$this->RegisterPropertyInteger("UpdateInterval", 5);
			
			//Eigenschaften festlegen
			$this->RegisterVariableString("Condition","Wetterbedingung");
			$this->RegisterVariableFloat("Temperature","Temperatur","Temperature");
 
        }
 
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
        }

		// Daten von Wunderground Abfragen
		public function RequestData()
		{
			$api = $this->ReadPropertyString("API");
			$location = $this->ReadPropertyString("Location");
			
			$url = "http://api.wunderground.com/api/$api/geolookup/conditions/lang:DL/q/DL/$ort.json";
			$json_string = file_get_contents($url);
		
			$value = $parsed_json->{'current_observation'}->{'weather'};
				SetValueString($this->GetIDForIdent("Condition"),$value);

			$value = $parsed_json->{'current_observation'}->{'temp_c'};
				SetValueFloat($this->GetIDForIdent("Temperature"),floatval($value));
				
			/* $value = $parsed_json->{'current_observation'}->{'windchill_c'};
				SetValueFloat(IPS_GetVariableIDByName('Windchill',IPS_GetParent($_IPS["SELF"])),floatval($value));
				
			$value = $parsed_json->{'current_observation'}->{'dewpoint_c'};
				SetValueFloat(IPS_GetVariableIDByName('Dewpoint',IPS_GetParent($_IPS["SELF"])),floatval($value));
				
			$value = $parsed_json->{'current_observation'}->{'relative_humidity'};
			  SetValueInteger(IPS_GetVariableIDByName('Humidity',IPS_GetParent($_IPS["SELF"])),intval($value));

			$value = $parsed_json->{'current_observation'}->{'wind_kph'};
				SetValueFloat(IPS_GetVariableIDByName('WindSpeed',IPS_GetParent($_IPS["SELF"])),floatval($value));

			$value = $parsed_json->{'current_observation'}->{'wind_gust_kph'};
				SetValueFloat(IPS_GetVariableIDByName('WindSpeedGust',IPS_GetParent($_IPS["SELF"])),floatval($value));

			$value = $parsed_json->{'current_observation'}->{'wind_degrees'};
				SetValueInteger(IPS_GetVariableIDByName('WindDirection',IPS_GetParent($_IPS["SELF"])),intval($value));

			$value = $parsed_json->{'current_observation'}->{'wind_dir'};
				SetValueString(IPS_GetVariableIDByName('WindDirectionString',IPS_GetParent($_IPS["SELF"])),$value);

			$value = $parsed_json->{'current_observation'}->{'pressure_mb'};
				SetValueInteger(IPS_GetVariableIDByName('AirPressure',IPS_GetParent($_IPS["SELF"])),intval($value));

			$value = $parsed_json->{'current_observation'}->{'visibility_km'};
				SetValueInteger(IPS_GetVariableIDByName('Visibility',IPS_GetParent($_IPS["SELF"])),intval($value));

			$value = $parsed_json->{'current_observation'}->{'UV'};
			  SetValueFloat(IPS_GetVariableIDByName('UV',IPS_GetParent($_IPS["SELF"])),floatval($value));

			*/
		}
		
    }
?>