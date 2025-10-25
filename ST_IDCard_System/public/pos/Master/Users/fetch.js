
function loadTable(){ 
    // alert(expense);
     fetch('Master/Users/load-table.php')
     .then((data)=>{
     return data.json();
         
     }).then((objectdata)=>{
         
         
         let tabledata="";
         objectdata.map((values)=>{
             tabledata+=`<tr>
                                    <td>${values.Id}</th>
                                    <td>${values.UserId}</th>
                                    <td>${values.Name}</th>
                                    <td>${values.Email}</th> 
                                    <td>${values.Mobile}</th> 
                                    <td>${values.Password}</th>
                                
                                    <td><a href="#"  style="color:#1abc9c;" onclick="EditTemplateInspectionSettings(${values.Id})" data-toggle="modal" data-target="#modalManageState" > <i class="fa fa-pencil" style="color:#F43B48;"></i> </a >
                                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="#"  style="color:#1abc9c;" onclick="DeleteTemplateSettings(${values.Id})"> <i class="fa fa-trash" style="color:#f43b48;"></i> </a >

                                        
                                 </tr>`;
         })
         document.getElementById("tbody").innerHTML=tabledata;
     })       
     .catch((error) => {
        //  alert(response);
         //show_message('error',"Can't Fetch Data");
         //onclick="EditTemplateInspectionSettings(${values.Id})"
     });
     
 }
 
 loadTable("");
 function DeleteTemplateSettings(id) {
     
     Swal.fire({
         title: 'Are you sure?',
         text: "You won't be able to revert this!",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it!'
     }).then((result) => {
         if (result.value) {
          
       fetch('Master/Users/Delete.php?id='.concat(id))
     .then((data)=>{
         //alert(data.json);
         
     return data.json();
         
     }).then((objectdata)=>{
        
         if(result.insert == 'success'){
                    
                 Swal.fire(
                         'Deleted!',
                         'Template Detailed has been deleted.',
                         'success'
                     );
                  
                  
                 
                 }else{
                     show_message('error',"Data Can't Inserted.");
                     
                 }
                     
       
     })
     .catch((error) => {
      // alert(error);
         //show_message('error',"Can't Fetch Data");
     });
                Swal.fire(
                         'Deleted!',
                         'Template Detailed has been deleted.',
                         'success'
                     );       
        window.location.reload();
        
         }
     });
 }
 
 function EditTemplateInspectionSettings(id) {
 
    //  $("#modalManageState").modal("show");
      fetch('Master/Users/loadedit.php?id='.concat(id))
    
	.then((data)=>{
	    //alert(data.json);
	    //alert(id);
	return data.json();
	
	}).then((objectdata)=>{
	    document.getElementById("formStateAdd").reset();
	  // alert(objectdata[0].Name);
	    
	    $("#txtUserId").val(objectdata[0].UserId);
        $("#txtUsername").val(objectdata[0].Name);
        $("#txtEmail").val(objectdata[0].Email);
        $("#txtMobile").val(objectdata[0].Mobile);
        $("#txtPassword").val(objectdata[0].Password);
      
	      $("#hTranType").val(1);
	      $("#hID").val(id);
	    
	   // alert($("#hDate").val());
	  
	})
	.catch((error) => {
	    alert(error);
		//show_message('error',"Can't Fetch Data");
	});
  
 
 }
 
 function StateSave() {
                 var UserId = $("#txtUserId").val();
                 var Name = $("#txtUsername").val();
                 var Email = $("#txtEmail").val();
                 var Mobile = $("#txtMobile").val();
                 var Password = $("#txtPassword").val();
                
                 
                 var tranType = $("#hTranType").val();
                 var Id = $("#hID").val();
                   
               
 var formdata={
     'UserId':UserId,
     'Name':Name,
     'Email':Email,
     'Mobile' : Mobile,
     'Password':Password,
     
     'TranType':tranType,
     'Id':Id
 }
 jsondata=JSON.stringify(formdata);
//  alert(jsondata);
 fetch('Master/Users/save.php',{
     method:'POST',
     body:jsondata,
     header:{
         'Content-type':'application/json',
     }
 })
 .then((response) => response.json())
         .then((result)=>{
            // alert(response);
                 if(result.insert == 'success'){
                    
                  show_message('success','Data Inserted Successfully.');
                  document.getElementById("formStateAdd").reset();
                   loadTable("");
                   ShowPopUp();
                 
                 }
                 else if(result.insert == 'Duplicate'){
                     ShowPopUpDuplicate();
                 }
                 else{
                     show_message('error',"Data Can't Inserted.");
                     ShowPopUpError();
                 }
         })
         .catch((error) => {
             show_message('error',error);
         });
     
 
   

               
 }
 function show_message(type,text){
         var message_box ;
     if(type=='error'){
          message_box = document.getElementById('error-message');
     }
     else{
          message_box = document.getElementById('success-message');	
     }
     message_box.innerHTML = text;
     message_box.style.display = "block";
     setTimeout(function(){
         message_box.style.display = "none";
     },3000);
 }
 function ShowPopUp() {
     Swal.fire({
         icon: 'success',
         title: 'Congratulations',
         text: 'Operation Success!!'
     });
 }
 function ShowPopUpError() {
     Swal.fire({
         icon: 'warning',
         title: 'Opps!',
         text: 'Please Try Again'
     });
 }
  function ShowPopUpDuplicate() {
     Swal.fire({
         icon: 'warning',
         title: 'Opps!',
         text: 'User Already Exist!'
     });
 }
 function AlertPopUp() {
     Swal.fire({
         icon: 'Enter Correct Value',
         title: 'Enter Correct Value',
         text: 'Enter Correct Value!!'
     });
 }
 
 $(document).ready(function () {
        
     $("#btnState").on("click", function () {
          
      
            StateSave();
            
 
     });
     
     
      $("#btnSearch").on("click", function () {
          
         loadTable($("#txtSearchSid").val());
       
         
     });
      $("#modalclosed").on("click", function () {
          
         loadTable("");
       
         
     });
     $("#btnAddNew").on("click", function () {
          
       document.getElementById("formStateAdd").reset();
      // alert("jQURY wORKING");
        $("#hTranType").val(0);
    });
     
 });
