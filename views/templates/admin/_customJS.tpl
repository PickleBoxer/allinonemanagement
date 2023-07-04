<div class="panel panel-account-info" v-show="currentPage === 'customJS'">
    <h1>{l s='Custom JS' mod='allinonemanagement'}</h1>
    <p>{l s='You can add your own JS code here. It will be added to the page.' mod='allinonemanagement'}</p>
    <div class="form-group">
        <label>Enable JS</label>
        <div class="clearfix"></div>
        <div class="btn-group large" role="group">
            <button type="button" class=" " v-on:click="customJs = true" :class="customJs == 1 ? 'filled' : ''"
                :aria-selected="customJs == 1 ? true : false">
                {l s='Enabled' mod='allinonemanagement'}
            </button>
            <button type="button" class=" " v-on:click="customJs = false" :class="customJs == 0 ? 'filled' : ''"
                :aria-selected="customJs == 0 ? true : false">
                {l s='Disabled' mod='allinonemanagement'}
            </button>
        </div>
        <small style="display: block;" class="form-text text-muted">
            {l s='Enable or disable custom JS' mod='allinonemanagement'}
        </small>
    </div>
    <div style="position:relative;height:300px;overflow:auto;resize:vertical;border: 0.0625rem solid currentcolor;">
        <div id="editorJs"></div>
    </div>
    <div class="form-group text-right" style="max-width:800px;margin: 1rem auto;">
        <button type="button" class="filled" v-on:click="saveCustomJs">
            {l s='Save' mod='allinonemanagement'}
        </button>
    </div>
</div>