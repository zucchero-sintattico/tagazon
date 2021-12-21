/**
 * Manager for switching page without reloading the whole page
 */
 class PageManager {

    /**
     * Name of resources class name
     */
    static #SRC_CLASSNAME = "current-src";

    static switchPage(page, callback = () => {}) {
        // PageManager.#clearBody();
        $("html").fadeOut(500, function() {
            PageManager.#removeResources();
            PageManager.#loadCSS(page)
            PageManager.#loadHTML(page, () => $("html").fadeIn(500));
        });
    }

    /**
     * Load HTML of the page in the body
     */
    static #loadHTML(page, callback) {
        $("body").load(
            page.url("html"),
            () => { PageManager.#loadJavascript(page); callback(); }
        );
    }

    /**
     * Load CSS of the page in the head
     */
    static #loadCSS(page, callback = () => {}) {
        const link = document.createElement("link");
        link.className = this.#SRC_CLASSNAME;
        link.rel = "stylesheet";
        link.href = page.url("css");
        link.onload = callback;
        $("head").append(link);
    }

    /**
     * Load javascript of the page in the head
     */
    static #loadJavascript(page) {
        const script = document.createElement("script");
        script.className = this.#SRC_CLASSNAME;
        script.src = page.url("js");
        script.defer = true;
        $("head").append(script);
    }

    /**
     * Remove all body tag content
     */
    static #clearBody() {
        $("body > *").remove();
    }

    /**
     * Remove resources from head tag based on class name
     */
    static #removeResources() {
        $("head > ." + this.#SRC_CLASSNAME).remove();
    }

}