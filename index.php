<?

include_once( 'Grab/Page.php');

$isOneCar = isset($_GET['car'])?$_GET['car']:NULL;




  include_once('Grab/Car.php');

  $page    = new Grab\Car($_GET['car']);
  $page->load();
  $contact = $page->get_contact();

	echo $page->get_sold();