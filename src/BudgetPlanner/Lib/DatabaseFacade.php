<?php namespace BudgetPlanner\Lib;

class DatabaseFacade
{
    private $pdo = null;
    public $config = null;

    public function __construct(\PDO $pdo, array $config, array $dbSettings)
    {
        $this->pdo = $pdo;
        $this->config = $config;
        $this->dbSettings = $dbSettings;
    }

    public function createDatabase()
    {
        $this->createDatabaseFile();
        
        $this->pdo->beginTransaction();
        
        $this->deleteDatabase();
        $this->createMigrationTable();

        $scripts = $this->config['databases_setup_scripts'];

        // For initial setup, just run all scripts
        foreach ($scripts as $version => $script) {
            $this->runSqlScript($script);
            
            /*$migration = \ORM::for_table('migration')->create();
            $migration->version = $version;
            $migration->executed = time();
            $migration->save();*/
        }

        $this->pdo->commit();
    }

    public function migrateDatabase()
    {
        $currentVersion = $this->getCurrentVersion();
        $scripts = $this->config['databases_setup_scripts'];

        $this->createMigrationTable();

        // TODO: Integration tests for each consecutive migration scenario
        foreach ($scripts as $version => $script) {
            if ($version <= $currentVersion) {
                continue;
            }


            $this->runSqlScript($script);
            
            /*$migration = \ORM::for_table('migration')->create();
            $migration->version = $version;
            $migration->executed = time();
            $migration->save();*/
        }
    }

    /*public function isMigrationNeeded()
    {
        return $this->getCurrentVersion() < $this->getHighestVersion();
    }

    public function getCurrentVersion()
    {
        try {
            return \ORM::for_table('migration')->max('version');
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getHighestVersion()
    {
        $versions = array_keys($this->config['databases_setup_scripts']);
        return max($versions);
    }*/

    // SQLite hack (eloquent will complain if file doesn't exist, move db facade)
    private function createDatabaseFile() {
        $file = $this->dbSettings['db']['database'];
        if ($file != ":memory:" && !file_exists($file)) {
            touch($file);
        }
    }

    private function deleteDatabase()
    {
        $this->runSqlScript($this->config['drop_tables_script']);
    }

    private function createMigrationTable()
    {
        $this->runSqlScript($this->config['migration_table_script']);
    }

    private function runSqlScript($script)
    {
        $sql = @file_get_contents($script);
        if ($sql === false) {
            throw new \Exception("File not found", 1);
        }
        $this->pdo->exec($sql);
    }
}
