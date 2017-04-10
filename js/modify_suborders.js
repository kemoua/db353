function edit_suborders(id)
{
   var quantity=document.getElementById("quantity_val"+id).innerHTML;
   var cost = document.getElementById("cost_val"+id).innerHTML;

   
//create edit fields

  document.getElementById("cost_val"+id).innerHTML='<input type="number" id="cost_text'+id+'" value="'+cost+'">';
  document.getElementById("quantity_val"+id).innerHTML='<input type="number" id="quantity_text'+id+'" value="'+quantity+'">';
   
//display buttons
   document.getElementById("edit_butt_billing"+id).style.display="none";
   document.getElementById("save_butt_billing"+id).style.display="block";
   document.getElementById("cancel_butt_billing"+id).style.display="block";
   document.getElementById("delete_butt_billing"+id).style.display="none";
}

function cancel_edit_suborders(id){
  window.location.href = "suborders.php?projectid="+id;
}

function save_suborders(id)
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
   edit_suborders:'edit_suborders',
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
    window.location.href = "suborders.php?projectid="+project_id;
    // document.getElementById("actual_cost_val"+id).innerHTML=actual_cost;
    // document.getElementById("status_val"+id).innerHTML=status;
    // document.getElementById("start_date_val"+id).innerHTML=start_date;
    // document.getElementById("edit_button"+id).style.display="block";
    // document.getElementById("save_button"+id).style.display="none";
   }
  }
 });
}

function delete_suborders(id)
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
    window.location.href = "suborders.php?projectid="+project_id;
   }
  }

 });
 }
}

function create_suborders()
{
 var project_id=document.getElementById("new_project_id").value;
 var phase=document.getElementById("new_phase").value;
 var date_order=document.getElementById("new_date_order").value;
 var date_delivered=document.getElementById("new_date_delivered").value;
 var total_cost=document.getElementById("new_total_cost").value;
 
 // alert(client_id);
 // alert(status);
 // alert(start_date);
 // alert(complete_date);
 // alert(time_needed);
 // alert(title);
 // alert(type);
 // alert(budget);
 // alert(actual_cost);


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
          window.location.href = "suborders.php?projectid="+project_id;
        }
    }
   }
   
  }
 });
}
}
