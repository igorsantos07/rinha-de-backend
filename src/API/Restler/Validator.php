<? namespace API\Restler;

use Luracast\Restler\Data\ValidationInfo;
use Luracast\Restler\RestException;

class Validator extends \Luracast\Restler\Data\Validator {

  //replaces the default 400 by 422 in validation errors
  public static function validate($input, ValidationInfo $info, $full = null) {
    try {
      return parent::validate($input, $info, $full);
    }
    catch (RestException $e) {
      if ($e->getCode() == 400) {
        throw new RestException(422, $e->getMessage(), $e->getDetails());
      }
      throw $e;
    } 
  }
  
}