<?php
/**
 * Sun Library abstract module.  Any module loaded dynamically should be an instance of this.
 *
 * @author          Simon Mitchell <kartano@gmail.com>
 * @version         1.0.0               2016-12-14 15:14:53 SM:  Prototype
 * @version         1.1.0               2016-12-15 08:32:18 SM:  SwitchMode is now part of the footprint.
 * @version         1.1.1               2016-12-16 17:11:27 SM:  Making use of the FileAttributes library.
 */

abstract class SunLibraryModule
{
    protected $objDB;
    
    /**
     * Constructor.
     *
     * @param \mysqli $objDB Connection to the database.
     * @return void
     */
    public function __construct(\mysqli $objDB)
    {
        $this->objDB=$objDB;
        
        //--------------------------------------------------------------------------------------
        // SM:  As soon as we instantiate this module, we assert that the table exists
        //      and then switch through the current state to see what we need to do.
        //--------------------------------------------------------------------------------------
        
        $this->assertTablesExist();
        $this->switchMode();
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
        //
    }
    
    /**
     * This function is used to assert that necessary tables for a given module exist.
     *
     * @return void
     */
    protected function assertTablesExist()
    {
    	if(mysqli_query($this->objDB,"DESCRIBE  users ")){

    	}else{
    		
    		$createTable = $dbConnection->prepare ( "CREATE TABLE users (userID INT(11) AUTO_INCREMENT PRIMARY KEY, userFullName VARCHAR(100) NOT NULL, userUsername VARCHAR(100) NOT NULL, userPassword VARCHAR(100) NOT NULL, userStatus VARCHAR(20) NOT NULL)" );
    		$createTable->execute ();
    		$createTable->close ();
    		
    		$insertRow = $dbConnection->prepare ( "INSERT INTO `users` (`userID`, `userFullName`, `userUsername`, `userPassword`, `userStatus`) VALUES (NULL, 'System Administrator', 'Administrator', 'werdwerd', 'Administrator')" );
    		$insertRow->execute ();
    		$insertRow->close ();
    		
    		$createTable = $dbConnection->prepare ( "CREATE TABLE pages (pageID INT(11) AUTO_INCREMENT PRIMARY KEY, pageName VARCHAR(100) NOT NULL, pageRow1 VARCHAR(20) NOT NULL, pageRow2 VARCHAR(20) NOT NULL, pageRow3 VARCHAR(20) NOT NULL, pageRow4 VARCHAR(20) NOT NULL, pageRow5 VARCHAR(20) NOT NULL, pageRow6 VARCHAR(20) NOT NULL, pagePublish VARCHAR(20) NOT NULL, pageOrder DECIMAL(1,0) NOT NULL)" );
    		$createTable->execute ();
    		$createTable->close ();
    		
    		$insertRow = $dbConnection->prepare ( "INSERT INTO `pages` (`pageID`, `pageName`, `pageRow1`, `pageRow2`, `pageRow3`, `pageRow4`, `pageRow5`, `pageRow6`, `pagePublish`, `pageOrder`) VALUES (NULL, 'Home', '', '', '', '', '', '', 'Yes', '1')" );
    		$insertRow->execute ();
    		$insertRow->close ();
    		
    		$createTable = $dbConnection->prepare ( "CREATE TABLE page_settings (pagesetID INT(11) AUTO_INCREMENT PRIMARY KEY, pageID INT(11) NOT NULL, rowID DECIMAL(4,0)	 NOT NULL, moduleCode VARCHAR(100) NOT NULL)" );
    		$createTable->execute ();
    		$createTable->close ();
    		
    		$createTable = $dbConnection->prepare ( "CREATE TABLE settings (settingsID INT(11) AUTO_INCREMENT PRIMARY KEY, settingsName VARCHAR(100) NOT NULL, settingsFileName VARCHAR(100) NOT NULL)" );
    		$createTable->execute ();
    		$createTable->close ();
    		
    		$createTable = $dbConnection->prepare ( "CREATE TABLE menus (menuID INT(11) AUTO_INCREMENT PRIMARY KEY, menuLocation VARCHAR(100) NOT NULL, menuLabel VARCHAR(100) NOT NULL, menuOrder DECIMAL(1,0) NOT NULL)" );
    		$createTable->execute ();
    		$createTable->close ();
    	}
    }
    
    /**
     * Returns the version of the module, based on the most recent version number inside the files docblock.
     *
     * @return string The full version of the module as read from its docblock.
     */
    public function getVersion()
    {
        return 'unknown';
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
    
    /**
     * Helper function to retrieve the version number from a given file.
     *
     * @return string A string value with the full version number of the specified file.
     */
    protected function readVersionFromFile($txtFile)
    {
        $objDetails=FileAttributes\FileAttributes($txtFile);
        return $objDetails->txtVersion;
    }
}
?>
