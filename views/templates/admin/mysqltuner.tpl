{*
* 2007-2023 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2023 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<style>
	body {
		background-color: rgb(241, 244, 246);
	}

	.table-sm th,
	.table-sm td {
		font-size: .9em;
		padding: 1px;
	}

	.container .row+.row {
		margin-top: 1em;
	}

	.footer {
		background-color: #18171b;
	}

	.footer h5,
	.footer li {
		font-size: .9em;
		color: darkgrey;
	}

	.footer .nav-item a {
		color: darkgrey;
	}

	td:nth-child(2) {
		word-break: break-all;
	}

	.shadow-sm {
		box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
	}

	.bg-dark {
		background-color: #343a40 !important;
	}

	.border-0 {
		border: 0 !important;
	}

	.card {
		position: relative;
		display: -ms-flexbox;
		display: flex;
		-ms-flex-direction: column;
		flex-direction: column;
		min-width: 0;
		word-wrap: break-word;
		background-color: #fff;
		background-clip: border-box;
		border: 1px solid rgba(0, 0, 0, .125);
		border-radius: .25rem;
	}

	.card-header:first-child {
		border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
	}

	.card-header {
		background-color: white;
		text-transform: uppercase;
		color: rgba(13, 27, 62, 0.5);
		font-weight: bold;
		padding: 0.75rem 1.25rem;
		margin-bottom: 0;
		border-bottom: 1px solid rgba(0, 0, 0, .125);
	}

	.card-body {
		-ms-flex: 1 1 auto;
		flex: 1 1 auto;
		padding: 1.25rem;
	}

	.navbar {
		position: relative;
		display: -ms-flexbox;
		display: flex;
		-ms-flex-wrap: wrap;
		flex-wrap: wrap;
		-ms-flex-align: center;
		align-items: center;
		-ms-flex-pack: justify;
		justify-content: space-between;
		padding: .5rem 1rem;
	}

	@media (min-width: 992px) {
		.navbar-expand-lg {
			-ms-flex-flow: row nowrap;
			flex-flow: row nowrap;
			-ms-flex-pack: start;
			justify-content: flex-start;
		}

		.navbar-expand-lg .navbar-toggler {
			display: none;
		}

		.navbar-expand-lg .navbar-collapse {
			display: -ms-flexbox !important;
			display: flex !important;
			-ms-flex-preferred-size: auto;
			flex-basis: auto;
		}

		.navbar-expand-lg .navbar-nav {
			-ms-flex-direction: row;
			flex-direction: row;
		}

		.navbar-expand-lg .navbar-nav .nav-link {
			padding-right: .5rem;
			padding-left: .5rem;
		}
	}

	.navbar-dark .navbar-brand {
		color: #fff;
	}

	.navbar-nav {
		display: -ms-flexbox;
		display: flex;
		-ms-flex-direction: column;
		flex-direction: column;
		padding-left: 0;
		margin-bottom: 0;
		list-style: none;
	}

	.mr-auto,
	.mx-auto {
		margin-right: auto !important;
	}

	.float-right {
		float: right !important;
	}

	.mt-1,
	.my-1 {
		margin-top: .25rem !important;
	}

	.dropdown,
	.dropleft,
	.dropright,
	.dropup {
		position: relative;
	}

	.navbar-brand {
		display: inline-block;
		padding-top: .3125rem;
		padding-bottom: .3125rem;
		margin-right: 1rem;
		font-size: 1.25rem;
		line-height: inherit;
		white-space: nowrap;
	}

	.navbar-toggler:not(:disabled):not(.disabled) {
		cursor: pointer;
	}

	.navbar-dark .navbar-toggler {
		color: rgba(255, 255, 255, .5);
		border-color: rgba(255, 255, 255, .1);
	}

	.navbar-toggler {
		padding: .25rem .75rem;
		font-size: 1.25rem;
		line-height: 1;
		background-color: transparent;
		border: 1px solid transparent;
		border-radius: .25rem;
	}

	.navbar-dark .navbar-toggler-icon {
		background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
	}

	.navbar-toggler-icon {
		display: inline-block;
		width: 1.5em;
		height: 1.5em;
		vertical-align: middle;
		content: "";
		background: no-repeat center center;
		background-size: 100% 100%;
	}

	.navbar-dark .navbar-nav .nav-link {
		color: rgba(255, 255, 255, .5);
	}

	.nav-link {
		display: block;
		padding: .5rem 1rem;
	}

	.dropdown-item {
		display: block;
		width: 100%;
		padding: .25rem 1.5rem;
		clear: both;
		font-weight: 400;
		color: #212529;
		text-align: inherit;
		white-space: nowrap;
		background-color: transparent;
		border: 0;
	}

	.text-warning {
		color: #ffc107 !important;
	}

	.dropdown-toggle::after {
		display: inline-block;
		width: 0;
		height: 0;
		margin-left: .255em;
		vertical-align: .255em;
		content: "";
		border-top: .3em solid;
		border-right: .3em solid transparent;
		border-bottom: 0;
		border-left: .3em solid transparent;
	}

	.text-light {
		color: #f8f9fa !important;
	}

	.mt-4,
	.my-4 {
		margin-top: 1.5rem !important;
	}

	.mb-3,
	.my-3 {
		margin-bottom: 1rem !important;
	}

	.mt-3,
	.my-3 {
		margin-top: 1rem !important;
	}

	.flex-column {
		-ms-flex-direction: column !important;
		flex-direction: column !important;
	}
</style>
<div class='container'>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
		<a class="navbar-brand" href="#">
			<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calculator text-warning" fill="currentColor"
				xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd"
					d="M12 1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z" />
				<path
					d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z" />
			</svg>
			MySQL-Tuner-PHP <small>0.3</small></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
			aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarMisc" role="button" data-toggle="dropdown"
						aria-haspopup="true" aria-expanded="false">
						Misc
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarMisc">
						<a class="dropdown-item" href="#database_engines">Database engines</a>
						<a class="dropdown-item" href="#slow_queries">Slow queries</a>
						<a class="dropdown-item" href="#binary_log">Binary log</a>
						<a class="dropdown-item" href="#threads">Threads</a>
						<a class="dropdown-item" href="#used_connections">Used connections</a>
						<a class="dropdown-item" href="#innodb">InnoDB</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarMemory" role="button" data-toggle="dropdown"
						aria-haspopup="true" aria-expanded="false">
						Memory
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarMemory">
						<a class="dropdown-item" href="#memory_usage">Memory used</a>
						<a class="dropdown-item" href="#key_buffer">Key buffer</a>
						<a class="dropdown-item" href="#query_cache">Query cache</a>
						<a class="dropdown-item" href="#sort_operations">Sort operations</a>
						<a class="dropdown-item" href="#join_operations">Join operations</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarFile" role="button" data-toggle="dropdown"
						aria-haspopup="true" aria-expanded="false">
						File
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarFile">
						<a class="dropdown-item" href="#open_files">Open files</a>
						<a class="dropdown-item" href="#table_cache">Table cache</a>
						<a class="dropdown-item" href="#temp_tables">Temp. tables</a>
						<a class="dropdown-item" href="#table_scans">Table scans</a>
						<a class="dropdown-item" href="#table_locking">Table locking</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#status_variables">Status vars</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#system_variables">System vars</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class='row'>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Host:</td>
									<td>{$host}</td>
								</tr>
								<tr>
									<td>User:</td>
									<td>{$user}</td>
								</tr>
							</table>
						</div>
					</div>
					<div class='row'>
						<div class='col-sm-6'>
							<table class='table table-sm'>
								<tr>
									<td>Server version:</td>
									<td>{$version}</td>
								</tr>
								<tr>
									<td>Major version:</td>
									<td>{$majorVersion}</td>
								</tr>
								<tr>
									<td>Compile machine:</td>
									<td>{$versionCompileMachine}</td>
								</tr>
								<tr>
									<td>Data dir:</td>
									<td><samp>{$dataDir}</samp></td>
								</tr>
								<tr>
									<td>Error log:</td>
									<td><samp>{$logError}</samp></td>
								</tr>
							</table>
						</div>
						<div class='col-sm-6'>
							<table class='table table-sm'>
								<tr>
									<td>Uptime:</td>
									<td>{$uptime} seconds</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>{$uptimeHrt}</td>
								</tr>
								<tr>
									<td>Questions:</td>
									<td>{$questions}</td>
								</tr>
								<tr>
									<td>Avg. qps:</td>
									<td>{$avgQps}</td>
								</tr>
								<tr>
									<td>Threads connected:</td>
									<td>{$threadsConnected}</td>
								</tr>
							</table>
						</div>
					</div>
					{if $uptime < 172800}
						<div class="alert alert-danger" role="alert">
							Server has not been running for at least 48hrs. It may not be safe to use these
							recommendations!
						</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='database_engines' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Database engines</div>
				<div class='card-body'>
					<table class='table table-sm'>
						<tr>
							<th>Engine</th>
							<th>Support</th>
							<th>Comment</th>
							<th>Transactions</th>
							<th>XA</th>
							<th>Savepoints</th>
							<th># Tables</th>
						</tr>
						{foreach $engines as $engineName => $engineConfig}
							<tr>
								<td>{$engineName}</td>
								<td>{$engineConfig.Support}</td>
								<td>{$engineConfig.Comment}</td>
								<td>{$engineConfig.Transactions}</td>
								<td>{$engineConfig.XA}</td>
								<td>{$engineConfig.Savepoints}</td>
								<td>{$engineConfig.count}</td>
							</tr>
						{/foreach}
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='slow_queries' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Slow queries</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
							<p>The slow query log is a record of SQL queries that took a long time to perform. Note
								that, if
								your queries contain user's passwords, the slow query log may contain passwords too.
								Thus, it
								should be protected.</p>
							<p>More information on the Slow Query Log:<br>
								<a href='https://mariadb.com/kb/en/slow-query-log-overview/'
									target='_blank'>https://mariadb.com/kb/en/slow-query-log-overview/</a>
							</p>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Slow query log:</td>
									<td>{$slowQueryLog}
										{if $slowQueryLog == 'ON'}
										{$alert_check}
										{elseif $slowQueryLog == "OFF" or empty($slowQueryLog)}
										{$alert_warning}
										{/if}
									</td>
								</tr>
								<tr>
									<td>Slow query count:</td>
									<td>{$slowQueries} of {$questions}<br>{$slowQueriesPct|round} %
										{if $slowQueriesPct > 5}
										{$alert_error}
										{else}
										{$alert_check}
										{/if}
									</td>
								</tr>
								<tr>
									<td>Long query time:</td>
									<td>{$longQueryTime|round}
										sec.{if $longQueryTime > $preferredQueryTime}{$alert_info}{/if}
									</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>slow_query_log</samp></td>
							<td>0</td>
							<td>{$slowQueryLog}</td>
						</tr>
						<tr>
							<td><samp>log_output</samp></td>
							<td>FILE</td>
							<td>{$logOutput}</td>
						</tr>
						<tr>
							<td><samp>slow_query_log_file</samp></td>
							<td><i>host_name</i>-slow.log</td>
							<td>{$slowQueryLogFile}</td>
						</tr>
						<tr>
							<td><samp>long_query_time</samp></td>
							<td>10.000000</td>
							<td>{$longQueryTime}</td>
						</tr>
						<tr>
							<td><samp>log_queries_not_using_indexes</samp></td>
							<td>OFF</td>
							<td>{$logQueriesNotUsingIndexes}</td>
						</tr>
						<tr>
							<td><samp>log_slow_admin_statements</samp></td>
							<td>ON <span class='text-muted'>(>= MariaDB 10.2.4)</span><br>OFF <span class='text-muted'>(
									<= MariaDB 10.2.3)</span>
							</td>
							<td>{$logSlowAdminStatements}</td>
						</tr>
						<tr>
							<td><samp>log_slow_disabled_statements</samp></td>
							<td>sp</td>
							<td>{$logSlowDisabledStatements}</td>
						</tr>
						<tr>
							<td><samp>min_examined_row_limit</samp></td>
							<td>0</td>
							<td>{$minExaminedRowLimit}</td>
						</tr>
						<tr>
							<td><samp>log_slow_rate_limit</samp></td>
							<td>1</td>
							<td>{$logSlowRateLimit}</td>
						</tr>
						<tr>
							<td><samp>log_slow_verbosity</samp></td>
							<td><i>(empty)</i></td>
							<td>{$logSlowVerbosity}</td>
						</tr>
						<tr>
							<td><samp>log_slow_filter</samp></td>
							<td>{$logSlowFilterString}</td>
							<td>{$logSlowFilter}</td>
						</tr>
					</table>
					{if $slowQueryLog == "OFF" or empty($slowQueryLog)}
					<div class="alert alert-warning" role="alert">
						Your Slow Query Log is NOT enabled. Enable the Slow Query Log to examine slow queries which
						execution time exceeds the value of <samp>long_query_time</samp>.
					</div>
					{/if}
					{if $longQueryTime > $preferredQueryTime}
					<div class="alert alert-info" role="alert">
						Configure <samp>long_query_time</samp> to a lower value, to investigate your slow queries
						even better. Recommendation: {$preferredQueryTime} sec.
					</div>
					{elseif $longQueryTime|round == 0}
					<div class="alert alert-warning" role="alert">
						Configure <samp>long_query_time</samp> to a higher value. The current setting of zero, will
						cause ALL queries to be logged! If you actually want to log all queries, use the query log,
						not the slow query log.
					</div>
					{/if}
					{if $slowQueriesPct > 5}
					<div class="alert alert-danger" role="alert">
						More than 5 percent of all queries is slower than the configured
						<samp>long_query_time</samp> of {$longQueryTime} seconds.
					</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='binary_log' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Binary log</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
							<p>The binary log contains a record of all changes to the databases, both data and
								structure, as well as how long each statement took to execute. It consists of a set of
								binary log files and an index.</p>
							<p>More information on the Binary Log:<br>
								<a href='https://mariadb.com/kb/en/overview-of-the-binary-log/'
									target='_blank'>https://mariadb.com/kb/en/overview-of-the-binary-log/</a>
							</p>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Log bin:</td>
									<td>{$logBin}
										{if $logBin == "ON"}
										{$alert_check}
										{else}
										{$alert_info}
										{/if}
									</td>
								</tr>
								<tr>
									<td>Max binlog size:</td>
									<td>{$maxBinlogSizeHrb}</td>
								</tr>
								<tr>
									<td>Expire logs days:</td>
									<td>{$expireLogsDays}</td>
								</tr>
								<tr>
									<td>Sync binlog:</td>
									<td>{$syncBinlog}</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>log_bin</samp></td>
							<td>OFF</td>
							<td>{$logBin}</td>
						</tr>
						<tr>
							<td><samp>max_binlog_size</samp></td>
							<td>1073741824 <span class='text-muted'>(1 GB)</span></td>
							<td>{$maxBinlogSize} <span class='text-muted'>({$maxBinlogSizeHrb})</span></td>
						</tr>
						<tr>
							<td><samp>expire_logs_days</samp></td>
							<td>0</td>
							<td>{$expireLogsDays}</td>
						</tr>
						<tr>
							<td><samp>sync_binlog</samp></td>
							<td>0</td>
							<td>{$syncBinlog}</td>
						</tr>
					</table>
					{if $logBin != "ON"}
					<div class="alert alert-info" role="alert">
						The binary log is not enabled.
					</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='threads' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Threads</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
							<p>Connection manager threads handle client connection requests on the network interfaces
								that the server listens to. On all platforms, one manager thread handles TCP/IP
								connection requests. On Unix, this manager thread also handles Unix socket file
								connection requests. On Windows, a manager thread handles shared-memory connection
								requests, and another handles named-pipe connection requests. The server does not create
								threads to handle interfaces that it does not listen to. For example, a Windows server
								that does not have support for named-pipe connections enabled does not create a thread
								to handle them.</p>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Thread handling:</td>
									<td>{$threadHandling}</td>
								</tr>
								<tr>
									<td>Thread cache size:</td>
									<td>{$threadCacheSize}</td>
								</tr>
								<tr>
									<td>Threads cached:</td>
									<td>{$threadsCached}</td>
								</tr>
								<tr>
									<td>Threads per sec. avg.:</td>
									<td>{$historicThreadsPerSec|round:2}</td>
								</tr>
								<tr>
									<td>Thread cache hit rate:</td>
									<td>{$threadCacheHitRate|round:1} %
										{if $threadCacheHitRate > 50}
										{$alert_check}
										{else}
										{$alert_warning}
										{/if}
									</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>thread_cache_size</samp></td>
							<td>0 <span class='text-muted'>(<= MariaDB 10.1)</span><br>256 <span
											class='text-muted'>(from MariaDB 10.2.0)</span>
							</td>
							<td>{$threadCacheSize}</td>
						</tr>
						<tr>
							<td><samp>thread_handling</samp></td>
							<td>one-thread-per-connection</td>
							<td>{$threadHandling}</td>
						</tr>
					</table>
					{if $threadCacheSize == 0 && $threadHandling != "pool-of-threads"}
					<div class="alert alert-danger" role="alert">
						Thread cache is disabled. Set <samp>thread_cache_size</samp> to 4 as a starting value.
					</div>
					{/if}
					{if $historicThreadsPerSec > 2 && $threadsCached < 1}
					<div class="alert alert-danger" role="alert">
						Threads created per/sec are overrunning threads cached
					</div>
					{/if}
					{if $threadCacheHitRate <= 50}
					<div class="alert alert-danger" role="alert">
						Too many threads can not be used from cache. Raise the <samp>thread_cache_size</samp> until
						this indicator stays over 50% over a longer period.
					</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='used_connections' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Used connections</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Max connections:</td>
									<td>{$maxConnections}</td>
								</tr>
								<tr>
									<td>Threads connected:</td>
									<td>{$threadsConnected}</td>
								</tr>
								<tr>
									<td>Max used connections:</td>
									<td>{$maxUsedConnections}{if $maxConnectionsUsage < 10} {$alert_info}{/if}
										<br>
										{$maxConnectionsUsage|round:1} %
										{if $maxConnectionsUsage > 85}
										{$alert_error}
										{else}
										{$alert_check}
										{/if}
									</td>
								</tr>
								<tr>
									<td>Aborted connects:</td>
									<td>{$abortedConnects}<br>{$abortedConnectsPct|round:1} %</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>interactive_timeout</samp></td>
							<td>28800</td>
							<td>{$interactiveTimeout} <span class='text-muted'>({$interactiveTimeoutHrt})</span></td>
						</tr>
						<tr>
							<td><samp>max_connections</samp></td>
							<td>151</td>
							<td>{$maxConnections}</td>
						</tr>
						<tr>
							<td><samp>wait_timeout</samp></td>
							<td>28800</td>
							<td>{$waitTimeout} <span class='text-muted'>({$waitTimeoutHrt})</span></td>
						</tr>
					</table>
					{if $maxConnectionsUsage > 85}
					<div class="alert alert-danger" role="alert">
						You should raise max_connections
					</div>
					{elseif $maxConnectionsUsage < 10}
					<div class="alert alert-info" role="alert">
						You are using less than 10% of your configured max_connections. Lowering max_connections
						could help to avoid an over-allocation of memory.
					</div>
					{else}
					<div class="alert alert-success" role="alert">
						Your max_connections variable seems to be fine
					</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='aria' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Aria <small>- Storage Engine</small></div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
							<p>The Aria storage engine is compiled in by default from MariaDB 5.1 and it is required to
								be 'in use' when mysqld is started.</p>
							<p>From MariaDB 10.4, all system tables are Aria.</p>
							<p>Additionally, internal on-disk tables are in the Aria table format instead of the MyISAM
								table format. This should speed up some GROUP BY and DISTINCT queries because Aria has
								better caching than MyISAM.</p>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Index size:</td>
									<td>{$ariaIndexLength}</td>
								</tr>
								<tr>
									<td>Pagecache buffer size:</td>
									<td>{$ariaPagecacheBufferSizeHrb}</td>
								</tr>
								<tr>
									<td>Reads (cached / disk):</td>
									<td>{$ariaPagecacheReadRequests} / {$ariaPagecacheReads}</td>
								</tr>
								<tr>
									<td>Keys from memory:</td>
									<td>{$ariaKeysFromMemoryPct|round:1} %</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>aria_block_size</samp></td>
							<td>8192 <span class='text-muted'>(8 KB)</span></td>
							<td>{$ariaBlockSize} <span class='text-muted'>({$ariaBlockSizeHrb})</span>
							</td>
						</tr>
						<tr>
							<td><samp>aria_pagecache_age_threshold</samp></td>
							<td>300 <span class='text-muted'>(5 min)</span></td>
							<td>{$ariaPagecacheAgeThreshold} <span
									class='text-muted'>({$ariaPagecacheAgeThresholdHrt})</span>
							</td>
						</tr>
						<tr>
							<td><samp>aria_pagecache_buffer_size</samp></td>
							<td>134217720 <span class='text-muted'>(128 MB)</span></td>
							<td>{$ariaPagecacheBufferSize} <span
									class='text-muted'>({$ariaPagecacheBufferSizeHrb})</span>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='innodb' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>InnoDB</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
							<p>The XtraDB/InnoDB buffer pool is a key component for optimizing MariaDB. It stores data
								and indexes, and you usually want it as large as possible so as to keep as much of the
								data and indexes in memory, reducing disk IO, as main bottleneck.</p>
							<p>The buffer pool attempts to keep frequently-used blocks in the buffer, and so essentially
								works as two sublists, a new sublist of recently-used information, and an old sublist of
								older information. By default, 37% of the list is reserved for the old list.</p>
							<p>When new information is accessed that doesn't appear in the list, it is placed at the top
								of the old list, the oldest item in the old list is removed, and everything else bumps
								back one position in the list.</p>
							<p>When information is accessed that appears in the old list, it is moved to the top the new
								list, and everything above moves back one position.</p>
							<p>More information on the InnoDB Buffer Pool:<br>
								<a href='https://mariadb.com/kb/en/innodb-buffer-pool/'
									target='_blank'>https://mariadb.com/kb/en/innodb-buffer-pool/</a>
							</p>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Index space:</td>
									<td>{$innodbIndexLengthHrb}</td>
								</tr>
								<tr>
									<td>Data space:</td>
									<td>{$innodbDataLengthHrb}</td>
								</tr>
								<tr>
									<td>Data read / written:</td>
									<td>{$innodbDataReadHrb}
										/ {$innodbDataWrittenHrb}</td>
								</tr>
								<tr>
									<td>Data reads / writes:</td>
									<td>{$innodbDataReads}
										/ {$innodbDataWrites}</td>
								</tr>
								<tr>
									<td>Buffer pool size:</td>
									<td>{$innodbBufferPoolSizeHrb}</td>
								</tr>
								<tr>
									<td>Buffer pool free pct.:</td>
									<td>{$innodbBufferPoolFreePct|round:1} %</td>
								</tr>
								<tr>
									<td>Buffer pool bytes data:</td>
									<td>{$innodbBufferPoolBytesDataHrb}</td>
								</tr>
								<tr>
									<td>Buffer pool bytes dirty:</td>
									<td>{$innodbBufferPoolBytesDirtyHrb}</td>
								</tr>
								<tr>
									<td>Buffer pool read requests:</td>
									<td>{$innodbBufferPoolReadRequests}</td>
								</tr>
								<tr>
									<td>Buffer pool reads:</td>
									<td>{$innodbBufferPoolReads}</td>
								</tr>
								<tr>
									<td>Buffer pool read ratio:</td>
									<td>{$innodbBufferPoolReadRatio|round:2} %</td>
								</tr>
								<tr>
									<td>Buffer pool wait free:</td>
									<td>{$innodbBufferPoolWaitFree}</td>
								</tr>
								<tr>
									<td>Row lock time:</td>
									<td>{$innodbRowLockTime} msec.</td>
								</tr>
								<tr>
									<td>Row lock waits:</td>
									<td>{$innodbRowLockWaits}</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>innodb_buffer_pool_size</samp></td>
							<td>134217728 (128 MB)</td>
							<td>{$innodbBufferPoolSize} ({$innodbBufferPoolSizeHrb})</td>
						</tr>
						<tr>
							<td><samp>innodb_fast_shutdown</samp></td>
							<td>1</td>
							<td>{$innodbFastShutdown}</td>
						</tr>
						<tr>
							<td><samp>innodb_file_per_table</samp></td>
							<td>ON</td>
							<td>{$innodbFilePerTable|default}</td>
						</tr>
						<tr>
							<td><samp>innodb_flush_log_at_trx_commit</samp></td>
							<td>1</td>
							<td>{$innodbFlushLogAtTrxCommit|default}</td>
						</tr>
						<tr>
							<td><samp>innodb_log_buffer_size</samp></td>
							<td>16777216 (16MB) >= MariaDB 10.1.9<br>8388608 (8MB) <= MariaDB 10.1.8</td>
							<td>{$innodbLogBufferSize|default} ({$innodbLogBufferSizeHrb|default})</td>
						</tr>
						<tr>
							<td><samp>innodb_log_file_size</samp></td>
							<td>100663296 (96MB) (>= MariaDB 10.5)<br>50331648 (48MB) (<= MariaDB 10.4)</td>
							<td>{$innodbLogFileSize|default} ({$innodbLogFileSizeHrb|default})</td>
						</tr>
						<tr>
							<td><samp>innodb_log_files_in_group</samp></td>
							<td>1 <span class='text-muted'>(>= MariaDB 10.5)</span><br>2 (<= MariaDB 10.4)</td>
							<td>{$innodbLogFilesInGroup|default}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='memory_usage' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Memory usage</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Physical Memory:</td>
									<td>{$physicalMemoryHrb}</td>
								</tr>
								<tr>
									<td>Global buffer size:</td>
									<td>{$globalBufferSizeHrb}</td>
								</tr>
								<tr>
									<td>Per-thread buffer size:</td>
									<td>{$perThreadBufferSizeHrb}</td>
								</tr>
								<tr>
									<td>Max theoretical memory:</td>
									<td>{$totalMemoryHrb}</td>
								</tr>
								<tr>
									<td>Max used memory:</td>
									<td>{$maxMemoryHrb}</td>
								</tr>
								<tr>
									<td>Pct of sys mem:</td>
									<td>{$pctOfSysMem|round:1} %</td>
								</tr>
							</table>
						</div>
					</div>
					<div class='row'>
						<div class='col-sm-4'>
							<h5>Global buffer size</h5>
							<p>Calculation of the global available buffers in this server.</p>
							<table class='table table-sm'>
								<tr>
									<td>Tmp table size:</td>
									<td align='right'>{$tmpTableSize}</td>
									<td>+</td>
								</tr>
								<tr>
									<td>InnoDB buffer pool size:</td>
									<td align='right'>{$innodbBufferPoolSize}</td>
									<td>+</td>
								</tr>
								<tr>
									<td>InnoDB additional mem pool size:</td>
									<td align='right'>{$innodbAdditionalMemPoolSize}</td>
									<td>+</td>
								</tr>
								<tr>
									<td>InnoDB log buffer size:</td>
									<td align='right'>{$innodbLogBufferSize}</td>
									<td>+</td>
								</tr>
								<tr>
									<td>Key buffer size:</td>
									<td align='right'>{$keyBufferSize}</td>
									<td>+</td>
								</tr>
								<tr>
									<td>Query cache size:</td>
									<td align='right'>{$queryCacheSize}</td>
									<td>+</td>
								</tr>
								<tr>
									<td>Aria pagecache buffer size:</td>
									<td align='right'>{$ariaPagecacheBufferSize}</td>
									<td>+</td>
								</tr>
								<tr>
									<td><strong>Total global buffer size:</strong></td>
									<td align='right'><strong>{$globalBufferSize}</strong></td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td align='right'><span class='text-muted'>{$globalBufferSizeHrb}</span>
									</td>
									<td>&nbsp;</td>
								</tr>
							</table>
						</div>
						<div class='col-sm-4'>
							<h5>Per-thread buffer size</h5>
							<p>Calculation of the buffer each independent thread can use.</p>
							<table class='table table-sm'>
								<tr>
									<td>Read buffer size:</td>
									<td align='right'>{$readBufferSize}</td>
									<td>+</td>
								</tr>
								<tr>
									<td>Read rnd buffer size:</td>
									<td align='right'>{$readRndBufferSize}</td>
									<td>+</td>
								</tr>
								<tr>
									<td>Sort buffer size:</td>
									<td align='right'>{$sortBufferSize}</td>
									<td>+</td>
								</tr>
								<tr>
									<td>Thread stack:</td>
									<td align='right'>{$threadStack}</td>
									<td>+</td>
								</tr>
								<tr>
									<td>Net buffer length:</td>
									<td align='right'>{$netBufferLength}</td>
									<td>+</td>
								</tr>
								<tr>
									<td>Join buffer size:</td>
									<td align='right'>{$joinBufferSize}</td>
									<td>+</td>
								</tr>
								<tr>
									<td>Binlog cache size:</td>
									<td align='right'>{$binlogCacheSize}</td>
									<td>+</td>
								</tr>
								<tr>
									<td><strong>Total per-thread buffer size:</strong></td>
									<td align='right'><strong>{$perThreadBufferSize}</strong></td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td align='right'><span class='text-muted'>{$perThreadBufferSizeHrb}</span>
									</td>
									<td>&nbsp;</td>
								</tr>
							</table>
						</div>
						<div class='col-sm-4'>
							<h5>Total thread buffers</h5>
							<p>Calculations of the cumulative thread buffers. These are calculation for two different
								scenarios. Formula: connections &times; buffer size</p>
							<table class='table table-sm'>
								<tr>
									<td>Max connections:</td>
									<td align='right'>{$maxConnections}
										&times; {$perThreadBufferSizeHrb} =
									</td>
									<td align='right'>{$perThreadBuffersHrb}</td>
								</tr>
								<tr>
									<td>Max used connections:</td>
									<td align='right'>{$maxUsedConnections}
										&times; {$perThreadBufferSizeHrb} =
									</td>
									<td align='right'>{$perThreadMaxBuffersHrb}</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>aria_pagecache_buffer_size</samp></td>
							<td>134217720 <span class='text-muted'>(128 MB)</span></td>
							<td>{$ariaPagecacheBufferSize} <span
									class='text-muted'>({$ariaPagecacheBufferSizeHrb})</span>
							</td>
						</tr>
						<tr>
							<td><samp>join_buffer_size</samp></td>
							<td>262144 <span class='text-muted'>(256 KB)</span></td>
							<td>{$joinBufferSize} <span class='text-muted'>({$joinBufferSizeHrb})</span></td>
						</tr>
						<tr>
							<td><samp>net_buffer_length</samp></td>
							<td>16384 <span class='text-muted'>(16 KB)</span></td>
							<td>{$netBufferLength} <span class='text-muted'>({$netBufferLengthHrb})</span></td>
						</tr>
						<tr>
							<td><samp>read_buffer_size</samp></td>
							<td>131072 <span class='text-muted'>(128 KB)</span></td>
							<td>{$readBufferSize} <span class='text-muted'>({$readBufferSizeHrb})</span></td>
						</tr>
						<tr>
							<td><samp>read_rnd_buffer_size</samp></td>
							<td>262144 <span class='text-muted'>(256 KB)</span></td>
							<td>{$readRndBufferSize} <span class='text-muted'>({$readRndBufferSizeHbr|default})</span>
							</td>
						</tr>
						<tr>
							<td><samp>sort_buffer_size</samp></td>
							<td><span class='text-muted'>(2 MB)</span></td>
							<td>{$sortBufferSize} <span class='text-muted'>({$sortBufferSizeHrb})</span></td>
						</tr>
						<tr>
							<td><samp>thread_stack</samp></td>
							<td>299008 <span class='text-muted'>(292 KB)</span></td>
							<td>{$threadStack} <span class='text-muted'>({$threadStackHrb})</span></td>
						</tr>
					</table>
					{if $pctOfSysMem > 90}
						<div class="alert alert-danger" role="alert">
							Max memory limit exceeds 90% of physical memory
						</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='key_buffer' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Key buffer</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
							<p>key_buffer_size is a MyISAM variable which determines the size of the index buffers held
								in memory, which affects the speed of index reads. Note that Aria tables by default make
								use of an alternative setting, aria-pagecache-buffer-size.</p>
							<p>More information on optimizing the Key Buffer Size:<br>
								<a href='https://mariadb.com/kb/en/optimizing-key_buffer_size/'
									target='_blank'>https://mariadb.com/kb/en/optimizing-key_buffer_size/</a>
							</p>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>MyISAM Index Size:</td>
									<td>{$myisamIndexLengthHrb}</td>
								</tr>
								<tr>
									<td>Key buffer size:</td>
									<td>{$keyBufferSizeHrb}</td>
								</tr>
								<tr>
									<td>Key cache miss rate is:</td>
									<td>1 : {$keyCacheMissRate|round}</td>
								</tr>
								<tr>
									<td>Key buffer free:</td>
									<td>{$keyBufferFreePct|round} %</td>
								</tr>
								<tr>
									<td>Key buffer used:</td>
									<td>{$keyBufferUsedHrb}</td>
								</tr>
								<tr>
									<td colspan='2'>
										<div class="progress">
											<div class="progress-bar" role="progressbar"
												style="width: {$keyBufferUsedPct|round}%;"
												aria-valuenow="{$keyBufferUsedPct|round}" aria-valuemin="0"
												aria-valuemax="100">{$keyBufferUsedPct|round} %
											</div>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>key_buffer_size</samp></td>
							<td>134217728 <span class='text-muted'>(128 MB)</span></td>
							<td>{$keyBufferSize} <span class='text-muted'>({$keyBufferSizeHrb})</span></td>
						</tr>
						<tr>
							<td><samp>key_cache_block_size</samp></td>
							<td>1024 <span class='text-muted'>(1 KB)</span></td>
							<td>{$keyCacheBlockSize} <span class='text-muted'>({$keyCacheBlockSizeHrb})</span></td>
						</tr>
					</table>
					{if $keyReads == 0}
						<div class="alert alert-danger" role="alert">
							No key reads?! Seriously look into using some indexes
						</div>
					{/if}
					{if $keyCacheMissRate <= 100 && $keyCacheMissRate > 0 && $keyBufferFreePct < 20}
						<div class="alert alert-warning" role="alert">
							You could increase key_buffer_size. It is safe to raise this up to 1/4 of total system memory.
						</div>
					{elseif $keyCacheMissRate >= 10000 || $keyBufferFreePct > 50}
						<div class="alert alert-warning" role="alert">
							Your key_buffer_size seems to be too high. Perhaps you can use these resources elsewhere.
						</div>
					{else}
						<div class="alert alert-success" role="alert">
							Your key_buffer_size seems to be fine
						</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='query_cache' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Query cache</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
							<p>The query cache stores results of SELECT queries so that if the identical query is
								received in future, the results can be quickly returned.</p>
							<p>This is extremely useful in high-read, low-write environments (such as most websites). It
								does not scale well in environments with high throughput on multi-core machines, so it
								is disabled by default.</p>
							<p>More information on optimizing the Query Cache:<br>
								<a href='https://mariadb.com/kb/en/query-cache/'
									target='_blank'>https://mariadb.com/kb/en/query-cache/</a>
							</p>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Query cache type:</td>
									<td>{$queryCacheType}{if $queryCacheType == "OFF"}{$alert_check}{else}{$alert_error}{/if}
									</td>
								</tr>
								<tr>
									<td>Query cache size:</td>
									<td>{$queryCacheSizeHrb}{if $queryCacheType == "OFF" && $queryCacheSize == 0}{$alert_check}{else}{$alert_warning}{/if}
									</td>
								</tr>
								<tr>
									<td>Query cache used memory:</td>
									<td>{$qcacheUsedMemoryHrb}</td>
								</tr>
								<tr>
									<td>Query cache usage:</td>
									<td>{$queryCacheUsage|round:1} %</td>
								</tr>
								<tr>
									<td>Query cache efficiency:</td>
									<td>{$queryCacheEfficiency}</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>query_cache_limit</samp></td>
							<td>1048576 <span class='text-muted'>(1 MB)</span></td>
							<td>{$queryCacheLimit} <span class='text-muted'>($queryCacheLimitHrb)</span></td>
						</tr>
						<tr>
							<td><samp>query_cache_min_res_limit</samp></td>
							<td>4096 <span class='text-muted'>(4 KB)</span></td>
							<td>{$queryCacheMinResUnit} <span class='text-muted'>({$queryCacheMinResUnitHrb})</span>
							</td>
						</tr>
						<tr>
							<td><samp>query_cache_size</samp></td>
							<td>1 M<span class='text-muted'>(>= MariaDB 10.1.7)</span><br>0 <span class='text-muted'>(<=
										MariaDB 10.1.6)</span>
							</td>
							<td>{$queryCacheSize} <span class='text-muted'>({$queryCacheSizeHrb})</span></td>
						</tr>
						<tr>
							<td><samp>query_cache_type</samp></td>
							<td>OFF <span class='text-muted'>(>= MariaDB 10.1.7)</span><br>ON <span class='text-muted'>(
									<= MariaDB 10.1.6)</span>
							</td>
							<td>{$queryCacheType}</td>
						</tr>
					</table>
					{if $queryCacheSize > 0 || $queryCacheType != "OFF"}
						<div class="alert alert-danger" role="alert">
							Query cache is enabled but should not be used on multi-processor machines due to mutex
							contention.
						</div>
					{/if}
					{if $queryCacheSize > 0 && $queryCacheType == "OFF"}
						<div class="alert alert-warning" role="alert">
							Query cache is disabled by query_cache_type, but effectively enabled because query_cache_size is
							higher than zero. Disable it completly by setting:
							<samp>query_cache_size = 0</samp> and <samp>query_cache_type = OFF</samp>
						</div>
					{elseif $queryCacheUsage < 25}
						<div class="alert alert-info" role="alert">
							Your query cache size seems to be too high. Perhaps you can use these resources elsewhere.
						</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='sort_operations' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Sort operations</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
							<p>Each session performing a sort allocates a buffer with this amount of memory. Not
								specific to any storage engine. If the status variable sort_merge_passes is too high,
								you may need to look at improving your query indexes, or increasing this. Consider
								reducing where there are many small sorts, such as OLTP, and increasing where needed by
								session. 16k is a suggested minimum.</p>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Sort buffer size:</td>
									<td>{$sortBufferSizeHrb}</td>
								</tr>
								<tr>
									<td>Read rnd buffer size:</td>
									<td>{$readRndBufferSizeHrb}</td>
								</tr>
								<tr>
									<td>Sort merge passes:</td>
									<td>{$sortMergePasses}</td>
								</tr>
								<tr>
									<td>Temp sort tables pct.:</td>
									<td>{$tempSortTablePct}
										%{if $tempSortTablePct < 10}{$alert_check}{else}{$alert_warning}{/if}</td>
								</tr>
								<tr>
									<td>Total sorts:</td>
									<td>
										{$totalSorts}
									</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>sort_buffer_size</samp></td>
							<td>2097152 <span class='text-muted'>(2 MB)</span></td>
							<td>
								{$sortBufferSize}
								<span class='text-muted'>(
									{$sortBufferSizeHrb})
								</span>
							</td>
						</tr>
						<tr>
							<td><samp>read_rnd_buffer_size</samp></td>
							<td>262144 <span class='text-muted'>(256 KB)</span></td>
							<td>
								{$readRndBufferSize} <span class='text-muted'>(
									{$readRndBufferSizeHrb})
								</span>
							</td>
						</tr>
					</table>
					{if $totalSorts == 0}
						<div class="alert alert-info" role="alert">
							No sort operations have been performed
						</div>
					{/if}
					{if $tempSortTablePct > 10}
						<div class="alert alert-warning" role="alert">
							Lots of sorts require temp tables. Perhaps you could raise <samp>sort_buffer_size</samp> and
							<samp>read_rnd_buffer_size</samp>.
						</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='join_operations' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Joins</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Join buffer size:</td>
									<td>{$joinBufferSizeHrb}</td>
								</tr>
								<tr>
									<td>Select full join:</td>
									<td>{$selectFullJoin}</td>
								</tr>
								<tr>
									<td>Select range check:</td>
									<td>{$selectRangeCheck}</td>
								</tr>
								<tr>
									<td>Joins without indexes per day:</td>
									<td>{$joinsWithoutIndexesPerDay|round}{if $joinsWithoutIndexesPerDay > 250}{$alert_warning}{else}{$alert_check}{/if}
									</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>join_buffer_size</samp></td>
							<td>262144 <span class='text-muted'>(256 KB)</span></td>
							<td>{$joinBufferSizeHrb}
								<span class='text-muted'>({$joinBufferSizeHrb})</span>
							</td>
						</tr>
					</table>
					{if $selectRangeCheck == 0 && $selectFullJoin == 0}
						<div class="alert alert-success" role="alert">
							Your joins seem to be using indexes properly
						</div>
					{/if}
					{if $selectFullJoin > 0 || $selectRangeCheck > 0}
						<div class="alert alert-danger" role="alert">
							You should enable "log-queries-not-using-indexes" and look for non indexed joins in the slow
							query log.
						</div>
					{/if}
					{if $joinsWithoutIndexesPerDay > 250}
						<div class="alert alert-warning" role="alert">
							Your joins without indexes (avg. per day) is very high. You could address this issue by
							adding appropriate indexes. If adding indexes isn't an option then your can raise the
						<samp>join_buffer_size</samp>
						until the joins without indexes per day is at an acceptable level. Be informed that this
						buffer is always reserved for each active connection. Raising this buffer size too high
						could trigger memory issues.
					</div>
					{/if}
					{if $joinBufferSize >= 4 * 1024 * 1024}
					<div class="alert alert-danger" role="alert">
						It is not advised to have more than 4 M join_buffer_size.
					</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='open_files' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Open files limit</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
							<p> The number of file descriptors available to MariaDB. If you are getting the Too many
								open files error, then you should increase this limit.</p>
							<p>If set to 0, then MariaDB will calculate a limit based on the following:</p>
							<p>MAX(max_connections * 5, max_connections + table_open_cache * 2)</p>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Open files limit:</td>
									<td>{$openFilesLimit}</td>
								</tr>
								<tr>
									<td>Open files:</td>
									<td>{$openFiles}</td>
								</tr>
								<tr>
									<td>Open files ratio:</td>
									<td>{$openFilesRatio|round:1}
										%{if $openFilesRatio < 85}{$alert_check}{else}{$alert_warning}{/if}</td>
								</tr>
								<tr>
									<td colspan='2'>
										<div class="progress">
											<div class="progress-bar" role="progressbar"
												style="width: {$openFilesRatio|round}%;"
												aria-valuenow="{$openFilesRatio|round}" aria-valuemin="0"
												aria-valuemax="100">{$openFilesRatio|round} %
											</div>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>open_files_limit</samp></td>
							<td><em>Autosized</em></td>
							<td>{$openFilesLimit}</td>
						</tr>
					</table>
					{if $openFilesRatio >= 85}
					<div class="alert alert-danger" role="alert">
						You currently have open more than 85% of your open_file_limit.
					</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='table_cache' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Table cache</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Table count:</td>
									<td>{$tableCount|default}</td>
								</tr>
								<tr>
									<td>Table cache:</td>
									<td>{$openTables|default} of {$tableOpenCache|default}<br>
										{$tableCacheUsage|round:1|default}
										%{if $tableCacheUsage|default < 95}{$alert_check}{else}{$alert_warning}{/if}
									</td>
								</tr>
								<tr>
									<td>Definition cache:</td>
									<td>{$openTableDefinitions|default} of {$tableDefinitionCache|default}<br>
										{$tableDefinitionCacheUsage|round:1|default}
										%{if $tableDefinitionCacheUsage|default < 95}{$alert_check}{else}{$alert_warning}{/if}
									</td>
								</tr>
								<tr>
									<td>Table cache hit rate:</td>
									<td>{$tableCacheHitRate|round:1|default}
										%{if $tableCacheHitRate|default > 85}{$alert_check}{else}{$alert_warning}{/if}
									</td>
								</tr>
								<tr>
									<td>Opened tables:</td>
									<td>{$openedTables|default}</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>table_open_cache</samp></td>
							<td>2000</td>
							<td>{$tableOpenCache|default}</td>
						</tr>
						<tr>
							<td><samp>table_open_cache_instances</samp></td>
							<td>8</td>
							<td>{$tableOpenCacheInstances|default}</td>
						</tr>
						<tr>
							<td><samp>table_definition_cache</samp></td>
							<td>400</td>
							<td>{$tableDefinitionCache|default}</td>
						</tr>
					</table>
					{if $tableCacheError|default}
					<div class="alert alert-danger" role="alert">
						No table cache?!
					</div>
					{/if}

					{if $tableCacheUsage|default < 95}
					<div class="alert alert-success" role="alert">
						Your table_cache value seems to be fine
					</div>
					{elseif $tableCacheUsage|default >= 95}
					<div class="alert alert-warning" role="alert">
						You should probably increase your <samp>table_open_cache</samp> because there is not enough
						room in your table open cache.
					</div>
					{elseif $tableCacheHitRate|default <= 85}
					<div class="alert alert-warning" role="alert">
						You should probably increase your <samp>table_open_cache</samp> because too many tables are
						requested without using the cache.
					</div>
					{else}
					<div class="alert alert-success" role="alert">
						Your table_cache value seems to be fine.
					</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='temp_tables' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Temp tables</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
							Note! BLOB and TEXT colums are now allowed in memory tables. If you are using there columns
							raising these values might not impact your ratio of on disk temp tables.
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Max heap table size:</td>
									<td>{$maxHeapTableSizeHrb}</td>
								</tr>
								<tr>
									<td>Tmp table size:</td>
									<td>{$tmpTableSizeHrb}</td>
								</tr>
								<tr>
									<td>Created tmp tables:</td>
									<td>{$createdTmpTables}</td>
								</tr>
								<tr>
									<td>Created tmp disk tables:</td>
									<td>{$createdTmpDiskTables}<br>
										{$tmpDiskTablesPct|round:1}
										%{if $tmpDiskTablesPct > 25}{$alert_warning}{else}{$alert_check}{/if}</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>max_heap_table_size</samp></td>
							<td>16777216 <span class='text-muted'>(16MB)</span></td>
							<td>{$maxHeapTableSize} <span class='text-muted'>({$maxHeapTableSizeHrb})</span></td>
						</tr>
						<tr>
							<td><samp>tmp_table_size</samp></td>
							<td>16777216 <span class='text-muted'>(16MB)</span></td>
							<td>{$tmpTableSize} <span class='text-muted'>({$tmpTableSizeHrb})</span></td>
						</tr>
					</table>
					{if $tmpTableSize > $maxHeapTableSize}
					<div class="alert alert-warning" role="alert">
						Effective in-memory tmp_table_size is limited to max_heap_table_size.
					</div>
					{/if}

					{if $tmpDiskTablesPct >= 25 && $tmpTableSize < 256 * 1024 * 1024}
					<div class="alert alert-danger" role="alert">
						Perhaps you should increase your tmp_table_size and/or max_heap_table_size to reduce the number
						of disk-based temporary tables.
					</div>
					{elseif $tmpDiskTablesPct >= 25 && $tmpTableSize >= 256 * 1024 * 1024}
					<div class="alert alert-danger" role="alert">
						Your <samp>tmp_table_size</samp> is already very high. Do not increase it any further but
						optimize your queries.
					</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='table_scans' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Table scans</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Read buffer size:</td>
									<td>{$readBufferSizeHrb}</td>
								</tr>
								<tr>
									<td>Full table scans ratio:</td>
									<td>{$fullTableScans|round} : 1</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>read_buffer_size</samp></td>
							<td>131072 <span class='text-muted'>(128 KB)</span></td>
							<td>{$readBufferSize} <span class='text-muted'>({$readBufferSizeHrb})</span></td>
						</tr>
					</table>
					{if $comSelect > 0}
					{if $fullTableScans >= 4000 && $readBufferSize < 2 * 1024 * 1024}
					<div class="alert alert-danger" role="alert">
						You have a high ratio of sequential access requests to SELECTs. You may benefit from raising
						read_buffer_size and/or improving your use of indexes.
					</div>
					{elseif $readBufferSize > 8 * 1024 * 1024}
					<div class="alert alert-danger" role="alert">
						Read buffer is over 8 MB. There is probably no need for such a large read_buffer.
					</div>
					{else}
					<div class="alert alert-success" role="alert">
						Read buffer size seems to be fine.
					</div>
					{/if}
					{else}
					<div class="alert alert-success" role="alert">
						Read buffer size seems to be fine.
					</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='table_locking' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Table locking</div>
				<div class='card-body'>
					<div class='row'>
						<div class='col-sm-8'>
						</div>
						<div class='col-sm-4'>
							<table class='table table-sm'>
								<tr>
									<td>Table locks immediate:</td>
									<td>{$tableLocksImmediate}</td>
								</tr>
								<tr>
									<td>Table locks waited:</td>
									<td>{$tableLocksWaited}<br>
										{$tableLocksWaitedPct|round:3} %
									</td>
								</tr>
								<tr>
									<td>Lock / wait ratio:</td>
									<td>1 : {$immediateLocksMissRate|round}</td>
								</tr>
							</table>
						</div>
					</div>
					<table class='table table-sm'>
						<tr>
							<th style='width: 30%'>Variable name</th>
							<th style='width: 35%'>Default value</th>
							<th style='width: 35%'>Current value</th>
						</tr>
						<tr>
							<td><samp>concurrent_insert</samp></td>
							<td>AUTO</td>
							<td>{$concurrentInsert}</td>
						</tr>
						<tr>
							<td><samp>low_priority_updates</samp></td>
							<td>0</td>
							<td>{$lowPriorityUpdates}</td>
						</tr>
					</table>
					{if $immediateLocksMissRate < 5000}
					<div class="alert alert-warning" role="alert">
						You may benefit from selective use of InnoDB
					</div>
					{else}
					<div class="alert alert-success" role="alert">
						Your table locking seems to be fine
					</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='status_variables' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>Status variables</div>
				<div class='card-body'>
					<a class="btn btn-primary" data-toggle="collapse" href="#collapseStatus" role="button"
						aria-expanded="false" aria-controls="collapseStatus">Show status</a>
					<table class='table table-sm collapse' id='collapseStatus'>
						{foreach $globalStatus as $globalStatusName => $globalStatusValue}
						<tr>
							<td>{$globalStatusName}</td>
							<td>{$globalStatusValue}</td>
						</tr>
						{/foreach}
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<a id='system_variables' style='scroll-margin-top: 150px;'></a>
		<div class='col-sm-12'>
			<div class='card border-0 shadow-sm'>
				<div class='card-header'>System variables</div>
				<div class='card-body'>
					<a class="btn btn-primary" data-toggle="collapse" href="#collapseVariables" role="button"
						aria-expanded="false" aria-controls="collapseVariables">Show variables</a>
					<table class='table table-sm collapse' id='collapseVariables'>
						{foreach $globalVariables as $globalVariableName => $globalVariableValue}
						<tr>
							<td>{$globalVariableName}</td>
							<td>{$globalVariableValue}</td>
						</tr>
						{/foreach}
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class='container'>
	<div class='navbar text-light footer mt-4' style="background-color: #363A41;">
		<div class='row col-sm-12'>
			<div class='my-3'>
				<p style='color: rgb(192, 190, 195)'>MySQL-Tuner-PHP is a open source project of Acropia. Feel free to
					use whereever and however you want!</p>
			</div>
		</div>
		<div class='row col-sm-12 pb-3'>
			<div class='col-sm-4'>
				<h5>MySQL-Tuner-PHP?</h5>
				<ul class="nav flex-column">
					<li class="nav-item">Introduction</li>
					<li class="nav-item">Installation</li>
					<li class="nav-item">References</li>
					<li class="nav-item">Releases &amp; development</li>
					<li class="nav-item">License</li>
				</ul>
			</div>
			<div class='col-sm-2'>
				<h5>Misc</h5>
				<ul class="nav flex-column">
					<li class="nav-item"><a href="#database_engines">Database engines</a></li>
					<li class="nav-item"><a href="#slow_queries">Slow queries</a></li>
					<li class="nav-item"><a href="#binary_log">Binary log</a></li>
					<li class="nav-item"><a href="#threads">Threads</a></li>
					<li class="nav-item"><a href="#aria">Aria</a></li>
					<li class="nav-item"><a href="#innodb">InnoDB</a></li>
				</ul>
			</div>
			<div class='col-sm-2'>
				<h5>Memory</h5>
				<ul class="nav flex-column">
					<li class="nav-item"><a href="#memory_usage">Memory used</a></li>
					<li class="nav-item"><a href="#key_buffer">Key buffer</a></li>
					<li class="nav-item"><a href="#query_cache">Query cache</a></li>
					<li class="nav-item"><a href="#sort_operations">Sort operations</a></li>
					<li class="nav-item"><a href="#join_operations">Join operations</a></li>
				</ul>
			</div>
			<div class='col-sm-2'>
				<h5>File</h5>
				<ul class="nav flex-column">
					<li class="nav-item"><a href="#open_files">Open files</a></li>
					<li class="nav-item"><a href="#table_cache">Table cache</a></li>
					<li class="nav-item"><a href="#temp_tables">Temp. tables</a></li>
					<li class="nav-item"><a href="#table_scans">Table scans</a></li>
					<li class="nav-item"><a href="#table_locking">Table locking</a></li>
				</ul>
			</div>
			<div class='col-sm-2'>
					<h5>Variables</h5>
					<ul class="nav flex-column">
						<li class="nav-item"><a href="#status_variables">Status variables</a></li>
						<li class="nav-item"><a href="#system_variables">System variables</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>