<?php
/*
Extension Name: WerkstattVerwaltung
Extension Url: http://lussumo.com/addons/
Description: Basic editing for Werkstatt-Extensions
Version: 0.1
Author: Andreas Wiesenhofer <awiesi@gmail.com>
Author Url: http://andreaswiesenhofer.com

*/

$Context->Dictionary['Verwaltung'] = 'Werkstatt Verwaltung'; // Tab title

// Add a link to the members page at the top bar 
if(isset($Menu) && $Context->Session->UserID > 0 && $Context->Session->User->Permission('PERMISSION_VIEW_MEMBER')) {
    $Menu->AddTab($Context->GetDefinition('Verwaltung'), $Context->GetDefinition('Verwaltung'), GetUrl($Configuration, 'extension.php', '', '', '', '', 'PostBackAction=Verwaltung'), $Attributes = '', $Position = '50', $ForcePosition = '50');
}


if(in_array($Context->SelfUrl, array('extension.php'))   && $Context->Session->UserID > 0 || in_array($Context->SelfUrl, array('extension.php')) &&  $Context->Session->User->Permission('PERMISSION_VIEW_MEMBER')) {
	
// Determine the members page content by querying the database.
class WerkstattVerwaltung {
	 
    function CreateWerkstattVerwaltung() {
    	
        $toreturn ='Hier entsteht die Verwaltungsseite f&uuml;r die Hydra-spezifischen Erweiterungen ... stay tuned!<br/>
        Das ist jetzt alles noch "hochtechnisch" aber ich glaub man(n) kennt sich aus. Beim Kalender letze zeile kopieren und anpassen. selbiges bei den Notizen, je nachdem ob mit kleinem text (erste) oder ohne, daf&uuml;r mit link (zweite). <hr/><br/><br/>';
        
        /*
        ** Calendar Einstellung
        */
        
        $file = 'extensions/Calendar/cal.txt';
        $script = $_POST['script'];
      	
      	if($script) {
      		$fp=fopen($file, "w");
      		fwrite($fp,$script);
      		fclose($fp);
   		}
		$toreturn .= '<form action="" method="post">Quelldatei f&uuml;r Calendar &auml;ndern:<br>';

		if($file) {
			
			$toreturn .= '<textarea rows="10" style="width: 100%;" name="script">';
			
			$fp=fopen($file,"r");
			$t="";
			while(!feof($fp)) {
				$t.=fread($fp,1024);
			}
			fclose($fp);
			$toreturn .= $t.'</textarea>';

		}
		
		$toreturn .= '<br /><input value="Speichern" type="submit"></form><hr/>';

		/*
        ** Notizen Einstellung
        */
        
        $file1 = 'HydraNotizen.html';
        $notizen = $_POST['notizen'];
      	
      	if($notizen) {
      		$fp1=fopen($file1, "w");
      		fwrite($fp1,$notizen);
      		fclose($fp1);
   		}
		$toreturn .= '<form action="" method="post">Quelldatei f&uuml;r Notizen:<br>';

		if($file1) {
			
			$toreturn .= '<textarea rows="30" style="width: 100%;" name="notizen">';
			
			$fp1=fopen($file1,"r");
			$t1="";
			while(!feof($fp1)) {
				$t1.=fread($fp1,1024);
			}
			fclose($fp1);
			$toreturn .= $t1.'</textarea>';

		}
		
		$toreturn .= '<br /><input value="Speichern" type="submit"></form><hr/>';
        
        return  $toreturn;
        
        }
    function Render() {
        echo $this->CreateWerkstattVerwaltung();
    }
}

// Add the page and stylesheets and echo it all out
if(in_array(ForceIncomingString("PostBackAction", ""), array('Verwaltung'))) {
$Context->PageTitle = $Context->GetDefinition('Verwaltung');
$Menu->CurrentTab = 'Verwaltung';
$Body->CssClass = 'Discussions';
$WerkstattVerwaltung = $Context->ObjectFactory->NewContextObject($Context, 'WerkstattVerwaltung');
$Page->AddRenderControl($WerkstattVerwaltung, $Configuration["CONTROL_POSITION_BODY_ITEM"]);
}

}


?>