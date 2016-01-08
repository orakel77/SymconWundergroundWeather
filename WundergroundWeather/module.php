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
			
		}
		
    }
?>