<div class="panel panel-account-info" v-show="currentPage === 'databaseOptimization'">
    <h1>
        {l s='Database Optimization' mod='allinonemanagement'}
    </h1>
    <p>
        {l s='Optimize your database to reduce its size and improve MySQL performance.' mod='allinonemanagement'}
    </p>
    <p>
        {l s='As your shop lives, some items of PrestaShop can grow very big in time. If you notice your shop is getting slow the following list of items can be analyzed to see if you can clean it.' mod='allinonemanagement'}
    </p>
    <ul class="list-group" id="side-menu">
        {literal}
            <li v-for="(table, key) in tablesToOptimize" :key="key" class="list-group-item"
                v-on:click="optimizeDatabase(table.table)">
                <i class="material-icons">{{ table.icon }}</i>
                <div>
                    <h2 style="margin-top:0;">{{ table.name }} ({{ table.count }})</h2>
                    <p>{{ table.description }}</p>
                    <small>date of last clean: 2023-05-25 01:13:36</small>
                </div>
            </li>
        {/literal}
    </ul>
</div>