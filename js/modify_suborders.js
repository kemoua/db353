function edit_suborders(id)
{
   var quantity=document.getElementById("quantity_val"+id).innerHTML;
   var cost = document.getElementById("cost_val"+id).innerHTML;

   
//create edit fields

  document.getElementById("cost_val"+id).innerHTML='<input type="number" id="cost_text'+id+'" value="'+cost+'">';
  document.getElementById("quantity_val"+id).innerHTML='<input type="number" id="quantity_text'+id+'" value="'+quantity+'">';
   
//display buttons
   document.getElementById("edit_butt_billing"+id).style.display="none";
   document.getElementById("save_button_billing"+id).style.display="block";
   document.getElementById("cancel_button_billing"+id).style.display="block";
   document.getElementById("delete_butt_billing"+id).style.display="none";
}

function cancel_edit_suborders(id){
  window.location.href = "suborders.php?projectid="+id;
}

function save_suborders(id,order)
{
 
var quantity=document.getElementById("quantity_text"+id).value;
var cost = document.getElementById("cost_text"+id).value;
  var project_id=document.getElementById("theprojectid").value;


 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   edit_suborders:'edit_suborders',
   sub_order_number_val:id,
   cost_val:cost,
   quantity_val:quantity
  },
  success:function(response) { 
   if(response=="success")
   { 
    window.location.href = "suborders.php?projectid="+project_id+"&order="+order;
   }
  }
 });
}

function delete_suborders(id,order_id)
{ 

  var project_id=document.getElementById("theprojectid").value;
  if(confirm("Do you really want to delete this Order?")){
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   delete_suborder:'delete_suborder',
   sub_order_number:id
  },
  success:function(response) {
   if(response=="success")
   {
    // var row=document.getElementById("row"+id);
    // row.parentNode.removeChild(row);
    window.location.href = "suborders.php?projectid="+project_id+"&order="+order_id;
   }
  }

 });
 }
}

function create_suborders()
{
  var project_id=document.getElementById("theprojectid").value;
 var order_number=document.getElementById("theorder").value;
 var cost=document.getElementById("new_cost").value;
 var quantity=document.getElementById("new_quantity").value;
 var item_id=document.getElementById("new_Item").value;
 


 if(confirm("Confirm SubOrder?")){
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   create_suborder:'create_suborder',
   order_number_val:order_number,
   cost_val:cost,
   quantity_val:quantity,
   item_id_val:item_id
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
          window.location.href = "suborders.php?projectid="+project_id+"&order="+order_number;
        }
    }
   }
   
  }
 });
}
}
