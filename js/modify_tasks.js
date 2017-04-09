function edit_task(id)
{

   var project_id=document.getElementById("project_id_val"+id).innerHTML; 
   var phase_id=document.getElementById("phase_id_val"+id).innerHTML; 
   var description=document.getElementById("description_val"+id).innerHTML; 
   var status=document.getElementById("status_val"+id).innerHTML;
   var start_date=document.getElementById("start_date_val"+id).innerHTML;
   var complete_date=document.getElementById("complete_date_val"+id).innerHTML;
   var time_needed=document.getElementById("time_needed_val"+id).innerHTML;
   var budget=document.getElementById("budget_val"+id).innerHTML;
   var cost=document.getElementById("cost_val"+id).innerHTML;
                       
   // document.getElementById("project_id_val"+id).innerHTML="<input type='text' id='project_id_text"+id+"' value='"+project_id+"'>";
   // document.getElementById("status_val"+id).innerHTML="<input type='text' id='status_text"+id+"' value='"+status+"'>";
   // var list = document.getElementById("status_val"+id);
   // var newOp = document.createElement("option");
   
//create edit fields
   document.getElementById("budget_val"+id).innerHTML='<input type="number" class="task_update" step="0.01" id="budget_text'+id+'" value="'+budget+'">';
   document.getElementById("cost_val"+id).innerHTML='<input type="number" class="task_update" step="0.01" id="cost_text'+id+'" value="'+cost+'">';
   document.getElementById("status_val"+id).innerHTML="<select id='status_text"+id+"'></select>";
   var x = document.createElement("OPTION");
   x.setAttribute("value", "Pending");
   var t = document.createTextNode("Pending");
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

   document.getElementById("description_val"+id).innerHTML='<input type="text" class="task_update" id="description_text'+id+'" value="'+description+'">';
   document.getElementById("time_needed_val"+id).innerHTML='<input type="text" class="task_update" id="time_needed_text'+id+'" value="'+time_needed+'">';

   document.getElementById("start_date_val"+id).innerHTML='<input type="date" class="task_update" id="start_date_text'+id+'" value="'+start_date+'">';
   document.getElementById("complete_date_val"+id).innerHTML='<input type="date" class="task_update" id="complete_date_text'+id+'" value="'+complete_date+'">';
//display buttons
   document.getElementById("edit_button"+id).style.display="none";
   document.getElementById("save_button"+id).style.display="block";
   document.getElementById("cancel_button"+id).style.display="block"; 

//hide delete button
  document.getElementsByClassName('deleteTask')[0].style.display="none";
}

function cancel_edit_task(id){
  window.location.href = "tasks.php?projectid="+id;
}

function save_task(id)
{
   var project_id=document.getElementById("project_id_val"+id).innerHTML; 
   var phase_id=document.getElementById("phase_id_val"+id).innerHTML; 
   var description=document.getElementById("description_text"+id).value; 
   var status=document.getElementById("status_text"+id).value;
   var start_date=document.getElementById("start_date_text"+id).value;
   var complete_date=document.getElementById("complete_date_text"+id).value;
   var time_needed=document.getElementById("time_needed_text"+id).value;
   var budget=document.getElementById("budget_text"+id).value;
   var cost=document.getElementById("cost_text"+id).value;

 if (description=="") {
  alert("Enter a description!");
  return;
 }

 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   edit_task:'edit_task',
   task_id:id,
   project_id_val:project_id,
   phase_id_val:phase_id,
   description_val:description,
   status_val:status,
   start_date_val:start_date,
   complete_date_val:complete_date,
   time_needed_val:time_needed,
   budget_val:budget,
   cost_val:cost
  },
  success:function(response) {
    document.getElementById("result").value=response;
   if(response=="success")
   {
    window.location.href = "tasks.php?projectid="+project_id;
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

function create_task()
{
 var project_id=document.getElementById("new_project_id").value;
 var phase_id=document.getElementById("new_phase_id").value;
 var start_date=document.getElementById("new_start_date").value;
 var complete_date=document.getElementById("new_complete_date").value;
 var time_needed=document.getElementById("new_time_needed").value;
 var description=document.getElementById("new_description").value;
 var status=document.getElementById("new_status").value;
 var budget=document.getElementById("new_budget").value;
 var cost=document.getElementById("new_cost").value;


 if (description=="") {
  alert("Enter a description!");
  return;
 }

 if(confirm("Confirm Task?")){
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   create_task:'create_task',
   project_id_val:project_id,
   phase_id_val:phase_id,
   status_val:status,
   start_date_val:start_date,
   complete_date_val:complete_date,
   time_needed_val:time_needed,
   description_val:description,
   budget_val:budget,
   cost_val:cost
  },
  success:function(response) {
   if(response=="error1062"){
    document.getElementById("result").value="ID already exists";
   } else {
    if (response=="error1366"){
      document.getElementById("result").value="Enter project";
    } else{
        if(response!=""){
          // document.getElementById("result").value=response;
          window.location.href = "tasks.php?projectid="+project_id;
        }
    }
   }
   
  }
 });
}
}
