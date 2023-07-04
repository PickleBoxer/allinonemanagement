<div id="app" class="allinone-content-container">
        <div class="panel panel-account-info">
            <h1>Version Comperison</h1>
            <p>Please do not edit or remove any PrestaShop files if you plan to upgrade to newer versions in the future. Modifying these files may cause issues or conflicts with other modules or customizations, and could prevent successful upgrades.</p>
            <div class="alert alert-info">If you wish to customize PrestaShop for your needs please refer to <a href="https://devdocs.prestashop-project.org/">PrestaShop Developer Documentation</a></div>
            <label>The list of modified files:</label>
            <div class="row">
                {foreach $getChangedFilesList as $key => $value}
                    <div class="col-md-4">
                        <h2>{$key} ({$value|count})</h2>
                        <ul>
                            {foreach $value as $file}
                                <li>{$file}</li>
                            {/foreach}
                        </ul>
                    </div>
                {/foreach}
            </div>
    </div>
</div>
