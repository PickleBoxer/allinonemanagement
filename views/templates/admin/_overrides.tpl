<div class="panel panel-account-info" v-show="currentPage === 'overrides'">
  <h1>
    {l s='Overrides' mod='allinonemanagement'}
  </h1>
  <p>Overriding is a way to “override” class files and controller files. PrestaShop’s ingenious class auto-loading
    function makes the “switch” to other files fairly simple. Thanks to PrestaShop’s fully object-oriented code, you can
    rely on object inheritance to modify and add new behaviors, using the properties and methods of the various existing
    classes.</p>
  <div class="alert alert-warning">There are limitations and risks of using overrides. Keep them for your own shop.
  </div>
  <table class="table">
    <thead>
      <tr>
        <th>Document Name</th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {literal}
        <tr v-for="overrideFile in overrideFiles">
          <td>{{ overrideFile.filepath }}</td>
          <td>{{ overrideFile.status }}</td>
          <td>
            <button class="toggle-document" :class="overrideFile.status == 'disabled' ? 'filled' : ''"
              :data-document="overrideFile.filepath" :data-status="overrideFile.status"
              :aria-selected="overrideFile.status === 'disabled'" @click="toggleOverrideFile">
              {{ overrideFile.status === 'disabled' ? 'Enable' : 'Disable' }}
            </button>
          </td>
        </tr>
      {/literal}
    </tbody>
  </table>
  <div class="form-group text-right" style="max-width:800px;margin: 1rem auto;">
    <button type="button" class="filled" v-on:click="applyOverrideChanges">
      {l s='Apply Changes' mod='allinonemanagement'}
    </button>
  </div>
</div>