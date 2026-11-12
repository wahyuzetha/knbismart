
<script>

  tinymce.init({
  selector: 'textarea',
  themes: 'modern',
  height: 200,
 // oninit : "setPlainText",
 paste_as_text: true,
 // plugins: "image media link paste",
// plugins: "image media link",
  plugins: "image media tiny_mce_wiris link code",
  //plugins : 'equation',
//toolbar:"tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry",
 
 image_class_list: [
    {title: 'Responsive', value: 'img-responsive'}
],
  toolbar: 'code underline bold italic sizeselect fontselect fontsizeselect | hr alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link media image | insertfile undo redo | forecolor backcolor emoticons | code | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry',
    fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
  file_picker_callback: function(callback, value, meta) {
    // File type
    if (meta.filetype =="media" || meta.filetype =="image") {

      // Trigger click on file element
      jQuery("#fileupload").trigger("click");
      $("#fileupload").unbind('change');
      // File selection
      jQuery("#fileupload").on("change", function() {
         var file = this.files[0];
         var reader = new FileReader();
		                
         // FormData
         var fd = new FormData();
         var files = file;
         fd.append("file",files);
         fd.append('filetype',meta.filetype);
         var filename = "";
		                
         // AJAX
	 jQuery.ajax({
    url: "../../inc/uploadimage.php",
	    type: "post",
	    data: fd,
	    contentType: false,
	    processData: false,
	    async: false,
	    beforeSend: function(){
	$('.page-loader-wrapper').show();
	},
	complete: function(){
	  	$('.page-loader-wrapper').hide();
   
	swal("Sukses", "Proses Upload Berhasil", "success");
	},
	error: function(){
	swal("Peringatan", "Koneksi Terputus, Silahkan cek jaringan anda", "warning");
    },
	    success: function(response){
	       filename = response;
            }
         });
		             
	 reader.onload = function(e) {
            callback("../../images/"+filename);
	 };
         reader.readAsDataURL(file);
       });
     }
		        
   }
 
  

});

  </script>
 