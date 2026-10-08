

const importer_form = document.getElementById("importer-form");
const importer_input = document.getElementById("importer-input");

importer_form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const form = new FormData(importer_form);
    form.append("action", "importer");
    form.append("options", JSON.stringify({ action: $("#platform").val() ?? 'undefined', user: $("#user_id").val(), visibility: $("#visibility").val() }));

    if (form.get("blog_content").name == '') {
        kkMessgae.info("Please add a file!");
        return false;

    }
    buttonload("#start_import");
    importer_input.setAttribute("disabled", "true");

    try {
        const data = await apiConect(form);
        const response = await data.json();
        if (response.success) {
            kkMessgae.success(response.message);
            newStatusMessage($("#platform").val().toUpperCase(), response.message, 1);
        } else {
            kkMessgae.error(response.message);
            newStatusMessage($("#platform").val().toUpperCase(), response.message, 0);
            console.error(response.message);
        }

    } catch (error) {
        console.error(error);
    }
    importer_input.removeAttribute("disabled");
    buttonload("#start_import", 1, $("#start_import").attr("data-label"));
});


