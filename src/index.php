<?
require_once __DIR__.'/vendor/autoload.php';

Dotenv\Dotenv::createImmutable(__DIR__)->load();

require_once __DIR__.'/db.php';

//echo "<pre>";
//var_dump($_SERVER);
//phpinfo();

use Luracast\Restler\Defaults;
use API\Restler\Restler;

//set the defaults to match your requirements
//Defaults::$throttle = 20; //time in milliseconds for bandwidth throttling
Defaults::$validatorClass = API\Restler\Validator::class;
\Luracast\Restler\Compose::$includeDebugInfo = false;
\Luracast\Restler\RestException::$codes[422] = 'Unprocessable entity';

//setup restler
$r = new Restler(false);
$r->setBaseUrls($_SERVER['HTTP_HOST']);
$r->addAPIClass(Luracast\Restler\Explorer\v2\Explorer::class); //from restler framework for API Explorer

$r->addAPIClass(API\Info::class);
$r->addAPIClass(API\Pessoas::class);
$r->addAPIClass(API\ContagemPessoas::class, 'contagem-pessoas');

//$r->addFilterClass('RateLimit'); //Add Filters as needed
$r->handle(); //serve the response