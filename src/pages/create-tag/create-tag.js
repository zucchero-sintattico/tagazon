$(document).ready(() => {
    var code = $("#tag-code")[0];
    var editor = CodeMirror.fromTextArea(code, {
        mode: "xml",
        theme: "idea",
        lineNumbers: true,
        autoCloseTags: true
    });
});