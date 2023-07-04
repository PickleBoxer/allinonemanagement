<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<link rel="stylesheet" href="/modules/allinonemanagement/views/css/lib/code_editor.min.css">
<link rel="stylesheet" href="/modules/allinonemanagement/views/css/lib/theme.css">
<style type="text/css" media="screen">
    #editorCss {
        margin: 0;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
    #editorJs {
        margin: 0;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
</style>

<div id="app" data-v-app="" class="allinone-content-container">
  <div id="loader-container" :class="(isSaving == true || showLoader == true) ? 'visible' : ''">
    <div class="loader"></div>
  </div>
  {include file="./navbar.tpl"}
  <div class="alert alert-info" v-show="isSaving">
    {l s='Saving settings...' mod='allinonemanagement'}
  </div>
  <div class="row">
    <div class="col-md-3 side-col">
      <ul class="list-group" id="side-menu">
        <li class="list-group-item" :class="currentPage === 'dashboard' ?  'active' :''"
          v-on:click="setCurrentPage('dashboard')">
          <i class="material-icons">
            dashboard
          </i>
          <div>
            <h2 style="margin-top:0;">{l s='Dashboard' mod='allinonemanagement'}</h2>
            <p>{l s='View your store\'s performance' mod='allinonemanagement'}</p>
          </div>
        </li>
        <li class="list-group-item" :class="currentPage === 'overrides' ?  'active' :''"
          v-on:click="setCurrentPage('overrides')">
          <i class="material-icons">
            content_copy
          </i>
          <div>
            <h2 style="margin-top:0;">{l s='Overrides' mod='allinonemanagement'}</h2>
            <p>{l s='Disable/Enable Overrides files' mod='allinonemanagement'}</p>
          </div>
        </li>
        <li class="list-group-item" :class="currentPage === 'databaseOptimization' ?  'active' :''"
          v-on:click="setCurrentPage('databaseOptimization')">
          <i class="material-icons">
          dns
          </i>
          <div>
            <h2 style="margin-top:0;">{l s='Database Optimization' mod='allinonemanagement'}</h2>
            <p>{l s='Optimize your database' mod='allinonemanagement'}</p>
          </div>
        </li>
        <li class="list-group-item" :class="currentPage === 'customCSS' ?  'active' :''"
          v-on:click="setCurrentPage('customCSS')">
          <i class="material-icons">
          code
          </i>
          <div>
            <h2 style="margin-top:0;">{l s='Custom CSS' mod='allinonemanagement'}</h2>
            <p>{l s='Disable/Enable/Edit customCSS files' mod='allinonemanagement'}</p>
          </div>
        </li>
        <li class="list-group-item" :class="currentPage === 'customJS' ?  'active' :''"
          v-on:click="setCurrentPage('customJS')">
          <i class="material-icons">
          code
          </i>
          <div>
            <h2 style="margin-top:0;">{l s='Custom JS' mod='allinonemanagement'}</h2>
            <p>{l s='Disable/Enable/Edit customJS files' mod='allinonemanagement'}</p>
          </div>
        </li>
      </ul>
    </div>
    <div class="col-md-9">
      <div class="">
        {include file="./_dashboard.tpl"}
        {include file="./_overrides.tpl"}
        {include file="./_databaseOptimization.tpl"}
        {include file="./_customCSS.tpl"}
        {include file="./_customJS.tpl"}
      </div>
    </div>
  </div>
</div>

<script src="/modules/allinonemanagement/views/js/lib/vue@3.2.6.prod.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/ace-builds@1.22.0/src-min-noconflict/ace.min.js"></script>
<script src="/modules/allinonemanagement/views/js/lib/highlight.11.2.0.min.js"></script>
<script src="/modules/allinonemanagement/views/js/lib/code_editor.prod.js"></script>
<script src="/modules/allinonemanagement/views/js/back.js" type="module"></script>