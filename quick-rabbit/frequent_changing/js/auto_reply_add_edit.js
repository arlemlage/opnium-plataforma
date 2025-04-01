(function($){
    "use strict";

    let config = {
         removeButtons: 'HorizontalRule,Anchor,Image,Maximize,Styles,Indent,Table,Format,SpecialChar,Source,Save,Preview,NewPage,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,RemoveFormat,CreateDiv,BidiLtr,BidiRtl,Language,Flash,Smiley,Iframe,ShowBlocks,About',
    };
    CKEDITOR.config.allowedContent = true;
    CKEDITOR.replace('answer', config);


})(jQuery);
