import { Application } from "../../res/js/application.js";
import { NavbarSellerPage } from '../navbar-seller/navbar-seller.js';

export class SellerAddProductPage extends NavbarSellerPage {

    onPageLoad() {

        super.onPageLoad();
        const code = $("#tag-example")[0];
        const editor = CodeMirror.fromTextArea(code, {
            mode: "xml",
            theme: "idea",
            lineNumbers: true,
            autoCloseTags: true
        });


        if ($("textarea").length > 2) {
            const idCodeMirror = "tag-codemirror";
            $("textarea")[2].id = idCodeMirror;
            $(`<label for="${idCodeMirror}">Code Example</label>`).insertBefore($("textarea")[2]);
        }


        $("form").on("submit", (e) => {
            e.preventDefault();

            const categories = $("input[name='category']:checked").map((i, e) => e.id).get();

            const data = {
                name: $("#tag-name").val(),
                description: $("#tag-description").val(),
                example_desc: $("#tag-example-desc").val(),
                example: editor.getValue(),
                price: $("#tag-price").val(),
                sale_price: $("#tag-sale-price").val() != 0 ? $("#tag-sale-price").val() : null,
                categories: categories
            }

            $.ajax({
                url: "/tagazon/src/api/objects/tags/",
                method: "POST",
                data: data,
                success: (response) => {
                    window.location.href = "/tagazon/src/?page=seller-home";
                },
                error: (err) => { $("main>p").show(200); }
            });


        });
    }

    createCategory(category) {
        return `<li><input type="checkbox" name="category" id="${category.id}" value="${category.name}" ${category.id == 1 ? "checked": ""} /><label for="${category.id}">${category.name}</label></li>`;
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