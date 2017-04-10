function edit_billing(id)
{
   //var project_id=document.getElementById("project_id_val"+id).innerHTML;
   var status=document.getElementById("status_val"+id).innerHTML;
   var total_cost = document.getElementById("total_cost_val"+id).innerHTML;
   var date_order = document.getElementById("date_order_val"+id).innerHTML;
   
//create edit fields
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

   document.getElementById("total_cost_val"+id).innerHTML='<input type="text" id="total_cost_text'+id+'" value="'+total_cost+'">';

   document.getElementById("date_order_val"+id).innerHTML='<input type="date" id="date_order_text'+id+'" value="'+date_order+'">';
   
//display buttons
   document.getElementById("edit_butt_billing"+id).style.display="none";
   document.getElementById("save_button_billing"+id).style.display="block";
   document.getElementById("cancel_button_billing"+id).style.display="block";
   document.getElementById("delete_butt_billing"+id).style.display="none";
}

function cancel_edit_billing(id){
  window.location.href = "billing.php?projectid="+id;
}

function save_billing(id)
{
var status=document.getElementById("status_text"+id).value;
var total_cost = document.getElementById("total_cost_text"+id).value;
var date_order = document.getElementById("date_order_text"+id).value;
var project_id=document.getElementById("theprojectid").value;

 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   edit_billing:'edit_billing',
   order_number_val:id,
   total_cost_val:total_cost,
   status_val:status,
   date_order_val:date_order,
   project_id_val:project_id
  },
  success:function(response) {
    // document.getElementById("result").value=response;
   if(response=="success")
   {
    window.location.href = "billing.php?projectid="+project_id;
    // document.getElementById("actual_cost_val"+id).innerHTML=actual_cost;
    // document.getElementById("status_val"+id).innerHTML=status;
    // document.getElementById("start_date_val"+id).innerHTML=start_date;
    // document.getElementById("edit_button"+id).style.display="block";
    // document.getElementById("save_button"+id).style.display="none";
   }
  }
 });
}

function delete_billing(id)
{
  var project_id=document.getElementById("theprojectid").value;
  if(confirm("Do you really want to delete this Order?")){
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   delete_order:'delete_order',
   order_number:id
  },
  success:function(response) {
   if(response=="success")
   {
    // var row=document.getElementById("row"+id);
    // row.parentNode.removeChild(row);
    window.location.href = "billing.php?projectid="+project_id;
   }
  }

 });
 }
}

function create_billing()
{
 var project_id=document.getElementById("new_project_id").value;
 var phase=document.getElementById("new_phase").value;
 var date_order=document.getElementById("new_date_order").value;
 var date_delivered=document.getElementById("new_date_delivered").value;
 var total_cost=document.getElementById("new_total_cost").value;
 // alert(project_id);
 alert(phase);
 // alert(date_order);
 // alert(date_delivered);
 // alert(total_cost);

 if(confirm("Confirm Order?")){
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   create_order:'create_order',
   project_id_val:project_id,
   phase_val:phase,
   date_order_val:date_order,
   date_delivered_val:date_delivered,
   total_cost_val:total_cost
  },
  success:function(response) {
   if(response=="error1062"){
    // document.getElementById("result").value="ID already exists";
   } else {
    if (response=="error1366"){
      // document.getElementById("result").value="Enter project";
    } else{
        if(response!=""){
          // document.getElementById("result").value=response;
          window.location.href = "billing.php?projectid="+project_id;
        }
    }
   }
   
  }
 });
}
}
