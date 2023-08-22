<? namespace API;
class Info {

  /**
   * Runs phpinfo()
   */
  public function index() {
    phpinfo();
  }
}