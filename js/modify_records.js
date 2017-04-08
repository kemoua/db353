function edit_row(id)
{
   // var project_id=document.getElementById("project_id_val"+id).innerHTML;
   var status=document.getElementById("status_val"+id).innerHTML;
   var start_date=document.getElementById("start_date_val"+id).innerHTML;
   var actual_cost=document.getElementById("actual_cost_val"+id).innerHTML;
   // document.getElementById("project_id_val"+id).innerHTML="<input type='text' id='project_id_text"+id+"' value='"+project_id+"'>";
   // document.getElementById("status_val"+id).innerHTML="<input type='text' id='status_text"+id+"' value='"+status+"'>";
   // var list = document.getElementById("status_val"+id);
   // var newOp = document.createElement("option");

   document.getElementById("actual_cost_val"+id).innerHTML='<input type="number" step="0.01" id="actual_cost_text'+id+'" value="'+actual_cost+'">';
   document.getElementById("status_val"+id).innerHTML="<select id='status_text"+id+"'></select>";
   var x = document.createElement("OPTION");
   x.setAttribute("value", "Analysis");
   var t = document.createTextNode("Analysis");
   x.appendChild(t);
   document.getElementById("status_text"+id).appendChild(x);
   x = document.createElement("OPTION"); 
    x.setAttribute("value", "In progress");
   t = document.createTextNode("In progress");
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

   document.getElementById("start_date_val"+id).innerHTML='<input type="date" id="start_date_text'+id+'" value="'+start_date+'">';

   document.getElementById("edit_button"+id).style.display="none";
   document.getElementById("save_button"+id).style.display="block";
}

function save_row(id)
{
 var actual_cost=document.getElementById("actual_cost_text"+id).value;
 var status=document.getElementById("status_text"+id).value;
 var start_date=document.getElementById("start_date_text"+id).value;
	
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   edit_row:'edit_row',
   row_id:id,
   actual_cost_val:actual_cost,
   status_val:status,
   start_date_val:start_date
  },
  success:function(response) {
    document.getElementById("result").value=response;
   if(response=="success")
   {
    document.getElementById("actual_cost_val"+id).innerHTML=actual_cost;
    document.getElementById("status_val"+id).innerHTML=status;
    document.getElementById("start_date_val"+id).innerHTML=start_date;
    document.getElementById("edit_button"+id).style.display="block";
    document.getElementById("save_button"+id).style.display="none";
   }
  }
 });
}

// function delete_row(id)
// {
//  $.ajax
//  ({
//   type:'post',
//   url:'modify_records.php',
//   data:{
//    delete_row:'delete_row',
//    row_id:id,
//   },
//   success:function(response) {
//     document.getElementById("result").value=response;
//    if(response=="success")
//    {
//     var row=document.getElementById("row"+id);
//     row.parentNode.removeChild(row);
//    }
//   }

//  });
// }

function create_project()
{
 if(confirm("Confirm Project")){
 var project_id=document.getElementById("new_project_id").value;
 var client_id=document.getElementById("new_client_id").value;
 var status=document.getElementById("new_status").value;
 var start_date=document.getElementById("new_start_date").value;
 var complete_date=document.getElementById("new_complete_date").value;
 var time_needed=document.getElementById("new_time_needed").value;
 var title=document.getElementById("new_title").value;
 var type=document.getElementById("new_type").value;
 var budget=document.getElementById("new_budget").value;
 var actual_cost=document.getElementById("new_actual_cost").value; 
 alert(project_id);
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   insert_row:'insert_row',
   project_id_val:project_id,
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
          document.getElementById("result").value="success";
          window.location.href = "home.php";
          // var id=response;
          // var table=document.getElementById("project_table");

          // var table_len=(table.rows.length)-1;
          
          // var row = table.insertRow(table_len).outerHTML="<tr id='row"+id+"'><td id='project_id_val"+id+"'>"+project_id+"</td><td id='status_val"+id+"'>"+status+"</td><td id='start_date_val"+id+"'>"+start_date+"</td><td><input type='button' class='edit_button' id='edit_button"+id+"' value='edit' onclick='edit_row("+id+");'/><input type='button' class='save_button' id='save_button"+id+"' value='save' onclick='save_row("+id+");'/><input type='button' class='delete_button' id='delete_button"+id+"' value='delete' onclick='delete_row("+id+");'/></td></tr>";

          //  document.getElementById("new_project_id").value="";
          //  document.getElementById("new_client_id").value="";
          //  document.getElementById("new_status").value="";
          //  document.getElementById("new_start_date").value="";
          //  document.getElementById("new_complete_date").value="";
          //  document.getElementById("new_time_needed").value="";
          //  document.getElementById("new_title").value="";
          //  document.getElementById("new_type").value="";
          //  document.getElementById("new_budget").value="";
          //  document.getElementById("new_actual_cost").value=""; 
        }
    }
   }
   
  }
 });
}
}