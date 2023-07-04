<div class="panel grid panel-account-info" v-show="currentPage === 'dashboard'">
    </h3>
    <article class="panel-card">
        <img src="{$image_path}debugmode.jpg">
        <header>
            <h2>{l s='Developer Mode' mod='allinonemanagement'}</h2>
            <p>{l s='Enable developer mode to see the output debugging information such as errors, warnings etc.' mod='allinonemanagement'}
            </p>
        </header>
        <footer>
            <button type="button" class=" " v-on:click="devMode = true" :class="devMode == 1 ? 'filled' : ''"
                :aria-selected="devMode == 1 ? true : false">
                {l s='Enabled' mod='allinonemanagement'}
            </button>
            <button type="button" class=" " v-on:click="devMode = false" :class="devMode == 0 ? 'filled' : ''"
                :aria-selected="devMode == 0 ? true : false">
                {l s='Disabled' mod='allinonemanagement'}
            </button>
        </footer>
    </article>
    <article class="panel-card">
        <img src="{$image_path}profiler.png">
        <header>
            <h2>{l s='Debug Profiling' mod='allinonemanagement'}</h2>
            <p>{l s='Enable debug profiling to see the performance of your website' mod='allinonemanagement'}</p>
        </header>
        <footer>
            <button type="button" class=" " v-on:click="debugProfiling = true" :class="debugProfiling == 1 ? 'filled' : ''"
                :aria-selected="debugProfiling == 1 ? true : false">
                {l s='Enabled' mod='allinonemanagement'}
            </button>
            <button type="button" class=" " v-on:click="debugProfiling = false" :class="debugProfiling == 0 ? 'filled' : ''"
                :aria-selected="debugProfiling == 0 ? true : false">
                {l s='Disabled' mod='allinonemanagement'}
            </button>
        </footer>
    </article>
    <article class="panel-card">
        <img src="{$image_path}rootprotect.png">
        <header>
            <h2>{l s='Password protect root folder' mod='allinonemanagement'}</h2>
            <p>{l s='Enable password protection for the root folder of your website' mod='allinonemanagement'}</p>
            <small class="alert alert-warning">User: Admin Pass: Admin</small>
        </header>
        <footer>
            <button type="button" class=" " v-on:click="folderProtector = true" :class="folderProtector == 1 ? 'filled' : ''"
                :aria-selected="folderProtector == 1 ? true : false">
                {l s='Enabled' mod='allinonemanagement'}
            </button>
            <button type="button" class=" " v-on:click="folderProtector = false" :class="folderProtector == 0 ? 'filled' : ''"
                :aria-selected="folderProtector == 0 ? true : false">
                {l s='Disabled' mod='allinonemanagement'}
            </button>
        </footer>
    </article>
    <article class="panel-card">
        <img src="{$image_path}criticalcss.jpg">
        <header>
            <h2>{l s='Critical CSS' mod='allinonemanagement'}</h2>
            <p>{l s='Enable critical CSS on all front controllers' mod='allinonemanagement'}</p>
            <span v-show="folderProtector === true" style="color:red;">*The enabled password protection folder is causing problems when fetching the CSS</span>
        </header>
        <footer>
            <button type="button" class=" " v-on:click="criticalCss = true" :class="criticalCss == 1 ? 'filled' : ''"
                :aria-selected="criticalCss == 1 ? true : false">
                {l s='Enabled' mod='allinonemanagement'}
            </button>
            <button type="button" class=" " v-on:click="criticalCss = false" :class="criticalCss == 0 ? 'filled' : ''"
                :aria-selected="criticalCss == 0 ? true : false">
                {l s='Disabled' mod='allinonemanagement'}
            </button>
        </footer>
    </article>
    <article class="panel-card">
        <img src="{$image_path}loginascustommer.png">
        <header>
            <h2>{l s='Login as Custommer' mod='allinonemanagement'}</h2>
            <p>{l s='Enable login as custommer' mod='allinonemanagement'}</p>
        </header>
        <footer>
            <button type="button" class=" " v-on:click="loginAsCustomer = true" :class="loginAsCustomer == 1 ? 'filled' : ''"
                :aria-selected="loginAsCustomer == 1 ? true : false">
                {l s='Enabled' mod='allinonemanagement'}
            </button>
            <button type="button" class=" " v-on:click="loginAsCustomer = false" :class="loginAsCustomer == 0 ? 'filled' : ''"
                :aria-selected="loginAsCustomer == 0 ? true : false">
                {l s='Disabled' mod='allinonemanagement'}
            </button>
        </footer>
    </article>

</div>