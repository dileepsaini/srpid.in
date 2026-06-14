let cuModal = $("#cuModal");
let form = cuModal.find("form");
const action = form[0] ? form[0].action : null;

$(document).on("click", ".cuModalBtn", function () {
    let data = $(this).data();
    let resource = data.resource ?? null;
    $(form).trigger("reset");
    $(form).find('textarea').text('');
    cuModal.find(".status").empty();

    if (!resource) {
        form[0].action = `${action}`;
        cuModal.find(".profilePicPreview").css("background-image", `url('')`);
    }

    cuModal.find(".modal-title").text(`${data.modal_title}`);

    if (resource) {
        form[0].action = `${action}/${resource.id}`;
        // If form has image
        if (resource.image_with_path) {
            cuModal
                .find(".profilePicPreview")
                .css("background-image", `url(${resource.image_with_path})`);
        }

        if (data.has_status) {
            cuModal.find(".status").html(`
                <div class="form-group">
                    <label>Status</label>
                    <input type="checkbox" data-width="100%" data-height="45" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="Enabled" data-off="Disabled" name="status">
                </div>
            `);
            cuModal.find("[name=status]").bootstrapToggle();
        }

        // Handle fields checkboxes first
        if (resource.fields) {
            const selectedFields = resource.fields.split(',').map(field => field.trim());
            $('input[name="fields[]"]').each(function() {
                $(this).prop('checked', selectedFields.includes($(this).val()));
            });
        }

        let fields = cuModal.find("input, select, textarea");
        let fieldName;

        fields.each(function (index, element) {
            fieldName = element.name;

            // Skip fields[] since we already handled it
            if (fieldName === "fields[]") return;

            if ($(element).hasClass('profilePicUpload')) {
                $(element).removeAttr('required');
            }

            // If input name is an array
            if (fieldName.substring(fieldName.length - 2) == "[]") {
                fieldName = fieldName.substring(0, fieldName.length - 2);
            }

            if (fieldName != "_token" && resource[fieldName]) {
                if (element.tagName == "TEXTAREA") {
                    if ($(element).hasClass("nicEdit")) {
                        $(".nicEdit-main").html(resource[fieldName]);
                    } else {
                        $(`[name='${fieldName}']`).text(resource[fieldName]);
                    }
                } else if ($(element).data("toggle") == "toggle") {
                    if (resource[fieldName] != 0) {
                        $(element).bootstrapToggle("on");
                    } else {
                        $(element).bootstrapToggle("off");
                    }
                } else if (element.type == "file") {
                    // Handle file inputs
                } else {
                    $(`[name='${element.name}']`).val(
                        $.isNumeric(resource[fieldName])
                            ? resource[fieldName] * 1
                            : resource[fieldName]
                    );
                }
            }
        });
    }

    if(resource){
        // Clear old custom fields
        cuModal.find(".show_custom_field").empty();

        // Check and render custom_field values
        if (resource.custom_field) {
            let fields = resource.custom_field.split(',');
            fields.forEach(function (value, index) {
                let fieldHtml = `
                    <div class=" custom-field-group mb-2">
                        <div class="form-group">
                            <label class="field-label">Field ${index + 1}</label>
                            <div class="input-group">
                            <input type="text" name="custom_field[]" class="form-control" value="${value.trim()}">
                            <button type="button" class="btn btn-danger remove-field">&times;</button>
                            </div>
                        </div>
                    </div>`;
                cuModal.find(".show_custom_field").append(fieldHtml);
            });
        }
    }
  
    cuModal.modal("show");
});