<?php

class AdminAllInOneManagementMysqlTunerController extends ModuleAdminController
{
    private $module_path;

    public function __construct()
    {
        $this->bootstrap = true;
        $this->module          = Module::getInstanceByName('allinonemanagement');
        $this->controller_name = 'AdminAllInOneManagementMysqlTunner';
        $this->module_path = _PS_MODULE_DIR_ . 'allinonemanagement';
        parent::__construct();
    }

    public function initContent()
    {
        $physicalMemory = 8 * 1024 * 1024 * 1024;
        $preferredQueryTime = 5;

        // PDO connection
        $user = _DB_USER_;
        $pass = _DB_PASSWD_;
        $host = _DB_SERVER_;
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

        /* Server version */
        $stmt = $pdo->query("SELECT VERSION() AS version");
        $version = $stmt->fetch()['version'];
        $versionParts = explode(".", $version);
        $majorVersion = $versionParts[0] . "." . $versionParts[1];

        /* Global status */
        $globalStatus = [];
        $stmt = $pdo->query('SHOW GLOBAL STATUS');
        while ($row = $stmt->fetch()) {
            $globalStatus[$row['Variable_name']] = $row['Value'];
        }

        /* Global variables */
        $globalVariables = [];
        $stmt = $pdo->query('SHOW GLOBAL VARIABLES');
        while ($row = $stmt->fetch()) {
            $globalVariables[$row['Variable_name']] = $row['Value'];
        }

        /* Engines */
        $engines = [];
        $stmt = $pdo->query('SELECT Engine, Support, Comment, Transactions, XA, Savepoints FROM information_schema.ENGINES ORDER BY Engine ASC');
        while ($row = $stmt->fetch()) {
            $stmt2 = $pdo->query('SELECT COUNT(*) as count FROM information_schema.tables WHERE table_type = \'BASE TABLE\' and ENGINE = \'' . $row['Engine'] . '\'');
            $row2 = $stmt2->fetch();
            $engines[$row['Engine']] = [
                'Support' => $row['Support'],
                'Comment' => $row['Comment'],
                'Transactions' => $row['Transactions'],
                'XA' => $row['XA'],
                'Savepoints' => $row['Savepoints'],
                'count' => $row2['count'],
            ];
        }

        $logError = $globalVariables['log_error'];

        $questions = $globalStatus['Questions'];
        $uptime = $globalStatus['Uptime'];
        $avgQps = $questions / $uptime;
        $threadsConnected = $globalStatus['Threads_connected'];

        /* Slow queries */
        $slowQueries = $globalStatus['Slow_queries'];
        $logOutput = $globalVariables['log_output'];
        $logQueriesNotUsingIndexes = $globalVariables['log_queries_not_using_indexes'];
        $logSlowAdminStatements = $globalVariables['log_slow_admin_statements'];
        $logSlowDisabledStatements = $globalVariables['log_slow_disabled_statements'];
        $logSlowFilter = $globalVariables['log_slow_filter'];
        $logSlowRateLimit = $globalVariables['log_slow_rate_limit'];
        $logSlowVerbosity = $globalVariables['log_slow_verbosity'];
        $longQueryTime = $globalVariables['long_query_time'];
        $minExaminedRowLimit = $globalVariables['min_examined_row_limit'];
        $slowQueryLog = $globalVariables['slow_query_log'];
        $slowQueryLogFile = $globalVariables['slow_query_log_file'];
        $slowQueriesPct = $this->percentage($slowQueries, $questions);

        /* Binary log */
        $logBin = $globalVariables['log_bin'];
        $maxBinlogSize = $globalVariables['max_binlog_size'];
        $expireLogsDays = $globalVariables['expire_logs_days'];
        $syncBinlog = $globalVariables['sync_binlog'];

        /* Threads */
        $threadsCreated = $globalStatus['Threads_created'];
        $threadsCached = $globalStatus['Threads_cached'];
        $threadHandling = $globalVariables['thread_handling'];
        $threadCacheSize = $globalVariables['thread_cache_size'];
        $historicThreadsPerSec = $threadsCreated / $uptime;
        $connections = $globalStatus['Connections'];
        $threadCacheHitRate = 100 - (($threadsCreated / $connections) * 100);

        /* Used connections */
        $maxConnections = $globalVariables['max_connections'];
        $interactiveTimeout = $globalVariables['interactive_timeout'];
        $waitTimeout = $globalVariables['wait_timeout'];
        $maxUsedConnections = $globalStatus['Max_used_connections'];
        $threadsConnected = $globalStatus['Threads_connected'];
        $maxConnectionsUsage = ($maxUsedConnections * 100 / $maxConnections);
        $abortedConnects = $globalStatus['Aborted_connects'];
        $connections = $globalStatus['Connections'];
        $abortedConnectsPct = $this->percentage($abortedConnects, $connections);

        /* Aria */
        $ariaIndexLength = 0;
        $stmt = $pdo->query("SELECT IFNULL(SUM(INDEX_LENGTH),0) AS index_length FROM information_schema.TABLES WHERE ENGINE='Aria'");
        $ariaIndexLength = $stmt->fetch()['index_length'];

        $ariaBlockSize = $globalVariables['aria_block_size'];
        $ariaPagecacheAgeThreshold = $globalVariables['aria_pagecache_age_threshold'];
        $ariaPagecacheReads = $globalStatus['Aria_pagecache_reads'];
        $ariaPagecacheReadRequests = $globalStatus['Aria_pagecache_read_requests'];
        $ariaKeysFromMemoryPct = 100 - (($ariaPagecacheReads / $ariaPagecacheReadRequests) * 100);

        /* InnoDB */
        $innodbBufferPoolSize = $globalVariables['innodb_buffer_pool_size'];
        $innodbFilePerTable = $globalVariables['innodb_file_per_table'];
        $innodbFastShutdown = $globalVariables['innodb_fast_shutdown'];
        $innodbFlushLogAtTrxCommit = $globalVariables['innodb_flush_log_at_trx_commit'];
        $innodbLogBufferSize = $globalVariables['innodb_log_buffer_size'];
        $innodbLogFileSize = $globalVariables['innodb_log_file_size'];
        $innodbLogFilesInGroup = $globalVariables['innodb_log_files_in_group'];
        $innodbBufferPoolBytesData = $globalStatus['Innodb_buffer_pool_bytes_data'];
        $innodbBufferPoolBytesDirty = $globalStatus['Innodb_buffer_pool_bytes_dirty'];
        $innodbBufferPoolReads = $globalStatus['Innodb_buffer_pool_reads'];
        $innodbBufferPoolReadRequests = $globalStatus['Innodb_buffer_pool_read_requests'];
        $innodbBufferPoolWaitFree = $globalStatus['Innodb_buffer_pool_wait_free'];
        $innodbDataRead = $globalStatus['Innodb_data_read'];
        $innodbDataReads = $globalStatus['Innodb_data_reads'];
        $innodbDataWrites = $globalStatus['Innodb_data_writes'];
        $innodbDataWritten = $globalStatus['Innodb_data_written'];
        $innodbBufferPoolReadRatio = $innodbBufferPoolReads * 100 / $innodbBufferPoolReadRequests;

        /* InnoDB Index Length */
        $innodbIndexLength = 0;
        $stmt = $pdo->query("SELECT IFNULL(SUM(INDEX_LENGTH),0) AS index_length from information_schema.TABLES where ENGINE='InnoDB'");
        $innodbIndexLength = $stmt->fetch()['index_length'];

        /* InnoDB Data Length */
        $innodbDataLength = 0;
        $stmt = $pdo->query("SELECT IFNULL(SUM(DATA_LENGTH),0) AS data_length from information_schema.TABLES where ENGINE='InnoDB'");
        $innodbDataLength = $stmt->fetch()['data_length'];


        if ($innodbIndexLength > 0) {
            $innodbBufferPoolPagesData = $globalStatus['Innodb_buffer_pool_pages_data'];
            $innodbBufferPoolPagesMisc = $globalStatus['Innodb_buffer_pool_pages_misc'];
            $innodbBufferPoolPagesFree = $globalStatus['Innodb_buffer_pool_pages_free'];
            $innodbBufferPoolPagesTotal = $globalStatus['Innodb_buffer_pool_pages_total'];
            $innodbOsLogPendingFsyncs = $globalStatus['Innodb_os_log_pending_fsyncs'];
            $innodbOsLogPendingWrites = $globalStatus['Innodb_os_log_pending_writes'];
            $innodbLogWaits = $globalStatus['Innodb_log_waits'];
            $innodbRowLockTime = $globalStatus['Innodb_row_lock_time'];
            $innodbRowLockWaits = $globalStatus['Innodb_row_lock_waits'];

            $innodbBufferPoolFreePct = $this->percentage($innodbBufferPoolPagesFree, $innodbBufferPoolPagesTotal);
        }

        /* Memory usage */
        $readBufferSize = $globalVariables['read_buffer_size'];
        $readRndBufferSize = $globalVariables['read_rnd_buffer_size'];
        $sortBufferSize = $globalVariables['sort_buffer_size'];
        $threadStack = $globalVariables['thread_stack'];
        $maxConnections = $globalVariables['max_connections'];
        $netBufferLength = $globalVariables['net_buffer_length'];
        $joinBufferSize = $globalVariables['join_buffer_size'];
        $tmpTableSize = $globalVariables['tmp_table_size'];
        $ariaPagecacheBufferSize = $globalVariables['aria_pagecache_buffer_size'];
        $maxHeapTableSize = $globalVariables['max_heap_table_size'];
        $logBin = $globalVariables['log_bin'];
        $maxUsedConnections = $globalStatus['Max_used_connections'];

        if ($logBin == "ON") {
            $binlogCacheSize = $globalVariables['binlog_cache_size'];
        } else {
            $binlogCacheSize = 0;
        }
        if ($maxHeapTableSize < $tmpTableSize) {
            $effectiveTmpTableSize = $maxHeapTableSize;
        } else {
            $effectiveTmpTableSize = $tmpTableSize;
        }

        $perThreadBufferSize = $readBufferSize + $readRndBufferSize + $sortBufferSize + $threadStack + $netBufferLength + $joinBufferSize + $binlogCacheSize;
        $perThreadBuffers = $perThreadBufferSize * $maxConnections;
        $perThreadMaxBuffers = $perThreadBufferSize * $maxUsedConnections;

        $tmpTableSize = $globalVariables['tmp_table_size'];
        $maxHeapTableSize = $globalVariables['max_heap_table_size'];

        $innodbBufferPoolSize = $globalVariables['innodb_buffer_pool_size'];
        if (empty($innodbBufferPoolSize)) $innodbBufferPoolSize = 0;

        // innodb_additional_mem_pool_size deprecated in MariaDB 10.0, Removed in 10.2.2
        //$innodbAdditionalMemPoolSize = $globalVariables['innodb_additional_mem_pool_size'];
        //if (empty($innodbAdditionalMemPoolSize)) $innodbAdditionalMemPoolSize = 0;
        $innodbAdditionalMemPoolSize = 0;

        $innodbLogBufferSize = $globalVariables['innodb_log_buffer_size'];
        if (empty($innodbLogBufferSize)) $innodbLogBufferSize = 0;

        $keyBufferSize = $globalVariables['key_buffer_size'];

        $queryCacheSize = $globalVariables['query_cache_size'];
        if (empty($queryCacheSize)) $queryCacheSize = 0;

        $globalBufferSize = $tmpTableSize + $innodbBufferPoolSize + $innodbAdditionalMemPoolSize + $innodbLogBufferSize + $keyBufferSize + $queryCacheSize + $ariaPagecacheBufferSize;

        $maxMemory = $globalBufferSize + $perThreadMaxBuffers;
        $totalMemory = $globalBufferSize + $perThreadBuffers;

        $pctOfSysMem = $totalMemory * 100 / $physicalMemory;

        /* Key buffer size */
        $keyReadRequests = $globalStatus['Key_read_requests'];
        $keyReads = $globalStatus['Key_reads'];
        $keyBlocksUsed = $globalStatus['Key_blocks_used'];
        $keyBlocksUnused = $globalStatus['Key_blocks_unused'];
        $keyCacheBlockSize = $globalVariables['key_cache_block_size'];
        $keyBufferSize = $globalVariables['key_buffer_size'];
        $dataDir = $globalVariables['datadir'];
        $versionCompileMachine = $globalVariables['version_compile_machine'];

        if ($keyReads == 0) {
            $keyCacheMissRate = 0;
            $keyBufferFreePct = $keyBlocksUnused * $keyCacheBlockSize / $keyBufferSize * 100;
            $keyBufferUsedPct = 100 - $keyBufferFreePct;
            $keyBufferUsed = $keyBufferSize - (($keyBufferSize / 100) * $keyBufferFreePct);
        } else {
            $keyCacheMissRate = $keyReadRequests / $keyReads;
            if (!empty($keyBlocksUnused)) {
                $keyBufferFreePct = $keyBlocksUnused * $keyCacheBlockSize / $keyBufferSize * 100;
                $keyBufferUsedPct = 100 - $keyBufferFreePct;
                $keyBufferUsed = $keyBufferSize - (($keyBufferSize / 100) * $keyBufferFreePct);
            } else {
                $keyBufferFreePct = "Unknown";
            }
        }

        /* MyISAM Index Length */
        $myisamIndexLength = 0;
        $stmt = $pdo->query("SELECT IFNULL(SUM(INDEX_LENGTH),0) AS index_length FROM information_schema.TABLES WHERE ENGINE='MyISAM'");
        $myisamIndexLength = $stmt->fetch()['index_length'];

        /* Query cache */
        $queryCacheType = $globalVariables['query_cache_type'];
        $queryCacheSize = $globalVariables['query_cache_size'];
        $queryCacheLimit = $globalVariables['query_cache_limit'];
        $queryCacheMinResUnit = $globalVariables['query_cache_min_res_unit'];
        $qcacheHits = $globalStatus['Qcache_hits'];
        $comSelect = $globalStatus['Com_select'];
        $qcacheFreeMemory = $globalStatus['Qcache_free_memory'];
        $qcacheTotalBlocks = $globalStatus['Qcache_total_blocks'];
        $qcacheFreeBlocks = $globalStatus['Qcache_free_blocks'];
        $qcacheLowmemPrunes = $globalStatus['Qcache_lowmem_prunes'];

        $qcacheUsedMemory = $queryCacheSize - $qcacheFreeMemory;
        $queryCacheUsage = ($queryCacheSize > 0) ? $this->percentage($qcacheUsedMemory, $queryCacheSize) : 0;
        $queryCacheEfficiency = $qcacheHits / ($comSelect + $qcacheHits);

        /* Sort operations */
        $sortMergePasses = $globalStatus['Sort_merge_passes'];
        $sortScan = $globalStatus['Sort_scan'];
        $sortRange = $globalStatus['Sort_range'];
        $sortBufferSize = $globalVariables['sort_buffer_size'];
        $readRndBufferSize = $globalVariables['read_rnd_buffer_size'];
        $totalSorts = $sortScan + $sortRange;
        $tempSortTablePct = ($sortMergePasses > 0) ? $this->percentage($sortMergePasses, $totalSorts) : 0;

        /* Joins */
        $selectFullJoin = $globalStatus['Select_full_join'];
        $selectRangeCheck = $globalStatus['Select_range_check'];
        $joinsWithoutIndexesPerDay = ($selectFullJoin + $selectRangeCheck) / ($uptime / 86400);
        $joinBufferSize = $globalVariables['join_buffer_size'];

        /* Open files limit */
        $openFilesLimit = $globalVariables['open_files_limit'];
        $openFiles = $globalStatus['Open_files'];
        $openFilesRatio = $openFiles * 100 / $openFilesLimit;

        /* Table cache */
        $dataDir = $globalVariables['datadir'];
        $tableOpenCache = $globalVariables['table_open_cache'];
        $tableOpenCacheInstances = $globalVariables['table_open_cache_instances'];
        $tableDefinitionCache = $globalVariables['table_definition_cache'];
        $openTables = $globalStatus['Open_tables'];
        $openedTables = $globalStatus['Opened_tables'];
        $openTableDefinitions = $globalStatus['Open_table_definitions'];

        $tableCount = 0;
        $stmt = $pdo->query("SELECT COUNT(*) AS table_count FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE'");
        $tableCount = $stmt->fetch()['table_count'];

        if ($openedTables != 0 && $tableOpenCache != 0) {
            $tableCacheHitRate = $openTables * 100 / $openedTables;
            $tableCacheUsage = $this->percentage($openTables, $tableOpenCache);
        } elseif ($openedTables == 0 && $tableOpenCache != 0) {
            $tableCacheHitRate = 100;
            $tableCacheUsage = $this->percentage($openTables, $tableOpenCache);
        } else {
            $tableCacheError = true;
        }
        $tableDefinitionCacheUsage = $this->percentage($openTableDefinitions, $tableDefinitionCache);

        /* Temp tables */
        $createdTmpTables = $globalStatus['Created_tmp_tables'];
        $createdTmpDiskTables = $globalStatus['Created_tmp_disk_tables'];
        $tmpTableSize = $globalVariables['tmp_table_size'];
        $maxHeapTableSize = $globalVariables['max_heap_table_size'];
        $tmpDiskTablesPct = ($createdTmpTables == 0) ? 0 : $createdTmpDiskTables * 100 / ($createdTmpTables + $createdTmpDiskTables);

        /* Table scans */
        $comSelect = $globalStatus['Com_select'];
        $handlerReadRndNext = $globalStatus['Handler_read_rnd_next'];
        $readBufferSize = $globalVariables['read_buffer_size'];

        if ($comSelect > 0) {
            $fullTableScans = $handlerReadRndNext / $comSelect;
        }

        /* Table locking */
        $tableLocksWaited = $globalStatus['Table_locks_waited'];
        $tableLocksImmediate = $globalStatus['Table_locks_immediate'];
        $concurrentInsert = $globalVariables['concurrent_insert'];
        $lowPriorityUpdates = $globalVariables['low_priority_updates'];

        $tableLocksWaitedPct = $this->percentage($tableLocksWaited, $tableLocksImmediate);

        $immediateLocksMissRate = ($tableLocksWaited > 0) ? $tableLocksImmediate / $tableLocksWaited : 99999;

        $this->context->smarty->assign(
            array(
                'host' => $host,
                'user' => $user,
                'version' => $version,
                'majorVersion' => $majorVersion,
                'versionCompileMachine' => $versionCompileMachine,
                'dataDir' => $dataDir,
                'logError' => $logError,
                'uptime' => $uptime,
                'uptimeHrt' => $this->human_readable_time($uptime),
                'questions' => $questions,
                'avgQps' => round($avgQps, 1),
                'threadsConnected' => $threadsConnected,
                'engines' => $engines,
                'slowQueryLog' => $slowQueryLog,
                'alert_check' => $this->alert_check(),
                'alert_warning' => $this->alert_warning(),
                'alert_error' => $this->alert_error(),
                'alert_info' => $this->alert_info(),
                'slowQueries' => $slowQueries,
                'questions' => $questions,
                'slowQueriesPct' => $slowQueriesPct,
                'longQueryTime' => $longQueryTime,
                'preferredQueryTime' => $preferredQueryTime,
                'logOutput' => $logOutput,
                'slowQueryLogFile' => $slowQueryLogFile,
                'logQueriesNotUsingIndexes' => $logQueriesNotUsingIndexes,
                'logSlowAdminStatements' => $logSlowAdminStatements,
                'logSlowDisabledStatements' => $logSlowDisabledStatements,
                'minExaminedRowLimit' => $minExaminedRowLimit,
                'logSlowRateLimit' => $logSlowRateLimit,
                'logSlowVerbosity' => $logSlowVerbosity,
                'logSlowFilterString' => $this->human_readable_comma_enum('admin, filesort, filesort_on_disk, full_join, full_scan, query_cache, query_cache_miss, tmp_table, tmp_table_on_disk'),
                'logSlowFilter' => $this->human_readable_comma_enum($logSlowFilter),
                'logBin' => $logBin,
                'maxBinlogSize' => $maxBinlogSize,
                'expireLogsDays' => $expireLogsDays,
                'syncBinlog' => $syncBinlog,
                'maxBinlogSizeHrb' => $this->human_readable_bytes($maxBinlogSize),
                'threadHandling' => $threadHandling,
                'threadCacheSize' => $threadCacheSize,
                'threadsCached' => $threadsCached,
                'historicThreadsPerSec' => $historicThreadsPerSec,
                'threadCacheHitRate' => $threadCacheHitRate,
                'maxConnections' => $maxConnections,
                'maxUsedConnections' => $maxUsedConnections,
                'maxConnectionsUsage' => $maxConnectionsUsage,
                'abortedConnects' => $abortedConnects,
                'abortedConnectsPct' => $abortedConnectsPct,
                'interactiveTimeout' => $interactiveTimeout,
                'interactiveTimeoutHrt' => $this->human_readable_time($interactiveTimeout),
                'waitTimeout' => $waitTimeout,
                'waitTimeoutHrt' => $this->human_readable_time($waitTimeout),
                'ariaIndexLength' => $this->human_readable_time($ariaIndexLength),
                'ariaPagecacheBufferSizeHrb' => $this->human_readable_bytes($ariaPagecacheBufferSize),
                'ariaPagecacheBufferSize' => $ariaPagecacheBufferSize,
                'ariaPagecacheReadRequests' => $ariaPagecacheReadRequests,
                'ariaPagecacheReads' => $ariaPagecacheReads,
                'ariaKeysFromMemoryPct' => $ariaKeysFromMemoryPct,
                'ariaBlockSize' => $ariaBlockSize,
                'ariaBlockSizeHrb' => $this->human_readable_bytes($ariaBlockSize),
                'ariaPagecacheAgeThreshold' => $ariaPagecacheAgeThreshold,
                'ariaPagecacheAgeThresholdHrt' => $this->human_readable_time($ariaPagecacheAgeThreshold),
                'innodbIndexLengthHrb' => $this->human_readable_bytes($innodbIndexLength),
                'innodbDataLengthHrb' => $this->human_readable_bytes($innodbDataLength),
                'innodbDataRead' => $innodbDataRead,
                'innodbDataReadHrb' => $this->human_readable_bytes($innodbDataRead),
                'innodbDataWrittenHrb' => $this->human_readable_bytes($innodbDataWritten),
                'innodbDataReads' => $innodbDataReads,
                'innodbDataWrites' => $innodbDataWrites,
                'innodbBufferPoolSizeHrb' => $this->human_readable_bytes($innodbBufferPoolSize),
                'innodbBufferPoolSize' => $innodbBufferPoolSize,
                'innodbBufferPoolFreePct' => $innodbBufferPoolFreePct,
                'innodbBufferPoolBytesData' => $innodbBufferPoolBytesData,
                'innodbBufferPoolBytesDataHrb' => $this->human_readable_bytes($innodbBufferPoolBytesData),
                'innodbBufferPoolBytesDirty' => $innodbBufferPoolBytesDirty,
                'innodbBufferPoolBytesDirtyHrb' => $this->human_readable_bytes($innodbBufferPoolBytesDirty),
                'innodbBufferPoolReadRequests' => $innodbBufferPoolReadRequests,
                'innodbBufferPoolReads' => $innodbBufferPoolReads,
                'innodbBufferPoolReadRatio' => $innodbBufferPoolReadRatio,
                'innodbBufferPoolWaitFree' => $innodbBufferPoolWaitFree,
                'innodbRowLockTime' => $innodbRowLockTime,
                'innodbRowLockWaits' => $innodbRowLockWaits,
                'innodbFastShutdown' => $innodbFastShutdown,
                'innodbFilePerTable' => $innodbFilePerTable,
                'innodbFlushLogAtTrxCommit' => $innodbFlushLogAtTrxCommit,
                'innodbLogBufferSizeHrb' => $this->human_readable_bytes($innodbLogBufferSize),
                'innodbLogBufferSize' => $innodbLogBufferSize,
                'innodbLogFileSizeHrb' => $this->human_readable_bytes($innodbLogFileSize),
                'innodbLogFileSize' => $innodbLogFileSize,
                'innodbLogFilesInGroup' => $innodbLogFilesInGroup,
                'physicalMemoryHrb' => $this->human_readable_bytes($physicalMemory),
                'globalBufferSize' => $globalBufferSize,
                'globalBufferSizeHrb' => $this->human_readable_bytes($globalBufferSize),
                'perThreadBufferSize' => $perThreadBufferSize,
                'perThreadBufferSizeHrb' => $this->human_readable_bytes($perThreadBufferSize),
                'totalMemoryHrb' => $this->human_readable_bytes($totalMemory),
                'maxMemoryHrb' => $this->human_readable_bytes($maxMemory),
                'pctOfSysMem' => $pctOfSysMem,
                'tmpTableSize' => $tmpTableSize,
                'tmpTableSizeHrb' => $this->human_readable_bytes($tmpTableSize),
                'innodbAdditionalMemPoolSize' => $innodbAdditionalMemPoolSize,
                'keyBufferSize' => $keyBufferSize,
                'keyBufferSizeHrb' => $this->human_readable_bytes($keyBufferSize),
                'queryCacheSize' => $queryCacheSize,
                'queryCacheSizeHrb' => $this->human_readable_bytes($queryCacheSize),
                'readBufferSize' => $readBufferSize,
                'readBufferSizeHrb' => $this->human_readable_bytes($readBufferSize),
                'readRndBufferSize' => $readRndBufferSize,
                'readRndBufferSizeHrb' => $this->human_readable_bytes($readRndBufferSize),
                'sortBufferSize' => $sortBufferSize,
                'sortBufferSizeHrb' => $this->human_readable_bytes($sortBufferSize),
                'threadStack' => $threadStack,
                'threadStackHrb' => $this->human_readable_bytes($threadStack),
                'netBufferLength' => $netBufferLength,
                'netBufferLengthHrb' => $this->human_readable_bytes($netBufferLength),
                'joinBufferSize' => $joinBufferSize,
                'joinBufferSizeHrb' => $this->human_readable_bytes($joinBufferSize),
                'binlogCacheSize' => $binlogCacheSize,
                'perThreadBuffersHrb' => $this->human_readable_bytes($perThreadBuffers),
                'perThreadMaxBuffersHrb' => $this->human_readable_bytes($perThreadMaxBuffers),
                'myisamIndexLengthHrb' => $this->human_readable_bytes($myisamIndexLength),
                'keyCacheMissRate' => $keyCacheMissRate,
                'keyBufferFreePct' => $keyBufferFreePct,
                'keyBufferUsed' => $keyBufferUsed,
                'keyBufferUsedHrb' => $this->human_readable_bytes($keyBufferUsed),
                'keyBufferUsedPct' => $keyBufferUsedPct,
                'keyCacheBlockSize' => $keyCacheBlockSize,
                'keyCacheBlockSizeHrb' => $this->human_readable_bytes($keyCacheBlockSize),
                'keyReads' => $keyReads,
                'queryCacheType' => $queryCacheType,
                'qcacheUsedMemoryHrb' => $this->human_readable_bytes($qcacheUsedMemory),
                'queryCacheUsage' => $queryCacheUsage,
                'queryCacheEfficiency' => $queryCacheEfficiency,
                'queryCacheLimit' => $queryCacheLimit,
                'queryCacheLimitHrb' => $this->human_readable_bytes($queryCacheLimit),
                'queryCacheMinResUnit' => $queryCacheMinResUnit,
                'queryCacheMinResUnitHrb' => $this->human_readable_bytes($queryCacheMinResUnit),
                'sortMergePasses' => $sortMergePasses,
                'tempSortTablePct' => $tempSortTablePct,
                'totalSorts' => $totalSorts,
                'selectFullJoin' => $selectFullJoin,
                'selectRangeCheck' => $selectRangeCheck,
                'joinsWithoutIndexesPerDay' => $joinsWithoutIndexesPerDay,
                'openFilesLimit' => $openFilesLimit,
                'openFiles' => $openFiles,
                'openFilesRatio' => $openFilesRatio,
                'tableCount' => $tableCount,
                'openTables' => $openTables,
                'tableOpenCache' => $tableOpenCache,
                'tableCacheUsage' => $tableCacheUsage,
                'openTableDefinitions' => $openTableDefinitions,
                'tableDefinitionCache' => $tableDefinitionCache,
                'tableDefinitionCacheUsage' => $tableDefinitionCacheUsage,
                'tableCacheHitRate' => $tableCacheHitRate,
                'openedTables' => $openedTables,
                'tableOpenCacheInstances' => $tableOpenCacheInstances,
                'maxHeapTableSize' => $maxHeapTableSize,
                'maxHeapTableSizeHrb' => $this->human_readable_bytes($maxHeapTableSize),
                'createdTmpTables' => $createdTmpTables,
                'createdTmpDiskTables' => $createdTmpDiskTables,
                'tmpDiskTablesPct' => $tmpDiskTablesPct,
                'fullTableScans' => $fullTableScans,
                'comSelect' => $comSelect,
                'tableLocksImmediate' => $tableLocksImmediate,
                'tableLocksWaited' => $tableLocksWaited,
                'tableLocksWaitedPct' => $tableLocksWaitedPct,
                'immediateLocksMissRate' => $immediateLocksMissRate,
                'concurrentInsert' => $concurrentInsert,
                'lowPriorityUpdates' => $lowPriorityUpdates,
                'globalStatus' => $globalStatus,
                'globalVariables' => $globalVariables,
            )
        );

        // Render the template with the documents
        $this->content = $this->context->smarty->fetch(
            _PS_MODULE_DIR_ . 'allinonemanagement/views/templates/admin/mysqltuner.tpl'
        );

        parent::initContent();
    }

