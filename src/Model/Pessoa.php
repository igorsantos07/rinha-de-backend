<? namespace Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * @property $id {string}
 * @property $nome {string}
 * @property $apelido {string}
 * @property $nascimento {string}
 * @property $stack {string[]}
 */
class Pessoa extends \Illuminate\Database\Eloquent\Model {
  
  use HasUuids;
  
  public $timestamps = false;
  protected $guarded = ['id'];
  protected $casts   = [
    'nascimento' => 'datetime:Y-m-d',
    'stack'      => 'json'
  ];
  protected $hidden = ['terms'];
  
}