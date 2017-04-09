function edit_project(id)
{
   //var project_id=document.getElementById("project_id_val"+id).innerHTML;
   var status=document.getElementById("status_val"+id).innerHTML;
   var start_date=document.getElementById("start_date_val"+id).innerHTML;
   var actual_cost=document.getElementById("actual_cost_val"+id).innerHTML;
   var client_id=document.getElementById("client_id_val"+id).innerHTML;
   var budget=document.getElementById("budget_val"+id).innerHTML;
   var type=document.getElementById("type_val"+id).innerHTML;
   var time_needed=document.getElementById("time_needed_val"+id).innerHTML;
   var complete_date=document.getElementById("complete_date_val"+id).innerHTML;
   // document.getElementById("project_id_val"+id).innerHTML="<input type='text' id='project_id_text"+id+"' value='"+project_id+"'>";
   // document.getElementById("status_val"+id).innerHTML="<input type='text' id='status_text"+id+"' value='"+status+"'>";
   // var list = document.getElementById("status_val"+id);
   // var newOp = document.createElement("option");
   
//create edit fields
   document.getElementById("budget_val"+id).innerHTML='<input type="number" step="0.01" id="budget_text'+id+'" value="'+budget+'">';
   document.getElementById("actual_cost_val"+id).innerHTML='<input type="number" step="0.01" id="actual_cost_text'+id+'" value="'+actual_cost+'">';
   document.getElementById("status_val"+id).innerHTML="<select id='status_text"+id+"'></select>";
   var x = document.createElement("OPTION");
   x.setAttribute("value", "Analysis");
   var t = document.createTextNode("Analysis");
   x.appendChild(t);
   document.getElementById("status_text"+id).appendChild(x);
   x = document.createElement("OPTION"); 
    x.setAttribute("value", "In Progress");
   t = document.createTextNode("In Progress");
   x.appendChild(t);
   document.getElementById("status_text"+id).appendChild(x);
   x = document.createElement("OPTION"); 
    x.setAttribute("value", "Completed");
   t = document.createTextNode("Completed");
   x.appendChild(t);
   document.getElementById("status_text"+id).appendChild(x);
   x = document.createElement("OPTION"); 
    x.setAttribute("value", "Cancelled");
   t = document.createTextNode("Cancelled");
   x.appendChild(t);
   document.getElementById("status_text"+id).appendChild(x); 


   document.getElementById("type_val"+id).innerHTML="<select id='type_text"+id+"'></select>";
   x = document.createElement("OPTION");
   x.setAttribute("value", "Condo");
   t = document.createTextNode("Condo");
   x.appendChild(t);
   document.getElementById("type_text"+id).appendChild(x);
   x = document.createElement("OPTION"); 
    x.setAttribute("value", "House");
   t = document.createTextNode("House");
   x.appendChild(t);
   document.getElementById("type_text"+id).appendChild(x);

   document.getElementById("time_needed_val"+id).innerHTML='<input type="text" id="time_needed_text'+id+'" value="'+time_needed+'">';

   document.getElementById("start_date_val"+id).innerHTML='<input type="date" id="start_date_text'+id+'" value="'+start_date+'">';
   document.getElementById("complete_date_val"+id).innerHTML='<input type="date" id="complete_date_text'+id+'" value="'+complete_date+'">';
//display buttons
   document.getElementById("edit_button"+id).style.display="none";
   document.getElementById("save_button"+id).style.display="block";
   document.getElementById("cancel_button"+id).style.display="block";
}

function cancel_edit_project(id){
  window.location.href = "project.php?projectid="+id;
}

