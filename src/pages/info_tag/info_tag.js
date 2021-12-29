$(() => {
    const tag_id = new URLSearchParams(document.location.search).get("tag_id");

    $("h1").append(`#${tag_id}`);
});