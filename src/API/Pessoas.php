<? namespace API;

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\QueryException;
use Luracast\Restler\RestException;
use Model\Pessoa;

class Pessoas {
  
  public $restler;

  /**
   * Retorna os dados de um registro.
   * @param $id {string} {@from path} {@type uuid}
   * @throws 404 RestException ID não encontrada
   */
  public function get($id) {
    return Pessoa::findOrFail($id);
  }
  
  /**
   * Cria um novo registro.
   * @param string $apelido
   * @param string $nome
   * @param string $nascimento {@type date}
   * @param string[] $stack Lista de stacks do usuário - forçado pra minúsculas
   * @throws 422 RestException Apelido repetido
   * @status 201
   */
  public function post($apelido, $nome, $nascimento, $stack = []) {
    try {
      $stack = array_map('strtolower', array_filter($stack));
      $entry = Pessoa::create(compact('apelido', 'nome', 'nascimento', 'stack'));
    } catch (QueryException $e) {
      if ($e->getCode() == 23505) { //duplicate key - most probably apelido, but TODO we should double check
        preg_match('/unique constraint "(\w+)"/', $e->getMessage(), $column);
        throw new RestException(422, "Repeated value for key '$column[1]'");
      }
      throw $e;
    }
    header("Location: /pessoas/$entry->id");
    return $entry;
  }
  
  /**
   * Busca um registro
   * @param string $t Termo de busca
   */
  public function index($t) {
    return Pessoa::where('nome', '@@', DB::raw("to_tsquery('english', ".DB::escape($t).")"))
      ->orWhere('nome', 'LIKE', "%$t%") //still needs like because it matches partial text.....
      ->orWhere('apelido', 'LIKE', "%$t%")
      ->orWhere('stack', '?', strtolower($t))
      ->orderByRaw("ts_rank('terms', to_tsquery('english', ".DB::escape($t).")) DESC")
      ->limit(50)
      ->get();
  }
  
}