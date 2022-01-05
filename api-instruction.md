# Tagazon API


## URLs

Url da inserire nelle richieste:
   - /tagazon/src/api/*


Deve sempre essere presente lo slash all'inizio e alla **fine**. 

Esempio:
```js
$.ajax({
    url: "/tagazon/src/api/**/"
    ...
})
```

---
## Risposta API
Ogni API restituisce lo stesso tipo di risposta che segue il seguente formato:
```json
{
    "code": "codice http",
    "message": "messaggio di errore/successo",
    "data": "array di oggetti"
}
```
Fare attenzione che **data** è sempre un array, quindi se si effettua una chiamata che restituirà un solo risultato per ottenerlo bisognerà estrarlo:
```js
let response = request(...)
let object = response["data"][0];
```

Quando si fa una chiamata alle api con $.ajax() **definire sempre la funzione success e la funzione error** che gestiranno le risposte.


È importante perchè il codice di risposta non è messo solo nel json restituito ma viene proprio settato come header della risposta, quindi nel caso di errore 404 non si attiverà la funzione **success** ma si attiverà quella di **error**.

**Entrambe le funzioni devono prendere come parametro la risposta**.

Nella **error** lasciare almeno una stampa della risposta.

Esempio:
```js
$.ajax({
    url: "/tagazon/src/api/**",
    ...
    success: function(response) {
        let data = response["data"]
        ...
    },
    error: function(response) {
        console.error(response);
    }
});
```

---
## Tipologie di richieste

Esistono 4 tipi di richieste alle API che si basano sui relativi 4 **metodi HTTP**:

  - **GET**: per le richieste di lettura
  - **POST**: per le richieste di scrittura
  - **PATCH**: per le richieste di modifica
  - **DELETE**: per le richieste di cancellazione

Specificare **sempre** nella richiesta **ajax** il `type` della 
richiesta scegliendo tra i 4 metodi sopracitati.

Esempio:
```js
$.ajax({
    url: "/tagazon/src/api/...",
    type: "GET"
    ...
})
```

---
## Richieste GET
Le richieste di tipo **GET** servono a leggere degli oggetti dal database.

Nelle richieste di tipo **GET** i parametri che possono essere passati sono:

  - **filtri**: 
     - `id = 1` 
     - `name = main`
  - **specifica ordinamento**: 
    - `orderBy = campo`

Il risultato sarà l'elenco dei risultati ordinati in base alla colonna specificata (di default ne è già specificata una per ogni oggetto).

Esempio richiesta di specifico tag filtrando sull'id:
```js
$.ajax({
    url: "/tagazon/src/api/objects/tags/?id=2",
    type: "GET"
    ...
})
```
Esempio tag ordinati per id (di default sono ordinate per nome):
```js
$.ajax({
    url: "/tagazon/src/api/objects/tags/?orderBy=id",
    type: "GET"
    ...
})
```

Nel caso si richieda un oggetto che non esista viene restituito **errore 404**, ad esempio

```js
$.ajax({
    url: "/tagazon/src/api/objects/tags/?name=untagacaso",
    type: "GET"
    ...
})
```  
restituirà:
```json
{
    "code": 404,
    "message": "Not found",
    "data": [ ]
}
```
poichè non esiste un tag con il nome `untagacaso`.


---
## Richieste POST

Nelle richieste di tipo POST **i campi passati devono essere almeno tutti quelli che non possono essere nulli dell'oggetto** che si vuole creare.

**La risposta delle richieste POST è l'oggetto appena creato** (ovviamente messo nell'array `data`).

Ad esempio se si vuole creare una nuova categoria, i campi richiesti sono:

  - `name`
  - `description`

La richiesta sarà quindi:

```js
$.ajax({
    url: "/tagazon/src/api/objects/categories/",
    type: "POST",
    data: {
        name: "categoriaX",
        description: "descrizione categoriaX"
    }
})
```
e la risposta sarà:
```json
{
    "code": 201,
    "message": "Created",
    "data": [{
        "id": 1,
        "name": "categoriaX",
        "description": "descrizione categoriaX"
    }]
}
```

---
## Richieste PATCH
La richiesta di tipo **PATCH** serve a modificare lo stato di un oggetto dentro al database. 

**I campi da specificare sono l'id dell'oggetto e i campi da modificare**.

**La risposta delle richieste PATCH non ha dati**.

Ad esempio se si vuole cambiare il nome di un tag la richiesta sarà:

```js
$.ajax({
    url: "/tagazon/src/api/objects/tags/",
    type: "PATCH",
    data: {
        id: X,
        name: "nuovoNome"
    }
})
```
e la risposta sarà:
```json
{
    "code": 200,
    "message": "Updated",
    "data": []
}
```
Il campo data in questo caso non contiene nessun' oggetto.

**Non è necessario specificare solo i campi da cambiare, ma è possibile passare l'intero oggetto alla richiesta.**

Ad esempio:
```js
let tag = getTagFromApi(...);
tag["name"] = "nuovoNome";
$.ajax({
    url: "/tagazon/src/api/objects/tags/",
    type: "PATCH",
    data: tag
})
```
Questo funziona poichè il campo data è un oggetto che contiene sia il campo `id` che è richiesto, sia tutti gli altri campi dell'oggetto che quindi andranno ad essere settati nuovamente.

---
## Richieste DELETE
La richiesta di tipo **DELETE** serve ad eliminare un oggetto dal database.

Nelle richieste di **DELETE**,  **l'unico parametro da passare è l'id dell'oggeto da eliminare**.

La risposta delle richieste **DELETE** non ha dati.

Ad esempio per eliminare un tag:
```js
$.ajax({
    url: "/tagazon/src/api/objects/tags/?id=2",
    type: "DELETE"
    ...
})
```
e la risposta sarà:
```json
{
    "code": 200,
    "message": "Deleted",
    "data": []
}
```

---
## Nested API
Esistono anche API nested, ovvero annidate che permettono di fare filtri speciali.

Sono accessibili tramite richieste di tipo **GET**.

Un esempio è l'API per ottenere i tag di una specifica categoria:
- `/tagazon/src/api/objects/categories/tags/`
  
che richiede come parametro `category_id` ovvero l'id della categoria su cui filtrare.

Esempio:
```js
$.ajax({
    url: "/tagazon/src/api/objects/categories/tags/?category_id=2",
    type: "GET"
    ...
})
```

Un altro esempio è:
- `/tagazon/src/api/objects/sellers/tags/`

che serve ad ottenere tutti i tag di un determinato venditore.

---
## Object's API and Feature's API
Tutte le chiamate ad API sopra mostrate erano riferite ad oggetti, ovvero entità del database.

Infatti l'url tipico era fatto nel seguente modo:

- `/tagazon/src/api/**objects**/**

Sono disponibili altre API che implementano delle feature e che quindi accettano tipologie di richieste differente ma soprattuto hanno dei parametri in ingresso che sono differenti e che variano da caso a caso.

Un esempio sono le API dell'utente quali la registrazione, il login, il recupero password, etc...

Ad esempio l'API per effettuare il login è 
- `/tagazon/src/api/**users**/login/`

come metodo va usato **POST** e richiede come parametri:
- `email`
- `password`

Esempio di login:
```js
$.ajax({
    url: "/tagazon/src/api/users/login/",
    type: "POST",
    data: {
        email: "email",
        password: "password"
    }
    ...
})
```

