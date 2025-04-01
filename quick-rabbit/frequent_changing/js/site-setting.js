(function ($) {
  "use strict";
  let config = {
    extraPlugins: "codesnippet",
    editorplaceholder: "Content",
    codeSnippet_theme: "monokai_sublime",
    removeButtons:
      "SpecialChar,Source,Save,Preview,NewPage,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,RemoveFormat,CreateDiv,BidiLtr,BidiRtl,Language,Flash,Smiley,Iframe,Maximize,ShowBlocks,About",
  };
  CKEDITOR.config.allowedContent = true;
  CKEDITOR.addCss(
    ".cke_editable{color:#6e6b7b; font-size: 1rem;font-weight: 400; font-family: 'Public Sans', sans-serif;}"
  );
  CKEDITOR.replace("support_policy", config);
  $(document).on("click", ".open_modal_feature_icon", function (e) {
    openModal("logo");
    let img = $(this).attr("data-img");
    $("#image_body").html(
      `<img src="${app_url}/uploads/settings/${img}" alt="" class="img-responsive"  width="64px">`
    );
  });
  $(document).on("click", ".open_modal_image", function (e) {
    openModal("logo");
    let img = $(this).attr("data-img");
    $("#image_body").html(
      `<img src="${app_url}/uploads/settings/${img}" alt="" class="img-responsive"  width="100%">`
    );
  });

  $(document).on("change", ".ai_setting_type", function () {
    let val = $(this).val();
    console.log(val);
    if (val == "Yes") {
      $(".input_show_hide").removeClass("d-none");
    } else {
      $(".input_show_hide").addClass("d-none");
    }
  });

  $(document).on("click", ".open_modal_logo", function (e) {
    openModal("logo");
  });
  $(document).on("click", ".close_modal_logo", function (e) {
    closeModal("logo");
  });

  $(document).on("click", ".open_modal_footer_logo", function (e) {
    openModal("footer_logo");
  });
  $(document).on("click", ".close_modal_footer_logo", function (e) {
    closeModal("footer_logo");
  });

  $(document).on("click", ".open_modal_icon", function (e) {
    openModal("icon");
  });
  $(document).on("click", ".close_modal_icon", function (e) {
    closeModal("icon");
  });

  $(document).on("click", ".open_modal_banner_img", function (e) {
    openModal("banner_img");
  });
  $(document).on("click", ".close_modal_banner_img", function (e) {
    closeModal("banner_img");
  });
  $(document).on("click", ".open_modal_loader_image", function (e) {
    openModal("loader_image");
  });
  $(document).on("click", ".close_modal_loader_image", function (e) {
    closeModal("loader_image");
  });

  function counter() {
    let i = 1;
    $(".counter_sn_step").each(function (index, tr) {
      $(this).text(i);
      i++;
    });
    i = 1;
    $(".counter_sn_description").each(function (index, tr) {
      $(this).text(i);
      i++;
    });
  }
  $(document).on("click", ".add_more", function (e) {
    e.preventDefault();
    let step_lang = $(this).attr("data-step");
    let title_lang = $(this).attr("data-title");
    let description_lang = $(this).attr("data-description");
    let icon = $(this).attr("data-icon");

    let html =
      `<div class="row"><div class="clearfix"></div>
         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
             <div class="form-group">
                 <label class="step_title"> ` +
      step_lang +
      `-<span class="counter_sn_step"></span> ` +
      title_lang +
      `</label>
                 <input type="text" name="steps[]" required class="form-control" placeholder="` +
      step_lang +
      ` ` +
      title_lang +
      `" value="">
             </div>
         </div>
         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                                            <div class="form-group custom_table">
                                                <label>${icon} (48px X 48px, jpg,jpeg,png,svg, 2MB)</label>
                                                <table>
                                                    <tr>
                                                        <td class="ds_w_99_p">
                                                            <input tabindex="1" type="file" name="icon[]" class="form-control" accept=".jpg,.jpeg,.png, .svg">
                                                        </td>                                                        
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
             <div class="form-group">
                 <label class="step_description">` +
      step_lang +
      `-<span class="counter_sn_description"></span> ` +
      description_lang +
      `</label>
                 <textarea name="descriptions[]" required class="form-control" placeholder="` +
      step_lang +
      ` ` +
      description_lang +
      `"></textarea>
             </div>
             <a class="remove_div" href="#">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="22"></iconify-icon>
                                                </a>
         </div></div>`;

    $(".add_more_div").append(html);
    counter();
  });

  $(document).on("click", ".remove_div", function (e) {
    e.preventDefault();
    $(this).parent().parent().remove();
    counter();
  });

  counter();

  
})(jQuery);
