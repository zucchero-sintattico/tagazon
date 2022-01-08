import { Application } from '../../res/js/application.js';
import { NavbarPage } from '../navbar/navbar.js';

export class NotificationsPage extends NavbarPage {

    createArticle(notification) {
        /*
        <article>
            <header>
                <button>Chiudi</button>
                <h2>Ordine Ricevuto</h2>
            </header>
            <p>testo della notifica</p>
            <footer>
                <p>Data della notifica</p>
            </footer>
        </article>
        */
        const article = document.createElement("article");
        article.ariaRoleDescription = "button"; /* for screen readers */

        /* event on click of all article */
        article.addEventListener(
            "click",
            () => {
                window.location.href = `./?page=info_tag&tag_id=${notification.tag.id}`
            }
        );

        /* header */
        const header = document.createElement("header");

        const deleteButton = document.createElement("button");
        deleteButton.innerText = "Elimina";
        deleteButton.addEventListener("click", (e) => {
            e.stopPropagation();
            Application.notification.deleteNotification(notification.id);
        });

        const h2 = document.createElement("h2");
        h2.innerText = notification.title;

        header.appendChild(deleteButton);
        header.appendChild(h2);

        /* middle */
        const p = document.createElement("p");
        p.innerText = notification.message;

        /* footer */
        const footer = document.createElement("footer");

        const date = document.createElement("p");
        date.innerText = notification.timestamp;

        footer.appendChild(date);

        article.appendChild(header);
        article.appendChild(p);
        article.appendChild(footer);

        return article;
    }

    onNotificationsChange() {
        super.onNotificationsChange();
        $("main").html("");
        Application.notifications.forEach((notification) => {
            const article = this.createArticle(notification);
            $("main").prepend(article);
        });
    }
}