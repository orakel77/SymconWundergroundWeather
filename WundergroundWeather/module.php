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
			
			//ScriptTimer
			$UpdateInterval = $this->ReadPropertyString("UpdateInterval");
			IPS_LogMessage($_IPS['SELF'], "Update Interval ". $UpdateInterval. " Minuten");
			
			$UpdateWeatherScriptID = @$this->GetIDForIdent("_updateWeather");
			if ( $UpdateWeatherScriptID === false ){
			  $UpdateWeatherScriptID = $this->RegisterScript("_updateWeather", "_updateWeather", file_get_contents(__DIR__ . "/_updateWeather.php"), 99);
			}else{
			  IPS_SetScriptContent($UpdateWeatherScriptID, file_get_contents(__DIR__ . "/_updateWeather.php"));
			}

			IPS_SetHidden($UpdateWeatherScriptID,true);
			IPS_SetScriptTimer($UpdateWeatherScriptID, $UpdateInterval); 
        }		
    }
?>