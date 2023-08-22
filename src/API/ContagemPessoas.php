<? namespace API;

use Model\Pessoa;

class ContagemPessoas {
  
  /**
   * Conta quantos registros tem
   */
  public function index() {
    return Pessoa::count();
  }
  
}