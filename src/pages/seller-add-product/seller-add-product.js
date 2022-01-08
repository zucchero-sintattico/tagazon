import { Application } from "../../res/js/application.js";
import { NavbarSellerPage } from '../navbar-seller/navbar-seller.js';

export class SellerAddProductPage extends NavbarSellerPage {

    onPageLoad() {
        super.onPageLoad();
        let code = $("#tag-code")[0];
        CodeMirror.fromTextArea(code, {
            mode: "xml",
            theme: "idea",
            lineNumbers: true,
            autoCloseTags: true
        });
    
        // for accessibility
        const idCodeMirror = "tag-codemirror";
        $("textarea")[2].id = idCodeMirror;
        $(`<label for="${idCodeMirror}">Code Example</label>`).insertBefore($("textarea")[2]);
        
        $("#form-submit").on("click", () => {
            //TODO make post here
        });
    }

    createCategory(category) {
        return `<li><input type="checkbox" name="category" id="${category.id}" value="${category.name}" /><label for="${category.id}">${category.name}</label></li>`;
    }

    onUserLoad() {
        super.onUserLoad();

        $.ajax({
            url: "./api/objects/categories",
            method: "GET",
            success: (response) => {
                const { data } = response;
                data.forEach(category => {
                    $("#category-list").append(this.createCategory(category));
                });
            },
            error: (err) => { console.log(err); }
        })
    }
    
}