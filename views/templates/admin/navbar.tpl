<div class="navbar-container">
    <div class="panel panel-navbar">
        <div class="col-sm-6 hidden-xs">
            <img class="img-responsive " src="{$image_path}logo-aer-digital.png" height="25" width="150">
        </div>
        <div class="col-sm-6">
            <div class="pull-right" style="margin-left: 1rem;">
                <button style="background-color: #fcc94f;" v-on:click="clearAllCache">
                    <i class="material-icons" style="font-size: 16px;">delete</i>
                    {l s='Clear Cache' mod='allinonemanagement'}
                </button>
            </div>
            <div class="hidden btn-group pull-right" role="group"
                style="height:100%; vertical-align:center;line-height : 100%;">
                <a class="btn btn-default btn-configuration"
                    href="{$link->getAdminLink('AdminAllInOneManagementDashboard')|escape:'htmlall':'UTF-8'}">
                    <i class="icon icon-gear" aria-hidden="true"></i>

                    {l s='Setup wizard' mod='allinonemanagement'}
                </a>
                <a class="btn btn-default btn-syncronization hidden"
                    href="{$link->getAdminLink('AdminAllInOneManagementDashboard')|escape:'htmlall':'UTF-8'}">
                    <i class="icon icon-retweet" aria-hidden="true"></i>
                    {l s='Sync' mod='allinonemanagement'}
                </a>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default btn-mc dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="icon icon-folder-open-o" aria-hidden="true"></i>
                        {l s='All-in-One Objects' mod='allinonemanagement'}
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a
                                href="{$link->getAdminLink('AdminAllInOneManagementDashboard')|escape:'htmlall':'UTF-8'}">
                                {l s='Batches' mod='allinonemanagement'}
                            </a>
                        </li>
                        <li>
                            <a
                                href="{$link->getAdminLink('AdminAllInOneManagementDashboard')|escape:'htmlall':'UTF-8'}">
                                {l s='Carts' mod='allinonemanagement'}
                            </a>
                        </li>
                        <li>
                            <a
                                href="{$link->getAdminLink('AdminAllInOneManagementDashboard')|escape:'htmlall':'UTF-8'}">
                                {l s='Customers' mod='allinonemanagement'}
                            </a>
                        </li>
                        <li>
                            <a
                                href="{$link->getAdminLink('AdminAllInOneManagementDashboard')|escape:'htmlall':'UTF-8'}">
                                {l s='Lists' mod='allinonemanagement'}
                            </a>
                        </li>
                        <li>
                            <a
                                href="{$link->getAdminLink('AdminAllInOneManagementDashboard')|escape:'htmlall':'UTF-8'}">
                                {l s='Orders' mod='allinonemanagement'}
                            </a>
                        </li>
                        <li>
                            <a
                                href="{$link->getAdminLink('AdminAllInOneManagementDashboard')|escape:'htmlall':'UTF-8'}">
                                {l s='Products' mod='allinonemanagement'}
                            </a>
                        </li>
                        <li>
                            <a
                                href="{$link->getAdminLink('AdminAllInOneManagementDashboard')|escape:'htmlall':'UTF-8'}">
                                {l s='Stores' mod='allinonemanagement'}
                            </a>
                        </li>

                        <li>
                            <a
                                href="{$link->getAdminLink('AdminAllInOneManagementDashboard')|escape:'htmlall':'UTF-8'}">
                                {l s='Sites' mod='allinonemanagement'}
                            </a>
                        </li>
                        <li>
                            <a
                                href="{$link->getAdminLink('AdminAllInOneManagementDashboard')|escape:'htmlall':'UTF-8'}">
                                {l s='Automations' mod='allinonemanagement'}
                            </a>
                        </li>
                        <li>
                            <a
                                href="{$link->getAdminLink('AdminAllInOneManagementDashboard')|escape:'htmlall':'UTF-8'}">
                                {l s='Promo rules' mod='allinonemanagement'}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>