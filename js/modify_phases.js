function edit_phase(id)
{
   var project_id=document.getElementById("project_id_val"+id).innerHTML;
   var status=document.getElementById("status_val"+id).innerHTML;
   var start_date=document.getElementById("start_date_val"+id).innerHTML;
   var actual_cost=document.getElementById("actual_cost_val"+id).innerHTML;
   var budget=document.getElementById("budget_val"+id).innerHTML;
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
   x.setAttribute("value", "Design");
   var t = document.createTextNode("Design");
   x.appendChild(t);
   document.getElementById("status_text"+id).appendChild(x);
   x = document.createElement("OPTION"); 
    x.setAttribute("value", "Pre-Construction");
   t = document.createTextNode("Pre-Construction");
   x.appendChild(t);
   document.getElementById("status_text"+id).appendChild(x);
   x = document.createElement("OPTION"); 
    x.setAttribute("value", "Procurement");
   t = document.createTextNode("Procurement");
   x.appendChild(t);
   document.getElementById("status_text"+id).appendChild(x);
   x = document.createElement("OPTION"); 
    x.setAttribute("value", "Construction");
   t = document.createTextNode("Construction");
   x.appendChild(t);
   document.getElementById("status_text"+id).appendChild(x);
   x = document.createElement("OPTION"); 
   x.setAttribute("value", "Owner Occupancy");
   t = document.createTextNode("Owner Occupancy");
   x.appendChild(t);
   document.getElementById("status_text"+id).appendChild(x);
   x = document.createElement("OPTION"); 
   x.setAttribute("value", "Closeout");
   t = document.createTextNode("Closeout");
   x.appendChild(t);
   document.getElementById("status_text"+id).appendChild(x);

   document.getElementById("time_needed_val"+id).innerHTML='<input type="text" id="time_needed_text'+id+'" value="'+time_needed+'">';

   document.getElementById("start_date_val"+id).innerHTML='<input type="date" id="start_date_text'+id+'" value="'+start_date+'">';
   document.getElementById("complete_date_val"+id).innerHTML='<input type="date" id="complete_date_text'+id+'" value="'+complete_date+'">';
//display buttons
   document.getElementById("edit_button"+id).style.display="none";
   document.getElementById("save_button"+id).style.display="block";
   document.getElementById("cancel_button"+id).style.display="block";
 
}

function cancel_edit_phase(id){
  window.location.href = "phases.php?projectid="+id;
}

function save_phase(id)
{
   var project_id=document.getElementById("project_id_val"+id).innerHTML; 
   var status=document.getElementById("status_text"+id).value;
   var start_date=document.getElementById("start_date_text"+id).value;
   var complete_date=document.getElementById("complete_date_text"+id).value;
   var time_needed=document.getElementById("time_needed_text"+id).value;
   var budget=document.getElementById("budget_text"+id).value;
   var actual_cost=document.getElementById("actual_cost_text"+id).value;

 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   edit_phase:'edit_phase',
   phase_id:id,
   project_id_val:project_id,
   status_val:status,
   start_date_val:start_date,
   complete_date_val:complete_date,
   time_needed_val:time_needed,
   budget_val:budget,
   actual_cost_val:actual_cost
  },
  success:function(response) {
    document.getElementById("result").value=response;
   if(response=="success")
   {
    window.location.href = "phases.php?projectid="+project_id;
   }
  }
 });
}

// function delete_project(id)
// {
//   if(confirm("Do you really want to delete this project?")){
//  $.ajax
//  ({
//   type:'post',
//   url:'modify_records.php',
//   data:{
//    delete_project:'delete_project',
//    project_id:id,
//   },
//   success:function(response) {
//    if(response=="success")
//    {
//     // var row=document.getElementById("row"+id);
//     // row.parentNode.removeChild(row);
//     window.location.href = "home.php";
//    }
//   }

//  });
//  }
// }

function create_phase()
{
 var project_id=document.getElementById("new_project_id").value;
 var start_date=document.getElementById("new_start_date").value;
 var complete_date=document.getElementById("new_complete_date").value;
 var time_needed=document.getElementById("new_time_needed").value;
 var status=document.getElementById("new_status").value;
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
 // if (title=="") {
 //  alert("Enter a title!");
 //  return;
 // }

 if(confirm("Confirm Phase?")){
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   create_phase:'create_phase',
   project_id_val:project_id,
   status_val:status,
   start_date_val:start_date,
   complete_date_val:complete_date,
   time_needed_val:time_needed,
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
          window.location.href = "phases.php?projectid="+project_id;
        }
    }
   }
   
  }
 });
} 
} 
 