function save_project(id)
{
 var actual_cost=document.getElementById("actual_cost_text"+id).value;
 var status=document.getElementById("status_text"+id).value;
 var start_date=document.getElementById("start_date_text"+id).value;
 var budget=document.getElementById("budget_text"+id).value;
 var type=document.getElementById("type_text"+id).value;
 var time_needed=document.getElementById("time_needed_text"+id).value;
 var complete_date=document.getElementById("complete_date_text"+id).value;

 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   edit_project:'edit_project',
   row_id:id,
   actual_cost_val:actual_cost,
   status_val:status,
   start_date_val:start_date,
   budget_val:budget,
   type_val:type,
   time_needed_val:time_needed,
   complete_date_val:complete_date
  },
  success:function(response) {
    document.getElementById("result").value=response;
   if(response=="success")
   {
    window.location.href = "project.php?projectid="+id;
    // document.getElementById("actual_cost_val"+id).innerHTML=actual_cost;
    // document.getElementById("status_val"+id).innerHTML=status;
    // document.getElementById("start_date_val"+id).innerHTML=start_date;
    // document.getElementById("edit_button"+id).style.display="block";
    // document.getElementById("save_button"+id).style.display="none";
   }
  }
 });
}

function delete_project(id)
{
  if(confirm("Do you really want to delete this project?")){
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   delete_project:'delete_project',
   project_id:id,
  },
  success:function(response) {
   if(response=="success")
   {
    // var row=document.getElementById("row"+id);
    // row.parentNode.removeChild(row);
    window.location.href = "home.php";
   }
  }

 });
 }
}

function create_project()
{
 var client_id=document.getElementById("new_client_id").value;
 var status=document.getElementById("new_status").value;
 var start_date=document.getElementById("new_start_date").value;
 var complete_date=document.getElementById("new_complete_date").value;
 var time_needed=document.getElementById("new_time_needed").value;
 var title=document.getElementById("new_title").value;
 var type=document.getElementById("new_type").value;
 var budget=document.getElementById("new_budget").value;
 var actual_cost=document.getElementById("new_actual_cost").value;
 // alert(client_id);
 // alert(status);
 // alert(start_date);
 // alert(complete_date);
 // alert(time_needed);
 // alert(title);
 // alert(type);
 // alert(budget);
 // alert(actual_cost);
 if (title=="") {
  alert("Enter a title!");
  return;
 }

 if(confirm("Confirm Project?")){
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   create_project:'create_project',
   client_id_val:client_id,
   status_val:status,
   start_date_val:start_date,
   complete_date_val:complete_date,
   time_needed_val:time_needed,
   title_val:title,
   type_val:type,
   budget_val:budget,
   actual_cost_val:actual_cost
  },
  success:function(response) {
   if(response=="error1062"){
    document.getElementById("result").value="ID already exists";
   } else {
    if (response=="error1366"){
      document.getElementById("result").value="Enter project";
    } else{
        if(response!=""){
          document.getElementById("result").value=response;
          window.location.href = "home.php";
        }
    }
   }
   
  }
 });
}
}

function create_client()
{
 if(confirm("Confirm New Client?")){
 var client_id=document.getElementById("new_client_id").value; 
 var first_name=document.getElementById("new_first_name").value;
 var last_name=document.getElementById("new_last_name").value;
 var civic_number=document.getElementById("new_civic_number").value;
 var street=document.getElementById("new_street").value;
 var postal_code=document.getElementById("new_postal_code").value;
 var country=document.getElementById("new_country").value;
 var city=document.getElementById("new_city").value;
 var phone=document.getElementById("new_phone").value;
 var username=document.getElementById("new_username").value;
 var password=document.getElementById("new_password").value;

if (phone=="") {
  alert("Enter a Phone number!");
  return;
 }
 
 if (username=="") {
  alert("Enter a username!");
  return;
 }

 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   create_client:'create_client',
   client_id_val:client_id,
   first_name_val:first_name,
   last_name_val:last_name,
   civic_number_val:civic_number,
   street_val:street,
   postal_code_val:postal_code,
   country_val:country,
   city_val:city,
   phone_val:phone,
   username_val:username,
   password_val:password
  },
  success:function(response) {
   if(response=="error1062"){
    document.getElementById("result").value="Not unique";
   } else {
    if (response=="error1366"){
      document.getElementById("result").value="Incorrect string value";
    } else{
        if(response!=""){
          document.getElementById("result").value="success";
          window.location.href = "home.php";
        }
    }
   }
   
  }
 });
}
}