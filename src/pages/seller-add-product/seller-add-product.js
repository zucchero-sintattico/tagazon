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
        
    }
    
}