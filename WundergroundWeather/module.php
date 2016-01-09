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
			$this->RegisterPropertyInteger("UpdateInterval", 300);
			
			//Eigenschaften festlegen
			$this->RegisterVariableString("Condition","Wetterbedingung");
			$this->RegisterVariableString("WindDirectionString","Windrichtung");
			
			$this->RegisterVariableInteger("AirPressure","Luftdruck","AirPressure");
			$this->RegisterVariableInteger("Visibility","Sichtweite","Distance.km");
			$this->RegisterVariableInteger("Humidity","Luftfeuchtigkeit","Humidity");
			$this->RegisterVariableInteger("WindDirection","Windrichtung","WindDirection");			
			
			$this->RegisterVariableFloat("Temperature","Temperatur","Temperature");
			$this->RegisterVariableFloat("Windchill","Windchill","Temperature");
			$this->RegisterVariableFloat("Dewpoint","Taupunkt","Temperature");
			$this->RegisterVariableFloat("WindSpeed","Wind","WindSpeed.Kph");
			$this->RegisterVariableFloat("WindSpeedGust","Wind in Böen","WindSpeed.Kph");
			$this->RegisterVariableFloat("UV","UV Index","Temperature");
        }
 
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
			
			if (strlen($this->ReadPropertyString("API")) != 16)
			{
				//Instanz ist aktiv
				$this->SetStatus(102);
				
				//Script + Timer
				$UpdateInterval = $this->ReadPropertyInteger("UpdateInterval");
				IPS_LogMessage($_IPS['SELF'], "Update Interval ". $UpdateInterval. " Minuten");
				
				$UpdateWeatherScriptID = @$this->GetIDForIdent("_updateWeather");
				if ( $UpdateWeatherScriptID === false )
				{
				  $UpdateWeatherScriptID = $this->RegisterScript("_updateWeather", "_updateWeather", file_get_contents(__DIR__ . "/_updateWeather.php"), 99);
				}
				else
				{
				  IPS_SetScriptContent($UpdateWeatherScriptID, file_get_contents(__DIR__ . "/_updateWeather.php"));
				}
				IPS_SetHidden($UpdateWeatherScriptID,true);
				IPS_SetScriptTimer($UpdateWeatherScriptID, $UpdateInterval);
			}
			else
			{
				//Instanz ist inaktiv
				$this->SetStatus(104);
			}
        }		
    }
?>