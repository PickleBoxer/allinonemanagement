/**
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
 *
 * Don't forget to prefix your containers with your own identifier
 * to avoid any conflicts with others containers.
 */
const { createApp } = Vue;

createApp({
  components: {
    "code-editor": CodeEditor,
  },
  //  The methods option is used to define the methods that can be called on a component's instance.
  methods: {
    setCurrentPage(currentPage) {
      this.currentPage = currentPage;
      const url = new URL(window.location);
      url.hash = "#" + currentPage;
      window.history.pushState({}, "", url);
    },
    toggleDevMode() {
      axios
        .post(
          window.configurationUrl,
          {
            action: "toggleDeveloperMode",
            enableStatus: this.devMode,
          },
          {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          }
        )
        .then((response) => {
          this.showLoader = false;
          if (response.data.hasError === false) {
            this.showSuccess(response.data.successMessage);
            //this.devMode = response.data.devMode;
          } else {
            this.showError(response.data.errorMessage);
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    toggleCriticalCss() {
      axios
        .post(
          window.configurationUrl,
          {
            action: "toggleCriticalCss",
            status: this.criticalCss,
          },
          {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          }
        )
        .then((response) => {
          this.showLoader = false;
          if (response.data.hasError === false) {
            this.showSuccess(response.data.successMessage);
          } else {
            this.showError(response.data.errorMessage);
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    applyOverrideChanges() {
      this.showLoader = true;
      axios
        .post(
          window.configurationUrl,
          {
            action: "applyOverrideChanges",
          },
          {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          }
        )
        .then((response) => {
          this.showLoader = false;
          if (response.data.hasError === false) {
            this.showSuccess(response.data.successMessage);
          } else {
            this.showError(response.data.errorMessage);
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    toggleDebugProfiling() {
      axios
        .post(
          window.configurationUrl,
          {
            action: "toggleDebugProfiling",
            enableStatus: this.debugProfiling,
          },
          {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          }
        )
        .then((response) => {
          this.showLoader = false;
          if (response.data.hasError === false) {
            this.showSuccess(response.data.successMessage);
          } else {
            this.showError(response.data.errorMessage);
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    toggleCustomCss() {
      axios
        .post(
          window.configurationUrl,
          {
            action: "toggleCustomCss",
            status: this.customCss,
          },
          {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          }
        )
        .then((response) => {
          this.showLoader = false;
          if (response.data.hasError === false) {
            this.showSuccess(response.data.successMessage);
            //this.devMode = response.data.devMode;
          } else {
            this.showError(response.data.errorMessage);
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    toggleCustomJs() {
      axios
        .post(
          window.configurationUrl,
          {
            action: "toggleCustomJs",
            status: this.customJs,
          },
          {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          }
        )
        .then((response) => {
          this.showLoader = false;
          if (response.data.hasError === false) {
            this.showSuccess(response.data.successMessage);
            //this.devMode = response.data.devMode;
          } else {
            this.showError(response.data.errorMessage);
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    toggleLoginAsCustomer() {
      axios
        .post(
          window.configurationUrl,
          {
            action: "toggleLoginAsCustomer",
            status: this.loginAsCustomer,
          },
          {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          }
        )
        .then((response) => {
          this.showLoader = false;
          if (response.data.hasError === false) {
            this.showSuccess(response.data.successMessage);
          } else {
            this.showError(response.data.errorMessage);
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    toggleFolderProtector() {
      axios
        .post(
          window.configurationUrl,
          {
            action: "toggleFolderProtector",
            status: this.folderProtector,
          },
          {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          }
        )
        .then((response) => {
          this.showLoader = false;
          if (response.data.hasError === false) {
            this.showSuccess(response.data.successMessage);
          } else {
            this.showError(response.data.errorMessage);
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    saveCustomCss() {
      // Get the edited code from the SimpleCodeEditor component using the 'value' prop
      const editedCssCode = editorCss.getValue();
      axios
        .post(
          window.configurationUrl,
          {
            action: "saveCustomCss",
            customCssValue: editedCssCode,
          },
          {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          }
        )
        .then((response) => {
          this.showLoader = false;
          if (response.data.hasError === false) {
            this.showSuccess(response.data.successMessage);
            //this.devMode = response.data.devMode;
          } else {
            this.showError(response.data.errorMessage);
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    saveCustomJs() {
      // Get the edited code from the SimpleCodeEditor component using the 'value' prop
      const editedJsCode = editorJs.getValue();
      axios
        .post(
          window.configurationUrl,
          {
            action: "saveCustomJs",
            customJsValue: editedJsCode,
          },
          {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          }
        )
        .then((response) => {
          this.showLoader = false;
          if (response.data.hasError === false) {
            this.showSuccess(response.data.successMessage);
            //this.devMode = response.data.devMode;
          } else {
            this.showError(response.data.errorMessage);
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    optimizeDatabase(table) {
      if (
        confirm("Do you really want to remove data from  " + table + " table?")
      ) {
        this.showLoader = true;
        axios
          .post(
            window.configurationUrl,
            {
              action: "optimizeDatabase",
              table: table,
            },
            {
              headers: {
                "Content-Type": "application/x-www-form-urlencoded",
              },
            }
          )
          .then((response) => {
            this.showLoader = false;
            this.showSuccess(response.data.successMessage);
          })
          .catch((error) => {
            console.error(error);
          });
      }
    },
    clearAllCache() {
      this.showLoader = true;
      axios
        .post(
          window.configurationUrl,
          {
            action: "clearAllCache",
          },
          {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          }
        )
        .then((response) => {
          this.showLoader = false;
          if (response.data.hasError === false) {
            this.showSuccess(response.data.successMessage);
          } else {
            this.showError(response.data.errorMessage);
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    toggleOverrideFile(event) {
      this.showLoader = true;
      // Get the override file name and status from the button data attributes
      const documentName = event.target.getAttribute("data-document");
      const status = event.target.getAttribute("data-status");
      console.log(documentName, status);
      // Send an AJAX request to toggle the document status
      axios
        .post(
          window.configurationUrl,
          {
            action: "toggleOverrideFileName",
            document_name: documentName,
          },
          {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          }
        )
        .then((response) => {
          this.showLoader = false;
          if (response.data.hasError === false) {
            this.showSuccess(response.data.successMessage);
            this.overrideFiles = response.data.overrideFiles;
          } else {
            this.showError(response.data.errorMessage);
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    showError(message) {
      Toastify({
        text: message,
        duration: 2000,
        close: true,
        gravity: "top",
        position: "right",
        style: {
          background: "#ff0000",
        },
        stopOnFocus: false,
      }).showToast();
    },
    showSuccess(message) {
      Toastify({
        text: message,
        duration: 2000,
        close: true,
        gravity: "top",
        position: "right",
        style: {
          background: "#1a8f35",
        },
        stopOnFocus: false,
      }).showToast();
    },
  },
  // The watch object watches for changes to properties and executes a function whenever the watched property changes.
  watch: {
    // Watch the devMode property
    devMode: function () {
      //this.saveSettings();
      this.showLoader = true;
      this.toggleDevMode();
    },
    // Watch the debugProfiling property
    debugProfiling: function () {
      //this.saveSettings();
      this.showLoader = true;
      this.toggleDebugProfiling();
    },
    // Watch the customCss property
    customCss: function () {
      //this.saveSettings();
      this.showLoader = true;
      this.toggleCustomCss();
    },
    // Watch the customJs property
    customJs: function () {
      //this.saveSettings();
      this.showLoader = true;
      this.toggleCustomJs();
    },
    // Watch the criticalCss property
    criticalCss: function () {
      //this.saveSettings();
      this.showLoader = true;
      this.toggleCriticalCss();
    },
    loginAsCustomer: function () {
      this.showLoader = true;
      this.toggleLoginAsCustomer();
    },
    folderProtector: function () {
      this.showLoader = true;
      this.toggleFolderProtector();
    },
  },
  // Mounted is a lifecycle hook that runs after the component has been mounted to the DOM.
  mounted() {
    this.timer = setInterval(() => {
      const url = new URL(window.location);
      if (
        url.hash.length > 0 &&
        url.hash.replace("#", "") !== this.currentPage
      ) {
        this.currentPage = url.hash.replace("#", "");
      }
    }, 100);
  },
  // The data option is used to define the data properties that are reactive and will be observed for changes.
  data() {
    return {
      isSaving: false,
      showLoader: false,
      currentPage: "dashboard",
      criticalCss: window.criticalCss,
      debugProfiling: window.debugProfiling,
      devMode: window.devMode,
      overrideFiles: window.overrideFiles,
      customCss: window.customCss,
      customJs: window.customJs,
      valueCss: window.customCssValue,
      valueJs: window.customJsValue,
      folderProtector: window.folderProtector,
      loginAsCustomer: window.loginAsCustomer,
      tablesToOptimize: window.tablesToOptimize,
    };
  },
}).mount("#app");

let editorCss = ace.edit("editorCss", {
  theme: "ace/theme/dracula",
  customScrollbar: true,
  mode: "ace/mode/css",
});
editorCss.session.setUseWrapMode(true);
editorCss.setValue(window.customCssValue);
let editorJs = ace.edit("editorJs", {
  theme: "ace/theme/dracula",
  customScrollbar: true,
  mode: "ace/mode/javascript",
});
editorJs.session.setUseWrapMode(true);
editorJs.setValue(window.customJsValue);
