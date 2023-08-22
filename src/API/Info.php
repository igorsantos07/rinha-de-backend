<? namespace API;
class Info {

  /**
   * Roda o phpinfo() :)
   */
  public function index() {
	  /** @noinspection ForgottenDebugOutputInspection */
	  phpinfo();
  }
}
