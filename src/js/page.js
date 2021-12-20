class Page {
    #basePath = "./pages"
    static HOME = new Page("home");
    static LOGIN = new Page("login");
    static REGISTER = new Page("register");
    
    constructor(name) {
        this.name = name
    }

    /**
     * @param {string} extension to chain at the end of the url
     * @returns the url of the file
     */
    url(extension) {
        return `${this.#basePath}/${this.name}/${this.name}.${extension}`;
    }
}