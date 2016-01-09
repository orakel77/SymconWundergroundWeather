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
			
			//Variablenprofil anlegen
			//$this->RegisterProfileFloat("WindSpeed.Kph", "WindSpeed", "", " kn",   0, 100, 1);
			//$this->RegisterProfileInteger("Distance.km", "Distance", "", " km",   0, 150, 1);
			
			if (!IPS_VariableProfileExists("WindSpeed.kt"))
			{
				IPS_CreateVariableProfile("WindSpeed.kt", 2);	// 2 = Float
				IPS_SetVariableProfileIcon("WindSpeed.kt","WindSpeed");
				IPS_SetVariableProfileValues("WindSpeed.kt", 0, 100, 1);
				IPS_SetVariableProfileText("WindSpeed.kt",""," kn");
			}
			
			if (!IPS_VariableProfileExists("Distance.km"))
			{
				IPS_CreateVariableProfile("Distance.km", 1);	// 1 = Integer
				IPS_SetVariableProfileIcon("Distance.km","Distance");
				IPS_SetVariableProfileValues("Distance.km", 0, 999, 1);
				IPS_SetVariableProfileText("Distance.km",""," km");
			}
			
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
			$this->RegisterVariableFloat("WindSpeed","Wind","WindSpeed.kt");
			$this->RegisterVariableFloat("WindSpeedGust","Wind in Böen","WindSpeed.kt");
			$this->RegisterVariableFloat("UV","UV Index");
        }
 
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
			
			if (strlen($this->ReadPropertyString("API")) == 16)
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