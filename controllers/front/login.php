<?php

class AllInOneManagementLoginModuleFrontController extends ModuleFrontControllerCore {

    public $ssl = true;
    public $display_column_left = false;

    /**
     * @see FrontController::initContent()
     */
    public function initContent() {
        parent::initContent();
        $id_customer = (int) Tools::getValue('id_customer');
        $token = $this->module->makeToken($id_customer);
        if ($id_customer && (Tools::getValue('xtoken') == $token)) {
            $customer = new Customer((int) $id_customer);
            if (Validate::isLoadedObject($customer)) {
                Context::getContext()->updateCustomer($customer);

                Tools::redirect('index.php?controller=my-account');
            }
        }
        $this->setTemplate('module:allinonemanagement/views/templates/front/failed.tpl');
    }

}
