<?
	require_once 'firebaseLib.php';

	$url = 'https://vpc.firebaseio.com';
	$fb = new fireBase($url);

	$population = array('population' => getPopulation(), 'timestamp' => date("Y-m-d H:i:s", mktime(0, 0, 0)));
	//$fb->push('/dashboard/venicePopulation', $population);
	//$fb->set('/dashboard/currentPopulation', $population['population']);

	function getPopulation() {
		$feed_contents = file_get_contents('http://portale.comune.venezia.it/millefoglie/statistiche/scheda/QUARTIERE-POPOLA-2$1$------');
		$DOM = new DOMDocument;
		$DOM->loadHTML($feed_contents);

		$items = $DOM->getElementsByTagName('td');
   		$population = $items->item($items->length - 1)->nodeValue;
		return intval($population);
	}

	$date = date("j-M-y");
	$population_record = "\n" . $date . "\t" . $population['population'];
	file_put_contents ("../widgets/population.tsv", $population_record, FILE_APPEND);
?>