    private function human_readable_bytes($number)
    {
        if ($number >= 1024 * 1024 * 1024) {
            return round($number / (1024 * 1024 * 1024), 1) . " GB";
        } elseif ($number >= 1024 * 1024) {
            return round($number / (1024 * 1024), 1) . " MB";
        } elseif ($number >= 1024) {
            return round($number / (1024), 1) . " KB";
        } else {
            return $number . " bytes";
        }
    }

    private function human_readable_time($seconds)
    {
        $time = "";

        $days = floor($seconds / 86400);
        if ($days > 0) {
            $time .= $days . " days,";
        }
        $hours = $seconds / 3600 % 24;
        if ($hours > 0) {
            $time .= $hours . " hours,";
        }

        $minutes =  $seconds / 60 % 60;
        if ($minutes > 0) {
            $time .= $minutes . " min";
        }
        return $time;
    }

    private function human_readable_comma_enum($string)
    {
        $parts = explode(",", $string);
        $list = "<ul>";
        foreach ($parts as $part) {
            $list .= "<li>" . trim($part) . "</li>";
        }
        $list .= "</ul>";
        return $list;
    }

    private function percentage($value, $total = 0)
    {
        if ($total == 0) return 100;
        return ($value * 100 / $total);
    }

    private function alert_check()
    {
        return "<svg width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" class=\"bi bi-check float-right mt-1 text-success\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\">\n"
            . "<path fill-rule=\"evenodd\" d=\"M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z\"/>\n"
            . "</svg>";
    }

    private function alert_error()
    {
        return "<svg width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" class=\"bi bi-exclamation-octagon-fill float-right mt-1 text-danger\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\">\n"
            . "<path fill-rule=\"evenodd\" d=\"M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z\"/>\n"
            . "</svg>";
    }

    private function alert_info()
    {
        return "<svg width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" class=\"bi bi-info-circle-fill float-right mt-1 text-info\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\">\n"
            . "<path fill-rule=\"evenodd\" d=\"M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z\"/>\n"
            . "</svg>";
    }

    private function alert_warning()
    {
        return "<svg width=\"1.0625em\" height=\"1em\" viewBox=\"0 0 17 16\" class=\"bi bi-exclamation-triangle-fill float-right mt-1 text-warning\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\">\n"
            . "<path fill-rule=\"evenodd\" d=\"M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 5zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z\"/>\n"
            . "</svg>";
    }
}
