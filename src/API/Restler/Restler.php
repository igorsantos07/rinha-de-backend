<? namespace API\Restler;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Luracast\Restler\RestException;

class Restler extends \Luracast\Restler\Restler {

    protected function call() {
      try {
        parent::call();
      }
      catch (ModelNotFoundException $e) {
        throw new RestException(404);
      }
  }
}