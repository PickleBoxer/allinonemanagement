<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<style type="text/css" media="screen">
    #editor {
        margin: 0;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
</style>

{literal}
    <div id="app" data-v-app="" class="allinone-content-container">
        <div id="loader-container" :class="(isSaving == true || showLoader == true) ? 'visible' : ''">
            <div class="loader"></div>
        </div>
        <div class="panel panel-account-info">
            <h1>Critical CSS Editor</h1>
            <p>The Critical CSS Editor page allows you to view and edit the critical CSS files for each page on your
                website.
                The page displays a list of all the critical CSS files, along with a dropdown menu that allows you to select
                a
                file to edit. Once you select a file, the contents of the file are displayed in a textarea, where you can
                make
                changes to the CSS code.</p>
            <p>The Critical CSS Editor page is a powerful tool that allows you to quickly and easily edit the critical CSS
                files
            for your website. With this tool, you can optimize your website's performance by fine-tuning the critical
            CSS
            code for each page.</p>
        <div class="alert alert-info">Note: You can paste CSS generated from other sources here, but please be aware
            that any changes made to the page or cache cleared will override your changes.</div>
        <div class="alert alert-warning">Please be careful when editing the file and make sure the code is correct
            before saving.</div>
        <!-- Create a form with a select dropdown to choose the file -->
        <form method="post" action="" @submit.prevent="saveChanges">
            <label for="file-select">Select a file:</label>
            <select id="file-select" name="file" @change="onFileSelect" style="border: solid 0.0625rem currentColor;">
                <option>Select</option>
                <option v-for="(content, file) in filesWithContent" :value="file">{{ file }}</option>
            </select>
            <br>

            <!-- Display the content of the selected file -->
            <div style="position:relative;height:300px;overflow:auto;resize:vertical;border: 0.0625rem solid currentcolor;">
                <div id="editor"></div>
            </div>

            <br>

            <!-- Add a submit button to save the changes -->
            <div class="text-right">
                <input class="button" type="submit" value="Save Changes">
            </div>
        </form>
    </div>
</div>
{/literal}

<script src="/modules/allinonemanagement/views/js/lib/vue@3.2.6.prod.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/ace-builds@1.22.0/src-min-noconflict/ace.min.js"></script>
<script>
    const { createApp } = Vue;

    createApp({
        data() {
            return {
                isSaving: false,
                showLoader: false,
                filesWithContent: window.filesWithContent,
                fileContent: '',
            };
        },
        methods: {
            onFileSelect() {
                // Get the selected file
                const selectedFile = document.getElementById('file-select').value;

                // If the selected file is "Select", clear the textarea
                if (selectedFile == 'Select') {
                    this.fileContent = '';
                    editor.setValue('');
                } else {
                    // Otherwise, get the content of the selected file and set it as the textarea value
                    this.fileContent = this.filesWithContent[selectedFile];
                    editor.setValue(this.filesWithContent[selectedFile]);
                }
            },
            saveChanges() {
                this.showLoader = true;
                // Get the selected file
                const selectedFile = document.getElementById('file-select').value;
                // Get the content of the selected file
                const content = editor.getValue();

                // Send a POST request to save the changes
                axios.post(window.configurationUrl, {
                        action: 'saveChanges',
                        file: selectedFile,
                        content: content,
                    }, {
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                    })
                    .then(response => {
                        this.showLoader = false;
                        // Show a success message
                        if (response.data.hasError === false) {
                            this.showSuccess(response.data.successMessage);
                            this.filesWithContent = response.data.filesWithContent;
                        } else {
                            this.showError(response.data.errorMessage);
                        }
                    })
                    .catch((error) => {
                        this.showLoader = false;
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
    }).mount("#app");
</script>
<script>
    let editor = ace.edit("editor", {
        theme: "ace/theme/dracula",
        customScrollbar: true,
        mode: "ace/mode/css",
    });
    editor.session.setUseWrapMode(true);
</script>