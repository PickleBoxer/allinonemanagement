<div class="panel panel-account-info" v-show="currentPage === 'customCSS'">
    <h1>{l s='Custom CSS' mod='allinonemanagement'}</h1>
    <p>{l s='You can add your custom CSS here. It will be added to the head of your website.' mod='allinonemanagement'}</p>
    <div class="form-group">
        <label>Enable CSS</label>
        <div class="clearfix"></div>
        <div class="btn-group large" role="group">
            <button type="button" class=" " v-on:click="customCss = true" :class="customCss == 1 ? 'filled' : ''"
                :aria-selected="customCss == 1 ? true : false">
                {l s='Enabled' mod='allinonemanagement'}
            </button>
            <button type="button" class=" " v-on:click="customCss = false" :class="customCss == 0 ? 'filled' : ''"
                :aria-selected="customCss == 0 ? true : false">
                {l s='Disabled' mod='allinonemanagement'}
            </button>
        </div>
        <small style="display: block;" class="form-text text-muted">
            {l s='Enable or disable custom CSS' mod='allinonemanagement'}
        </small>
    </div>
    <div style="position:relative;height:300px;overflow:auto;resize:vertical;border: 0.0625rem solid currentcolor;">
        <div id="editorCss"></div>
    </div>
    <div class="form-group text-right" style="max-width:800px;margin: 1rem auto;">
        <button type="button" class="filled" v-on:click="saveCustomCss">
            {l s='Save' mod='allinonemanagement'}
        </button>
    </div>
</div>