
$(document).ready(function() {
    $(".saveAjax").on("click", function () {
       var data = {
        content : tinyMCE.activeEditor.getContent()
    };
       result = callAjax('/root/save/', data);
            if (result.success == 1) {
                $(".update-status").text("Add success");
            }
    });
  
});

function callAjax(url, data) {
    result = "";
     $.ajax({
        url : url,
        type : "POST",
        data : data,
        async: false,
        dataType : "json",
        beforeSend: function() {
        },
        success: function(data) {
          result = data;
		  // neu muon check data
		  console.log(data);
        },
        error: function(error) {
            flg = false;
            console.log("fail");
        }
    });
    return result;
}
// return doan nay trong controller
//echo json_encode(array('success' => $flag));

