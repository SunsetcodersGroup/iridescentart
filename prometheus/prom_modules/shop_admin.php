<?php
/**
 * Shop administration module
 *
 * @author          Simon Mitchell <kartano@gmail.com>
 *
 * @namespace       Prometheus\Module\Shop
 *
 * @version         1.0.0           2017-07-10      Prototype.
 */

namespace Prometheus\Module\Shop;
use Prometheus\Vendors\FileAttributeTools AS FT;

require_once dirname ( dirname ( __FILE__ ) ) . '/SunLibraryModule.php';
require_once dirname ( dirname ( __FILE__ ) ) . '/FileAttributeTools/FileAttributeTools.php';

/**
 * Shop Admin module class.
 */
class ShopAdmin extends SunLibraryModule
{
    protected $dbConnection;

    const ModuleDescription = 'Ecommerce Shop, Supports Mysqli, Dated Specials.. ';
    const ModuleAuthor = 'Sunsetcoders Development Team.';
    const ModuleVersion = '0.1';

    /**
     * ShopAdmin constructor.
     *
     * @param \mysqli $dbConnection
     */
    function __construct(\mysqli $dbConnection) {
        parent::__construct ($dbConnection);
    }
    /**
     * Render any links such as external JS or external CSS files that we might need.
     * These are all rendered in the HEAD of the document.
     *
     * @return void
     */
    public function renderHeaderLinks()
    {
        //
    }

    /**
     * Render any custom javascript a module may need, such as validation or functions for special effects.
     * These are all rendered into the HEAD of the document within a SCRIPT tag.
     *
     * @return void
     */
    public function renderCustomJavaScript()
    {
        //
    }

    /**
     * Render any custom javascript inside the document ready function.  Anything here will be called as soon as the DOM is loaded.
     *
     * @return void
     */
    public function documentReadyJavaScript()
    {
        //
    }

    /**
     * The common entry point for all modules.
     *
     * @return void
     */
    public function callToFunction()
    {
?>
        <div id="shop-background">
            <div class="shop-content">
            </div>
        </div>
        <div class="close-shop"></div>
<?php
    }

    /**
     * This function is used to assert that necessary tables for a given module exist.
     *
     * @return void
     */
    protected function assertTablesExist()
    {
        $val =$this->dbConnection->query('select 1 from `shop` LIMIT 1' );
        if ($val== FALSE) {
            throw new \Exception(__CLASS__." cannot be used, because shop tables are missing.  Did you remember to include the SHOP module?");
        }
        else {
            $val->free();
        }
    }

    /**
     * Returns the version of the module, based on the most recent version number inside the files docblock.
     *
     * @return string The full version of the module as read from its docblock.
     */
    public function getVersion()
    {
        $objDetails=FT\FileAttributes($txtFile);
        return $objDetails->txtVersion;
    }

    /**
     * Switch the mode of the module based on what the local action for the script is.
     *
     * @return void
     */
    public function switchMode()
    {
        //
    }
}
?>
